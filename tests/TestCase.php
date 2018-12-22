<?php


namespace calderawp\caldera\restApi\Tests;

use calderawp\caldera\Events\CalderaEvents;
use calderawp\caldera\restApi\CalderaRestApi;
use calderawp\CalderaContainers\Service\Container;
use PHPUnit\Framework\TestCase as _TestCase;

abstract class TestCase extends \Mockery\Adapter\Phpunit\MockeryTestCase
{

	protected function createCalderaModuleRestApi(): CalderaRestApi
	{
		$events = new CalderaEvents(new Container());
		$restApi = new CalderaRestApi(new Container());
		$restApi->setCalderaEvents($events);
		return $restApi;
	}
}
