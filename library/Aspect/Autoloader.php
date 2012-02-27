<?php
/**
 * @author Matthieu Napoli
 */

namespace Aspect;

require_once 'Configuration.php';

/**
 * Class autoloader using Aspect cache
 */
class Autoloader
{

    /**
     * Autoloading lookup paths
     * @var array(string)
     */
    protected $paths = array();

    /**
     * Cache directory
     * @var string
     */
    protected $cacheDir;

    /**
     * Activation of aspect
     * @var boolean
     */
    protected $aspectEnabled = true;


    /**
     * Returns the instance of the Autoloader
     * @return Aspect\Autoloader
     */
    public static function getInstance()
    {
        static $instance = null;
        if (! isset($instance)) {
            $instance = new self();
        }
        return $instance;
    }

    /**
     * Autoload a class
     * @param string $class
     */
    public function autoload($class)
    {
        // Lookup in each path
        foreach ($this->paths as $path) {
            if ($this->autoloadInPath($class, $path)) {
                return true;
            }
        }
        // Fallback on include path
        return $this->autoloadInPath($class);
    }

    /**
     * Autoload a class in a path
     * @param string $class
     * @param string $path
     */
    private function autoloadInPath($class, $path = '')
    {
        $configuration = Configuration::getInstance();
        // Add trailing slash
        if ( ($path != '') && (substr($path, strlen($path) - 1, 1) != DIRECTORY_SEPARATOR) ) {
            $path .= DIRECTORY_SEPARATOR;
        }
        $filename = $path . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
        $cacheFilename = $this->cacheDir . DIRECTORY_SEPARATOR
            . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
        // If the file exist (autoloading can work)
        if ($this->isReadable($filename)) {
            // If aspect is enabled
            if ($this->aspectEnabled) {
                // Look in the cache
                if ($configuration->getConfigurationValue('cache.enable') && $this->isReadable($cacheFilename)) {
                    // Check if original file is newer than the cached one
                    $dateOriginal = filectime($filename);
                    $dateCache = filectime($cacheFilename);
                    if ($dateOriginal > $dateCache) {
                        // Need to update the cache
                        $this->compileFile($filename, $class);
                    }
                    return require_once $cacheFilename;
                } else {
                    // Need to create the cache
                    $this->compileFile($filename, $class);
                    return require_once $cacheFilename;
                }
            }
            // No aspect => include the original file
            return require_once $filename;
        } else {
            return false;
        }
    }

    /**
     * Registers instance as autoloader
     */
    public function register()
    {
        if ($this->aspectEnabled && ($this->cacheDir == null)) {
            throw new \Exception("The cache directory is not set, use Autoloader::setCacheDir()");
        }
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    /**
     * Add a path for autoloading lookup
     * @param string $path
     */
    public function addPath($path)
    {
        $this->paths[] = $path;
    }

    /**
     * @return string
     */
    public function getCacheDir()
    {
        return $this->cacheDir;
    }
    /**
     * @param string $cacheDir
     */
    public function setCacheDir($cacheDir)
    {
        $this->cacheDir = realpath($cacheDir);
    }

    /**
     * Is aspect enabled
     * @return boolean
     */
    public function getAspectEnabled()
    {
        return $this->aspectEnabled;
    }
    /**
     * Activate/deactivate the aspect
     * @param boolean $aspectEnabled
     */
    public function setAspectEnabled($aspectEnabled)
    {
        $this->aspectEnabled = $aspectEnabled;
    }

    /**
     * Launche the compilation of a file through a separate process
     * @param string $filename
     * @return boolean
     */
    private function compileFile($fileName, $className)
    {
        $configuration = Configuration::getInstance();
        $phpExecutable = $configuration->getConfigurationValue('php.executable');
        $configurationFile = $configuration->getConfigurationFile();
        $compilerFilename = $configuration->getConfigurationValue('compiler.filename');
        // Command line
        $command = sprintf('"%s" "%s" -c "%s" -f "%s" "%s"',
                $phpExecutable, $compilerFilename, $configurationFile, $fileName, $className);
        $return = shell_exec($command);
        // TODO return type
        return true;
    }

    /**
     * Returns true if the $filename is readable, or false otherwise.
     *
     * This function uses the PHP include_path, where PHP's is_readable()
     * does not.
     * This function comes from Zend Framework 1.10.
     *
     * @param  string   $filename
     * @return boolean
     */
    private function isReadable($filename)
    {
        $fh = @fopen($filename, 'r', true);
        if (!$fh) {
            return false;
        }
        @fclose($fh);
        return true;
    }

    /**
     * Private constructor
     */
    final private function __construct()
    {
    }

    /**
     * Private clone method
     */
    final private function __clone()
    {
    }

}
