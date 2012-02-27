<?php

namespace Aspect;

require_once 'Autoloader.php';

/**
 * Aspect framework configuration loading
 */
class Configuration
{

    const PATH_SEPARATOR = ',';

    private static $instance;

    protected $data;

    protected $configurationFile;

    /**
     * @var string The base path for the application
     */
    protected $basePath;

    /**
     * Returns an instance of the class
     * @return Aspect\Configuration
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Load a configuration file
     * @param string $configurationFile
     */
    public function load($configurationFile)
    {
        if (! (file_exists($configurationFile) && is_readable($configurationFile))) {
            throw new \Exception("Configuration file $configurationFile doesn't exist or is not readable");
        }
        $this->configurationFile = $configurationFile;
        $this->basePath = dirname(realpath($this->configurationFile));
        // Read ini file
        $this->data = parse_ini_file($this->configurationFile);
        $this->data = $this->validateData($this->data);

        // Autoloader
        if ((bool) $this->data['autoloader.enable']) {
            $autoloader = \Aspect\Autoloader::getInstance();
            // Autoloader paths
            $paths = explode(self::PATH_SEPARATOR, $this->data['autoloader.paths']);
            $nb = 0;
            foreach ($paths as $autoloaderPath) {
                $autoloaderPath = trim($autoloaderPath);
                $autoloaderPath = realpath($this->basePath . DIRECTORY_SEPARATOR . $autoloaderPath);
                $autoloaderPath = trim($autoloaderPath);
                if ($autoloaderPath != '') {
                    $autoloader->addPath($autoloaderPath);
                    $nb++;
                }
            }
            if ($nb == 0) {
                throw new \Exception("Configuration item 'autoloader.paths' is empty");
            }
            $autoloader->setCacheDir($this->data['cache.directory']);
            $autoloader->setAspectEnabled((bool) $this->data['aspect.enabled']);
            $autoloader->register();
        }
    }

    public function getConfigurationValue($name)
    {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        } else {
            throw new \Exception("The configuration item '$name' doesn't exist");
        }
    }

    /**
     * Validate the configuration file
     * @param array $data Data read by parse_ini_file
     * @return array The validated data
     * @throws Exception If the configuration file is invalid
     */
    protected function validateData(array $data)
    {
        if (! isset($data['autoloader.enable'])) {
            throw new \Exception("Error in Aspect configuration file: 'autoloader.enable' must be defined");
        }
        if (! isset($data['aspect.enabled'])) {
            throw new \Exception("Error in Aspect configuration file: 'aspect.enabled' must be defined");
        }
        if (! isset($data['autoloader.paths'])) {
            throw new \Exception("Error in Aspect configuration file: 'autoloader.paths' must be defined");
        }
        if (! isset($data['cache.directory'])) {
            throw new \Exception("Error in Aspect configuration file: 'cache.directory' must be defined");
        }
        // Fix cache directory
        $data['cache.directory'] = realpath($this->basePath . DIRECTORY_SEPARATOR . $data['cache.directory']);
        if (! file_exists($data['cache.directory'])) {
            throw new \Exception("Error in Aspect configuration file: "
                . "the directory '" . $data['cache.directory'] . "' doesn't exist");
        }
        if (! isset($data['cache.enable'])) {
            $data['cache.enable'] = true;
        }
        if (! isset($data['php.executable'])) {
            throw new \Exception("Error in Aspect configuration file: 'php.executable' must be defined");
        }
        if (! isset($data['compiler.filename'])) {
            throw new \Exception("Error in Aspect configuration file: 'compiler.filename' must be defined");
        }
        // Fix compiler directory: make it absolute
        $data['compiler.filename'] = realpath($this->basePath . DIRECTORY_SEPARATOR . $data['compiler.filename']);
        if (! file_exists($data['compiler.filename'])) {
            throw new \Exception("Error in Aspect configuration file: "
                . "the file '" . $data['compiler.filename'] . "' doesn't exist");
        }
        return $data;
    }

    /**
     * @return string
     */
    public function getConfigurationFile()
    {
        return $this->configurationFile;
    }
    /**
     * @param string $configurationFile
     */
    public function setConfigurationFile($configurationFile)
    {
        $this->configurationFile = $configurationFile;
    }

    public function getBasePath()
    {
        return $this->basePath;
    }

}
