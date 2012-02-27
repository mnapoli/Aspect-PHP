<?php
/**
 * Compiler
 */

namespace Aspect\Compiler;

use Aspect\Configuration;

/**
 * Compiler
 */
class Compiler
{

    /**
     * Cache directory
     * @var string
     */
    protected $cacheDir;

    /**
     * Initialization
     */
    public function __construct()
    {
        $configuration = Configuration::getInstance();
        // Configure
        $this->cacheDir = $configuration->getConfigurationValue('cache.directory');
        if ($this->cacheDir == '') {
            throw new \Exception("Configuration item 'cache.directory' is empty");
        }
    }

    /**
     * Compile the file of the class
     *
     * The class must already be included (and with aspect deactivated)
     * Everything not contained in the class (except the namespace declaration) will be removed.
     *
     * @param  string $className
     * @return string The compiled file
     */
    public function compile($className)
    {
        $class = new \Aspect\Reflection\ReflectionClass($className);
        // Destination file
        $filename = str_replace('\\', '/', $className).'.php';
        $destinationFile = $this->cacheDir . DIRECTORY_SEPARATOR . $filename;
        // Create directory if necessary
        if (! file_exists(dirname($destinationFile))) {
            mkdir(dirname($destinationFile), 0777, true);
        }
        // Write file
        $handle = fopen($destinationFile, 'w');
        $fileHeader = '<?php'.PHP_EOL.PHP_EOL;
        fwrite($handle, $fileHeader);
        fwrite($handle, $class->__toString());
        fclose($handle);
        return $destinationFile;
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

}