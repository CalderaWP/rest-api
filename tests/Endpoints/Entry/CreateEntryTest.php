<?php

namespace calderawp\caldera\restApi\Tests\Endpoints\Entry;

use calderawp\caldera\restApi\Endpoints\Entry\CreateEntry;
use calderawp\caldera\restApi\Request;
use calderawp\caldera\restApi\Routes\EntryRoute;
use calderawp\caldera\restApi\Tests\TestCase;

class CreateEntryTest extends TestCase
{
	/** @covers \calderawp\caldera\restApi\Endpoints\Entry\CreateEntry::getArgs() */
	public function testGetArgs()
	{
		$endpoint = new CreateEntry($this->calderaRestApi());
		$this->assertIsArray($endpoint->getArgs());
	}
	/** @covers \calderawp\caldera\restApi\Endpoints\Entry\CreateEntry::handleRequest() */
	public function testHandleRequest()
	{
		$endpoint = new CreateEntry($this->calderaRestApi());
		$restApi = $this->calderaRestApi();
		$this->assertIsObject($restApi->getRoute(EntryRoute::class));
		$request = new Request();
		$request->setParam('formId', 'cf1');
		$response = $endpoint->handleRequest($request);
		$this->assertArrayHasKey('message', $response->getData());
	}

	/** @covers \calderawp\caldera\restApi\Endpoints\Entry\CreateEntry::getHttpMethod() */
	public function testGetHttpMethod()
	{
		$endpoint = new CreateEntry($this->calderaRestApi());
		$this->assertEquals('PUT', $endpoint->getHttpMethod());
	}
}
