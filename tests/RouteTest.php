<?php

namespace calderawp\caldera\restApi\Tests;

use calderawp\caldera\restApi\Endpoints\Form\FormEndpoint;
use calderawp\caldera\restApi\Endpoints\Form\GetForms;
use calderawp\caldera\restApi\Endpoints\Form\RespondsForForm;
use calderawp\caldera\restApi\Route;
use calderawp\caldera\restApi\Routes\Form;

class RouteTest extends TestCase
{



	public function testGetFilters()
	{
		$module = $this->createCalderaModuleRestApi();
		$route = new Form($module);
		$this->assertEquals($module->getCalderaEvents()->getHooks(), $route->getFilters());
	}

	/**
	 * @covers \calderawp\caldera\restApi\Route::addEndpoint()
	 */
	public function testAddEndpoint()
	{
		$module = $this->createCalderaModuleRestApi();
		$route = new Form($module);
		$route->addEndpoint(new GetForms($module));
		$this->assertCount(6, $route->getEndpoints());
	}

	public function testGetEndpoints()
	{
		$module = $this->createCalderaModuleRestApi();
		$route = new Form($module);
		$this->assertCount(5, $route->getEndpoints());
	}
}
