<?php

namespace calderawp\caldera\restApi\Tests;

use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Contracts\Rest\RestResponseContract as Response;
use calderawp\caldera\restApi\Endpoint;
use calderawp\caldera\restApi\Endpoints\Form\GetForms;
use calderawp\caldera\restApi\Tests\Mocks\MockEndpoint;
use \calderawp\caldera\restApi\Contracts\RestControllerContract as Controller;
use calderawp\caldera\Messaging\Contracts\ModelContract as Model;

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

	public function testHandleListRequest()
	{
		$model = \Mockery::mock('Model', Model::class);
		$_response = \Mockery::mock('Response', Response::class);
		$request = \Mockery::mock('Request', Request::class);
		$controller = \Mockery::mock(\calderawp\caldera\Messaging\RestController::class);
		$controller->shouldReceive('list')->andReturn($_response);


		$endpoint = new MockEndpoint($model, $controller, 'LIST');
		$response = $endpoint->handleRequest($request);
		$this->assertEquals($_response, $response);
	}

	public function testHandleGetRequest()
	{
		$model = \Mockery::mock('Model', Model::class);
		$_response = \Mockery::mock('Response', Response::class);
		$request = \Mockery::mock('Request', Request::class);
		$controller = \Mockery::mock(\calderawp\caldera\Messaging\RestController::class);
		$controller->shouldReceive('get')->andReturn($_response);


		$endpoint = new MockEndpoint($model, $controller, 'GET');
		$response = $endpoint->handleRequest($request);
		$this->assertEquals($_response, $response);
	}

	public function testHandlePostRequest()
	{
		$model = \Mockery::mock('Model', Model::class);
		$_response = \Mockery::mock('Response', Response::class);
		$request = \Mockery::mock('Request', Request::class);
		$controller = \Mockery::mock(\calderawp\caldera\Messaging\RestController::class);
		$controller->shouldReceive('update')->andReturn($_response);


		$endpoint = new MockEndpoint($model, $controller, 'POST');
		$response = $endpoint->handleRequest($request);
		$this->assertEquals($_response, $response);
	}

	public function testHandlePutRequest()
	{
		$model = \Mockery::mock('Model', Model::class);
		$_response = \Mockery::mock('Response', Response::class);
		$request = \Mockery::mock('Request', Request::class);
		$controller = \Mockery::mock(\calderawp\caldera\Messaging\RestController::class);
		$controller->shouldReceive('create')->andReturn($_response);


		$endpoint = new MockEndpoint($model, $controller, 'PUT');
		$response = $endpoint->handleRequest($request);
		$this->assertEquals($_response, $response);
	}
	public function testHandleDeleteRequest()
	{
		$model = \Mockery::mock('Model', Model::class);
		$_response = \Mockery::mock('Response', Response::class);
		$request = \Mockery::mock('Request', Request::class);
		$controller = \Mockery::mock(\calderawp\caldera\Messaging\RestController::class);
		$controller->shouldReceive('anonymize')->andReturn($_response);


		$endpoint = new MockEndpoint($model, $controller, 'ANONYMIZE');
		$response = $endpoint->handleRequest($request);
		$this->assertEquals($_response, $response);
	}
}
