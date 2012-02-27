<?php

namespace Tests\Aspect;

// Configuration
require_once __DIR__.'/../library/Aspect/Configuration.php';
$configuration = \Aspect\Configuration::getInstance();
$configuration->load(__DIR__.'/../aspect.ini');

class AspectTest extends \PHPUnit_Framework_TestCase
{

    public function testMethod()
    {
        $object = new \Class6();
        $this->assertTrue($object->test());
    }

}
