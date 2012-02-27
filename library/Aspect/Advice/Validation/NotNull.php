<?php
/**
 * Validation : not null
 */

namespace Aspect\Advice\Validation;

use Aspect\Advice\Advice;

/**
 * Validation : NotNull
 */
class NotNull extends Advice
{

	public function beforeMethod()
	{
	    echo "Not Null";
	}

}
