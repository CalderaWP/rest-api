<?php

namespace calderawp\caldera\restApi\Tests;

use calderawp\caldera\restApi\Endpoint;
use calderawp\caldera\restApi\Endpoints\Form\GetForms;

class EndpointTest extends TestCase
{

	/**
	 * @covers \calderawp\caldera\restApi\Endpoint::__construct()
	 */
	public function test__construct()
	{
		$module = $this->createCalderaModuleRestApi();
		$endpoint = new GetForms($module);
		$this->assertAttributeEquals($module, 'module', $endpoint);
	}

	/**
	 * @covers \calderawp\caldera\restApi\Endpoint::getFilters()
	 */
	public function testGetFilters()
	{
		$module = $this->createCalderaModuleRestApi();
		$endpoint = new GetForms($module);
		$this->assertEquals($module->getCalderaEvents()->getHooks(), $endpoint->getFilters());
	}
}
