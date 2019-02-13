<?php

namespace calderawp\caldera\restApi\Tests;

use calderawp\caldera\restApi\Tests\Mocks\MockController;
use calderawp\caldera\DataSource\Contracts\SourceContract as DataSource;
use calderawp\interop\Contracts\HttpRequestContract as Request;

class ControllerTest extends TestCase
{

	public function testConstruct()
	{
		$dataSource = \Mockery::mock('DataSource', DataSource::class);
		$handleAuth = function () {
		};
		$controller = new MockController($dataSource, $handleAuth);
		$this->assertAttributeEquals($dataSource, 'dataSource', $controller);
		$this->assertAttributeEquals($handleAuth, 'handleAuth', $controller);
	}

	public function testSearchById()
	{
		$id = 8;
		$dataSource = \Mockery::mock('DataSource', DataSource::class);
		$handleAuth = function () {};
		$data = ['id' => $id];
		$searchValue = 'search for';

		$dataSource->shouldReceive( 'findById' )->with($searchValue, 'id')->andReturn($data);

		$request = \Mockery::mock('Request', Request::class);
		$request->shouldReceive('getParams')->andReturn(['searchValue' => $searchValue, 'searchColumn' => 'id']);

		$controller = new MockController($dataSource, $handleAuth);
		$response = $controller->search($request);
		$this->assertEquals($data,$response->getData() );
		$this->assertEquals(200,$response->getStatus() );

	}

	public function testSearchByIds()
	{

		$id = 8;
		$dataSource = \Mockery::mock('DataSource', DataSource::class);
		$handleAuth = function () {};
		$data = ['id' => $id];
		$searchValue = [1,'5', ['aaaaaa' => 'sqlAttack'], new \stdClass() ];
		$dataSource->shouldReceive( 'findIn' )->with([1,5], 'id')->andReturn($data);

		$request = \Mockery::mock('Request', Request::class);
		$request->shouldReceive('getParams')->andReturn(['searchValue' => $searchValue, 'searchColumn' => 'anything-random-this-does-not-get-user']);

		$controller = new MockController($dataSource, $handleAuth);
		$response = $controller->search($request);
		$this->assertEquals($data,$response->getData() );
		$this->assertEquals(200,$response->getStatus() );

	}

	public function testSearchByWhere()
	{

		$id = 8;
		$dataSource = \Mockery::mock('DataSource', DataSource::class);
		$handleAuth = function () {};
		$data = ['id' => $id];
		$searchValue = 'value';
		$searchColumn = 'name';
		$dataSource->shouldReceive( 'findWhere' )
			->with($searchColumn,$searchValue)
			->andReturn($data);

		$request = \Mockery::mock('Request', Request::class);
		$request->shouldReceive('getParams')->andReturn(['searchValue' => $searchValue, 'searchColumn' => $searchColumn]);

		$controller = new MockController($dataSource, $handleAuth);
		$response = $controller->search($request);
		$this->assertEquals($data,$response->getData() );
		$this->assertEquals(200,$response->getStatus() );

	}

	public function testList()
	{
		$this->markTestSkipped( 'Method not implemented yet' );
	}

	public function testAuthorizeRequest()
	{

		$dataSource = \Mockery::mock('DataSource', DataSource::class);
		$handleAuth = function (Request $request ) {
			return '12345' === $request->getParam('secret' );
		};
		$controller = new MockController($dataSource, $handleAuth);
		$request = \Mockery::mock('Request', Request::class);
		$request->shouldReceive('getParam')->andReturn('12345');
		$this->assertTrue($controller->authorizeRequest($request) );

		$controller = new MockController($dataSource, $handleAuth);
		$request = \Mockery::mock('Request', Request::class);
		$request->shouldReceive('getParam')->andReturn('1');
		$this->assertFalse($controller->authorizeRequest($request) );


	}

	public function testUpdate()
	{
		$dataSource = \Mockery::mock('DataSource', DataSource::class);
		$id = 7;
		$dataSource->shouldReceive('getId', $id);
		$data = ['id' => $id];
		$dataSource->shouldReceive('update')->andReturn($data);
		$handleAuth = function () {
		};
		$controller = new MockController($dataSource, $handleAuth);
		$request = \Mockery::mock('Request', Request::class);
		$request->shouldReceive('getParam')->andReturn($id);
		$request->shouldReceive('getParams')->andReturn($data);
		$response = $controller->update($request);
		$this->assertEquals(['id' => $id], $response->getData());
		$this->assertEquals(201, $response->getStatus());


	}

	public function testGet()
	{
		$dataSource = \Mockery::mock('DataSource', DataSource::class);
		$id = 7;
		$dataSource->shouldReceive('getId', $id);
		$data = ['id' => $id];
		$dataSource->shouldReceive('read')->andReturn($data);
		$handleAuth = function () {
		};
		$controller = new MockController($dataSource, $handleAuth);
		$request = \Mockery::mock('Request', Request::class);
		$request->shouldReceive('getParam')->andReturn($id);
		$response = $controller->get($request);
		$this->assertEquals(['id' => $id], $response->getData());
		$this->assertEquals(200, $response->getStatus());

	}

	public function testCreate()
	{
		$dataSource = \Mockery::mock('DataSource', DataSource::class);
		$id = 7;
		$dataSource->shouldReceive('getId', $id);
		$data = ['id' => $id];
		$dataSource->shouldReceive('create')->andReturn($id);
		$handleAuth = function () {
		};
		$controller = new MockController($dataSource, $handleAuth);
		$request = \Mockery::mock('Request', Request::class);
		$request->shouldReceive('getParams')->andReturn($data);
		$response = $controller->create($request);
		$this->assertEquals(['id' => $id], $response->getData());
		$this->assertEquals(201, $response->getStatus());

	}

	public function testDelete()
	{
		$dataSource = \Mockery::mock('DataSource', DataSource::class);
		$id = 7;
		$dataSource->shouldReceive('getId', $id);
		$dataSource->shouldReceive('delete')->andReturn(true);
		$handleAuth = function () {
		};
		$controller = new MockController($dataSource, $handleAuth);
		$request = \Mockery::mock('Request', Request::class);
		$request->shouldReceive('getParam')->andReturn($id);
		$response = $controller->delete($request);
		$this->assertEquals(['deleted' => true], $response->getData());
		$this->assertEquals(202, $response->getStatus());

		$dataSource = \Mockery::mock('DataSource', DataSource::class);
		$id = 7;
		$dataSource->shouldReceive('getId', $id);
		$dataSource->shouldReceive('delete')->andReturn(false);
		$handleAuth = function () {
		};
		$controller = new MockController($dataSource, $handleAuth);
		$request = \Mockery::mock('Request', Request::class);
		$request->shouldReceive('getParam')->andReturn($id);
		$response = $controller->delete($request);
		$this->assertEquals(['deleted' => false], $response->getData());
		$this->assertEquals(200, $response->getStatus());

	}

	public function testAnonymize()
	{
		$dataSource = \Mockery::mock('DataSource', DataSource::class);
		$id = 7;
		$dataSource->shouldReceive('getId', $id);
		$data = ['id' => $id];
		$dataSource->shouldReceive('anonymize')->andReturn($data);
		$handleAuth = function () {
		};
		$controller = new MockController($dataSource, $handleAuth);
		$request = \Mockery::mock('Request', Request::class);
		$request->shouldReceive('getParam')->andReturn($id);
		$request->shouldReceive('getParams')->andReturn($data);
		$response = $controller->anonymize($request);
		$this->assertEquals(['id' => $id], $response->getData());
		$this->assertEquals(202, $response->getStatus());

	}
}
