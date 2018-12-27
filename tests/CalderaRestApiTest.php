<?php

namespace calderawp\caldera\restApi\Tests;

use calderawp\caldera\core\CalderaCore;
use calderawp\caldera\Events\CalderaEvents;
use calderawp\caldera\restApi\CalderaRestApi;
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
		$this->assertEquals($core->getEvents(), $restApi->getCalderaEvents());
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
}
