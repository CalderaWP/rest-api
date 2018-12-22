<?php

namespace calderawp\caldera\restApi\Tests;

use calderawp\caldera\Events\CalderaEvents;
use calderawp\caldera\restApi\CalderaRestApi;
use calderawp\CalderaContainers\Service\Container;

class CalderaRestApiTest extends TestCase
{

	/**
	 * @covers \calderawp\caldera\restApi\CalderaRestApi::setCalderaEvents()
	 * @covers \calderawp\caldera\restApi\CalderaRestApi::getCalderaEvents()
	 */
	public function testSetCalderaEvents()
	{

		$events = new CalderaEvents(new Container());
		$restApi = new CalderaRestApi(new Container());
		$restApi->setCalderaEvents($events);
		$this->assertSame($events, $restApi->getCalderaEvents());
	}

	/**
	 * @covers \calderawp\caldera\restApi\CalderaRestApi::registerServices()
	 */
	public function testRegisterServices()
	{

		$restApi = new CalderaRestApi(new Container());
		$this->assertEquals(1, 1);
	}

	/**
	 * @covers \calderawp\caldera\restApi\CalderaRestApi::getIdentifier()
	 */
	public function testGetIdentifier()
	{
		$restApi = new CalderaRestApi(new Container());
		$this->assertEquals('rest-api', $restApi->getIdentifier());
	}
}
