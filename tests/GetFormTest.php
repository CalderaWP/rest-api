<?php

namespace calderawp\caldera\restApi\Tests;

use calderawp\caldera\Forms\FormModel;
use calderawp\caldera\restApi\Endpoints\Form\GetForm;
use calderawp\caldera\restApi\Request;
use calderawp\caldera\restApi\Response;

class GetFormTest extends TestCase
{

	/**
	 * @covers \calderawp\caldera\restApi\Endpoints\Form\GetForm::getArgs();
	 */
	public function testGetArgs()
	{
		$module = $this->createCalderaModuleRestApi();
		$endpoint = new GetForm($module);
		$this->assertTrue(is_array($endpoint->getArgs()));
	}

	/**
	 * @covers \calderawp\caldera\restApi\Endpoints\Form\GetForm::handleRequest();
	 */
	public function testHandleRequest()
	{
		$module = $this->createCalderaModuleRestApi();
		$endpoint = new GetForm($module);
		$id = 'cf1';
		$name = 'Contact Form';
		$request = new Request();
		$request->setParam('id', $id);
		$request->setParam('name', $name);

		$response = $endpoint->handleRequest($request);
		$this->assertEquals($id, $response->getData()['id']);
		$this->assertEquals($name, $response->getData()['name']);
	}

	/**
	 * @covers \calderawp\caldera\restApi\Endpoints\Form\GetForm::handleRequest();
	 */
	public function testHandleRequestFilters()
	{
		$module = $this->createCalderaModuleRestApi();
		$endpoint = new GetForm($module);
		$id = 'cf1';
		$name = 'Contact Form';
		$name2 = 'Not Contact Form';
		$request = new Request();
		$request->setParam('id', $id);
		$request->setParam('name', $name);

		$endpoint->getFilters()->addFilter($endpoint->getPreHookName(), function (FormModel $form) use ($name2) {
			$form->setName($name2);
			return $form;
		});

		$endpoint->getFilters()->addFilter($endpoint->getResponseHookName(), function (Response$response) {
			$response->addHeader('X-TOTAL', 5);
			return $response;
		});

		$response = $endpoint->handleRequest($request);
		$this->assertEquals(5, $response->getHeaders()['X-TOTAL']);
		$this->assertEquals($name2, $response->getData()['name']);
	}

	/**
	 * @covers \calderawp\caldera\restApi\Endpoints\Form\GetForm::getHttpMethod();
	 */
	public function testGetHttpMethod()
	{
		$module = $this->createCalderaModuleRestApi();
		$endpoint = new GetForm($module);

		$this->assertEquals('GET', $endpoint->getHttpMethod());
	}
}
