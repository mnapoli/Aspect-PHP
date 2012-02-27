<?php
/**
 * PHP Aspect Compiler
 *
 * Usage:
 * php compile.php -c "configurationFile.ini" -f "path/ClassName.php" ClassName
 */

use Aspect\Compiler\Compiler;


// Options
$options = getopt("c:f:");
if (! isset($options['c'])) {
    die("-c argument is mandatory: configuration file" . PHP_EOL);
}
$configurationFile = $options['c'];
if (! isset($options['f'])) {
    die("-f argument is mandatory: file to compile" . PHP_EOL);
}
$classFile = $options['f'];
if ($argc != 6) {
    die("You need to provide a class name" . PHP_EOL);
}
// The class name is the last argument
$className = $argv[$argc - 1];


// Configuration
require_once 'library/Aspect/Configuration.php';
$configuration = \Aspect\Configuration::getInstance();
// TODO use command line argument
$configuration->load($configurationFile);

// Autoloading
require_once 'library/Aspect/Autoloader.php';
$autoloader = Aspect\Autoloader::getInstance();
// No aspects !
$autoloader->setAspectEnabled(false);
$autoloader->register();


// TODO aspect list
require_once __DIR__.'/tests/fixture/source/Annotation/TestAnnotation.php';

// Include the class to compile
require_once $classFile;

$compiler = new Compiler();
$compiledFile = $compiler->compile($className);

echo "Class '$className' compiled in $compiledFile" . PHP_EOL;
