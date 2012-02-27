<?php

namespace Annotation;

/**
 * Test annotation
 */
class TestAnnotation extends \Aspect\Annotations\Annotation
    implements \Aspect\Annotations\MethodAnnotation
{

    public function getMethodPointcut() {
        return '\Pointcut\TestPointcut';
    }

}
