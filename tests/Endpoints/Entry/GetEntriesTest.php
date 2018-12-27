<?php

namespace calderawp\caldera\restApi\Tests\Endpoints\Entry;

use calderawp\caldera\restApi\Endpoints\Entry\GetEntries;
use calderawp\caldera\restApi\Request;
use calderawp\caldera\restApi\Tests\TestCase;

class GetEntriesTest extends TestCase
{

	/**
	 * @covers \calderawp\caldera\restApi\Endpoints\Entry\GetEntries::handleRequest()
	 */
	public function testHandleRequest()
	{

		$endpoint = new GetEntries($this->calderaRestApi());
		$request = new Request();
		$request->setParam('id', 'cf1');
		$this->assertEquals([], $endpoint->handleRequest($request)->getData());
	}
}
