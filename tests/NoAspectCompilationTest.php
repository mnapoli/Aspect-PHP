<?php

namespace Tests\Aspect;

use Aspect\Compiler\Compiler;

// Configuration
require_once __DIR__.'/../library/Aspect/Configuration.php';
$configuration = \Aspect\Configuration::getInstance();
$configuration->load(__DIR__.'/../aspect_disabled.ini');

class NoAspectCompilationTest extends \PHPUnit_Framework_TestCase
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
        $classname = 'Class1';
        require_once 'fixture/source/'.$classname.'.php';
        $this->compiler->compile($classname);
        // Source
        $sourceContent = file_get_contents(__DIR__.'/fixture/source/'.$classname.'.php');
        // Compiled version
        $compiledContent = file_get_contents(__DIR__.'/fixture/compiled/'.$classname.'.php');
        $this->assertEquals($sourceContent, $compiledContent);
    }

    public function testMethod()
    {
        $classname = 'Class2';
        require_once 'fixture/source/'.$classname.'.php';
        $this->compiler->compile($classname);
        // Source
        $sourceContent = file_get_contents(__DIR__.'/fixture/source/'.$classname.'.php');
        // Compiled version
        $compiledContent = file_get_contents(__DIR__.'/fixture/compiled/'.$classname.'.php');
        $this->assertEquals($sourceContent, $compiledContent);
    }

    public function testProperty()
    {
        $classname = 'Class3';
        require_once 'fixture/source/'.$classname.'.php';
        $this->compiler->compile($classname);
        // Source
        $sourceContent = file_get_contents(__DIR__.'/fixture/source/'.$classname.'.php');
        // Compiled version
        $compiledContent = file_get_contents(__DIR__.'/fixture/compiled/'.$classname.'.php');
        $this->assertEquals($sourceContent, $compiledContent);
    }

    public function testConstant()
    {
        $classname = 'Class4';
        require_once 'fixture/source/'.$classname.'.php';
        $this->compiler->compile($classname);
        // Source
        $sourceContent = file_get_contents(__DIR__.'/fixture/source/'.$classname.'.php');
        // Compiled version
        $compiledContent = file_get_contents(__DIR__.'/fixture/compiled/'.$classname.'.php');
        $this->assertEquals($sourceContent, $compiledContent);
    }

    public function testNamespace()
    {
        $classname = '\TestNamespace\Class5';
        $file = 'TestNamespace/Class5';
        require_once 'fixture/source/'.$file.'.php';
        $this->compiler->compile($classname);
        // Source
        $sourceContent = file_get_contents(__DIR__.'/fixture/source/'.$file.'.php');
        // Compiled version
        $compiledContent = file_get_contents(__DIR__.'/fixture/compiled/'.$file.'.php');
        $this->assertEquals($sourceContent, $compiledContent);
    }

}
