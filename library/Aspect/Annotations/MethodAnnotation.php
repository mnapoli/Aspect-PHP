<?php

namespace Aspect\Annotations;

/**
 * Method annotation
 */
interface MethodAnnotation
{

    /**
     * Returns the name of the Pointcut class associated to the annotation
     * @return string Pointcut class name
     */
    public function getMethodPointcut();

}
