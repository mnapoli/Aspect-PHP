<?php
/**
 * Advice
 */

namespace Aspect\Advice;

/**
 * Advice
 */
abstract class Advice
{

    protected $_className;
    protected $_methodName;
    protected $_parameters;
    protected $_annotation;

	public function beforeMethod()
	{
	}

	public function afterMethod()
	{
	}

	public function set($className, $methodName, $parameters)
	{
	    $this->_className = $className;
	    $this->_methodName = $methodName;
	    $this->_parameters = $parameters;
	}

}