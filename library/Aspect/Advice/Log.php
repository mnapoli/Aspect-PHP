<?php
/**
 * Log
 */

namespace Aspect\Advice;

use Aspect\Advice\Advice;

/**
 * Log
 */
class Log extends Advice
{

	public function beforeMethod()
	{
	    $parameters = array();
	    foreach ($this->_parameters as $parameter) {
	        $parameters[] = gettype($parameter);
	    }
	    echo sprintf("-- Before %s::%s(%s)", $this->_className, $this->_methodName,
	        implode(', ', $parameters)).PHP_EOL;
	}

	public function afterMethod()
	{
	    echo sprintf("-- After %s::%s()", $this->_className, $this->_methodName).PHP_EOL;
	}

}
