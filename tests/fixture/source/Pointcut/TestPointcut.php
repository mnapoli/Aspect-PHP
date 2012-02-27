<?php

namespace Pointcut;

class TestPointcut extends \Aspect\Pointcuts\Pointcut
    implements \Aspect\Pointcuts\MethodPointcut
{

    public function beforeMethod($classInstance, $methodName, array $args)
    {
        die('test');
    }

    public function afterMethod($classInstance, $methodName, array $args)
    {
    }
}
