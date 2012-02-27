<?php

namespace Tests\Aspect;

use Aspect\Compiler\Compiler;

// Configuration
require_once __DIR__.'/../library/Aspect/Configuration.php';
$configuration = \Aspect\Configuration::getInstance();
$configuration->load(__DIR__.'/../aspect.ini');

// Our annotation
require_once __DIR__.'/fixture/source/Annotation/TestAnnotation.php';

class CompilationTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Compiler
     * @var Aspect\Compiler\Compiler
     */
    protected $compiler;

    public function setUp()
    {
        $this->compiler = new Compiler();
    }

    public function testClass()
    {
        $classname = 'Class6';
        require_once 'fixture/source/'.$classname.'.php';
        $this->compiler->compile($classname);
        // Source
        $sourceContent = file_get_contents(__DIR__.'/fixture/source/'.$classname.'.php');
        // Compiled version
        $compiledContent = file_get_contents(__DIR__.'/fixture/compiled/'.$classname.'.php');
        $this->assertNotEquals($sourceContent, $compiledContent);
    }

}
