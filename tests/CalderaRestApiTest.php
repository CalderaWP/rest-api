<?php

namespace calderawp\caldera\restApi\Tests;

use calderawp\caldera\core\CalderaCore;
use calderawp\caldera\Events\CalderaEvents;
use calderawp\caldera\restApi\CalderaRestApi;
use calderawp\caldera\restApi\Routes\EntryRoute;
use calderawp\caldera\restApi\Routes\FormRoute;
use calderawp\CalderaContainers\Service\Container;

class CalderaRestApiTest extends TestCase
{

	/**
	 * @covers \calderawp\caldera\restApi\CalderaRestApi::getCore()
	 * @covers \calderawp\caldera\restApi\CalderaRestApi::getCalderaEvents()
	 */
	public function testGetCalderaEvents()
	{

		$core = $this->core();
		$restApi = new CalderaRestApi($this->core(), $this->serviceContainer());
		$this->assertIsObject($restApi->getCalderaEvents());
	}

	/**
	 * @covers \calderawp\caldera\restApi\CalderaRestApi::registerServices()
	 */
	public function testRegisterServices()
	{

		$restApi = new CalderaRestApi($this->core(), $this->serviceContainer());
		$this->assertEquals(1, 1);
	}

	/**
	 * @covers \calderawp\caldera\restApi\CalderaRestApi::getIdentifier()
	 */
	public function testGetIdentifier()
	{
		$restApi = new CalderaRestApi($this->core(), $this->serviceContainer());
		$this->assertEquals('rest-api', $restApi->getIdentifier());
	}

	/**
	 * @covers \calderawp\caldera\restApi\CalderaRestApi::getCore()
	 */
	public function testGetCore()
	{
		$restApi = new CalderaRestApi($this->core(), $this->serviceContainer());
		$this->assertInstanceOf(CalderaCore::class, $restApi->getCore());
	}


	/**
	 * @covers \calderawp\caldera\restApi\CalderaRestApi::addRoute()
	 * @covers \calderawp\caldera\restApi\CalderaRestApi::getRoute()
	 */
	public function testGetSetRouts()
	{
		$restApi = new CalderaRestApi($this->core(), $this->serviceContainer());
		$route = new EntryRoute($restApi);
		$restApi->addRoute($route);
		$this->assertEquals($route, $restApi->getRoute(EntryRoute::class));
	}

	/**
	 * @covers \calderawp\caldera\restApi\CalderaRestApi::registerServices()
	 * @covers \calderawp\caldera\restApi\CalderaRestApi::getRoute()
	 */
	public function testGetEntryRoute()
	{
		$restApi = new CalderaRestApi($this->core(), $this->serviceContainer());
		$route = new EntryRoute($restApi);
		$this->assertInstanceOf(EntryRoute::class, $restApi->getRoute(EntryRoute::class));
	}

	/**
	 * @covers \calderawp\caldera\restApi\CalderaRestApi::registerServices()
	 * @covers \calderawp\caldera\restApi\CalderaRestApi::getRoute()
	 */
	public function testGetFormsRoute()
	{
		$restApi = new CalderaRestApi($this->core(), $this->serviceContainer());
		$route = new FormRoute($restApi);
		$this->assertInstanceOf(FormRoute::class, $restApi->getRoute(FormRoute::class));
	}
}
