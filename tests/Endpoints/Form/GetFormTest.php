<?php

namespace calderawp\caldera\restApi\Tests\Endpoints\Form;

use calderawp\caldera\restApi\Endpoints\Form\GetForm;
use calderawp\caldera\restApi\Request;
use calderawp\caldera\restApi\Tests\TestCase;

class GetFormTest extends TestCase
{

	/** @covers \calderawp\caldera\restApi\Endpoints\Form\GetForm::getHttpMethod() */
	public function testGetHttpMethod()
	{
		$endpoint = new GetForm($this->calderaRestApi());
		$this->assertEquals('GET', $endpoint->getHttpMethod());
	}


	public function testHandleRequest()
	{
		$endpoint = new GetForm($this->calderaRestApi());
		$request = new Request();
		$request->setParam('id', 'cf1');
		$this->assertEquals([
			'message' => 'Form not found'
		], $endpoint->handleRequest($request)->getData());
	}
}
