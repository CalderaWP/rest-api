<?php

namespace calderawp\caldera\restApi\Tests;

use calderawp\caldera\restApi\Endpoint;
use calderawp\caldera\restApi\Route;
use calderawp\caldera\restApi\Tests\Mocks\RegisterEndpointsWithWordPressMock;
use PHPUnit\Framework\TestCase;

class RegisterEndpointsWithWordPressMockTest extends TestCase
{

	/**
	 * @covers \calderawp\caldera\restApi\Traits\CreatesWordPressEndpoints::registerRouteWithWordPress()
	 */
	public function testRegisterRouteWithWordPress()
	{
		$endpoint = \Mockery::mock(Endpoint::class);
		$endpoint
			->shouldReceive('getArgs')
			->andReturn([]);
		$endpoint
			->shouldReceive('getHttpMethod')
			->andReturn('GET');
		$endpoint
			->shouldReceive('getUri')
			->andReturn('/test');


		$test = new RegisterEndpointsWithWordPressMock();
		$test->registerRouteWithWordPress($endpoint);
		$this->assertAttributeEquals(true, 'callbackCalled', $test);
	}

	/**
	 * @covers \calderawp\caldera\restApi\Traits\CreatesWordPressEndpoints::wpArgs()
	 */
	public function testWpArgs()
	{
		$endpoint = \Mockery::mock(Endpoint::class);
		$endpoint
			->shouldReceive('getArgs')
			->andReturn([]);
		$endpoint
			->shouldReceive('getHttpMethod')
			->andReturn('GET');


		$test = new RegisterEndpointsWithWordPressMock();
		$args = $test->wpArgs($endpoint);
		$this->assertIsArray($args);
	}
}
