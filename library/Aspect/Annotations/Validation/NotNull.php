<?php
/**
 * Validation : not null
 */

namespace Aspect\Annotations\Validation;

use Aspect\Annotations\AnnotationException;

use Aspect\Annotations\MethodInterceptor;
use Aspect\Annotations\Validation\ValidationException;

/**
 * Validation : NotNull
 */
class NotNull extends MethodInterceptor
{

    /**
     * Argument to validate
     * @var string
     */
	public $value;

	public function beforeMethod(array $args)
	{
	    if ($this->value == '') {
	        throw new AnnotationException('Annotation expects one parameter (name of the method parameter to validate)');
	    }
		if ($args[$this->value] === null) {
			throw new ValidationException('Parameter '.$this->value.' is null');
		}
	}

	public function afterMethod(array $args)
	{
	}

    /**
     * @return Aspect\Advice\Log
     */
    public function getAdvice()
    {
        return new \Aspect\Advice\Validation\NotNull();
    }

}
