<?php

namespace Aspect\Pointcuts;

/**
 * Around method pointcut
 */
interface MethodPointcut {

    /**
     * Code executed before the method call
     * @param Object $classInstance Instance of the class of the method
     * @param string $methodName    Name of the method intercepted
     * @param array  $args          Arguments of the method intercepted
     */
    public function beforeMethod($classInstance, $methodName, array $args);

    /**
     * Code executed after the method call
     * @param Object $classInstance Instance of the class of the method
     * @param string $methodName    Name of the method intercepted
     * @param array  $args          Arguments of the method intercepted
     */
    public function afterMethod($classInstance, $methodName, array $args);

}
