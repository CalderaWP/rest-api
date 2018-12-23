<?php

namespace calderawp\caldera\restApi\Tests\Routes;

use calderawp\caldera\restApi\Endpoints\Form\FormEndpoint;
use calderawp\caldera\restApi\Endpoints\Form\RespondsForForm;
use calderawp\caldera\restApi\Routes\Form;
use calderawp\caldera\restApi\Tests\TestCase;

class FormTest extends TestCase
{
	/**
	 * @covers \calderawp\caldera\restApi\Routes\Form::__construct()
	 */
	public function test__construct()
	{
		$module = $this->createCalderaModuleRestApi();
		$route = new Form($module);
		$this->assertAttributeCount(5, 'endpoints', $route);
	}
}
