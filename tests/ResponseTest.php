<?php

namespace calderawp\caldera\restApi\Tests;

use calderawp\caldera\restApi\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{

	/**
	 * @covers \calderawp\caldera\restApi\Response::toArray()
	 */
	public function testFromArray()
	{

		$data = [
			'd' => 1,
			'fields' => [[],[]]
		];
		$headers = [
			'X-TOTAL' => 45
		];
		$status = 201;
		$response = Response::fromArray([
			'data' => $data,
			'status' => $status,
			'headers' => $headers
		]);

		$this->assertEquals($headers, $response->getHeaders());
		$this->assertEquals($status, $response->getStatus());
		$this->assertEquals($headers, $response->getHeaders());
	}

	/**
	 * @covers \calderawp\caldera\restApi\Response::addHeader()
	 */
	public function testAddHeader()
	{
		$response = new Response();
		$response->addHeader('X-ROY', 'Hi Roy');
		$this->assertAttributeEquals(['X-ROY' => 'Hi Roy'], 'headers', $response);
	}

	/**
	 * @covers \calderawp\caldera\restApi\Response::addHeader()
	 */
	public function testAddHeadersViaAddHeader()
	{
		$response = new Response();
		$response->addHeader('X-ROY', 'Hi Roy');
		$this->assertAttributeEquals(['X-ROY' => 'Hi Roy'], 'headers', $response);
		$response->addHeader('X-TOTAL', '1');
		$this->assertAttributeEquals(['X-ROY' => 'Hi Roy', 'X-TOTAL' => '1'], 'headers', $response);
	}
}
