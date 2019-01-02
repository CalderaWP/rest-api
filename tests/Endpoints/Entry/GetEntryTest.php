<?php

namespace calderawp\caldera\restApi\Tests\Endpoints\Entry;

use calderawp\caldera\restApi\Endpoints\Entry\GetEntry;
use calderawp\caldera\restApi\Request;
use calderawp\caldera\restApi\Routes\FormRoute;
use calderawp\caldera\restApi\Tests\TestCase;

class GetEntryTest extends TestCase
{

	/** @covers \calderawp\caldera\restApi\Endpoints\Entry\GetEntry::getUri() */
	public function testGetUri()
	{
		$endpoint = new GetEntry($this->calderaRestApi());
		$this->assertEquals('/entries/<(?P<entryId>\d+)>', $endpoint->getUri());
	}

	/** @covers \calderawp\caldera\restApi\Endpoints\Entry\GetEntry::handleRequest() */
	public function testHandleRequest()
	{
		$restApi = $this->calderaRestApi();
		$this->assertIsObject($restApi->getRoute(FormRoute::class));
		$endpoint = new GetEntry($this->calderaRestApi());
		$request = new Request();
		$request->setParam('id', 'cf1');
		$this->assertEquals(['message' => 'Entry not found'], $endpoint->handleRequest($request)->getData());
	}
}
