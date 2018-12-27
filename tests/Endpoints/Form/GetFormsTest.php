<?php

namespace calderawp\caldera\restApi\Tests\Endpoints\Form;

use calderawp\caldera\Forms\Forms\ContactForm;
use calderawp\caldera\restApi\Endpoints\Form\GetForms;
use calderawp\caldera\restApi\Request;
use calderawp\caldera\restApi\Tests\TestCase;

class GetFormsTest extends TestCase
{

	/** @covers \calderawp\caldera\restApi\Endpoints\Form\GetForms::getHttpMethod() */
	public function testGetHttpMethod()
	{
		$endpoint = new GetForms($this->calderaRestApi());
		$this->assertEquals('GET', $endpoint->getHttpMethod());
	}

	/** @covers \calderawp\caldera\restApi\Endpoints\Form\GetForms::getArgs() */
	public function testGetArgs()
	{
		$endpoint = new GetForms($this->calderaRestApi());
		$this->assertIsArray($endpoint->getArgs());
	}

	/** @covers \calderawp\caldera\restApi\Endpoints\Form\GetForms::handleRequest() */
	public function testHandleRequest()
	{
		$endpoint = new GetForms($this->calderaRestApi());
		$request = new Request();
		$request->setParam('id', 'cf1');
		$this->assertArrayHasKey(
			ContactForm::ID,
			$endpoint->handleRequest($request)->getData()
		);
	}

	public function testGetUri()
	{
		$endpoint = new GetForms($this->calderaRestApi());
		$this->assertIsString($endpoint->getUri());
	}
}
