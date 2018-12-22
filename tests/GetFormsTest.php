<?php

namespace calderawp\caldera\restApi\Tests;

use calderawp\caldera\Events\CalderaEvents;
use calderawp\caldera\Forms\FormModel;
use calderawp\caldera\Forms\FormsCollection;
use calderawp\caldera\restApi\Endpoints\Form\GetForms;
use calderawp\caldera\restApi\Request;
use calderawp\caldera\restApi\Response;
use calderawp\interop\Contracts\WordPress\ApplysFilters;

class GetFormsTest extends TestCase
{

	/**
	 * @covers \calderawp\caldera\restApi\Endpoints\Form\GetForms::getArgs()
	 */
	public function testGetArgs()
	{
		$endpoint = new GetForms($this->createCalderaModuleRestApi());
		$this->assertTrue(is_array($endpoint->getArgs()));
	}

	/**
	 * @covers \calderawp\caldera\restApi\Endpoints\Form\GetForms::getHttpMethod()
	 */
	public function testGetHttpMethod()
	{
		$endpoint = new GetForms($this->createCalderaModuleRestApi());
		$this->assertEquals('GET', $endpoint->getHttpMethod());
	}


	/**
	 * @covers \calderawp\caldera\restApi\Endpoints\Form\GetForms::handleRequest()
	 */
	public function testHandleRequestNothingHooked()
	{
		$module = $this->createCalderaModuleRestApi();
		$endpoint = new GetForms($module);
		$forms = new FormsCollection();
		$form = FormModel::fromArray([
			'id' => 'cf1',
			'name' => 'contact forms'
		]);
		$forms->addForm($form);
		$response = $endpoint->handleRequest(new Request());
		$this->assertEquals([], $response->getData());
	}

	/**
	 * @covers \calderawp\caldera\restApi\Endpoints\Form\GetForms::handleRequest()
	 */
	public function testHandleRequestProvideForms()
	{
		$module = $this->createCalderaModuleRestApi();
		$endpoint = new GetForms($module);
		$formId = 'cf1';
		$form = FormModel::fromArray([
			'id' => $formId,
			'name' => 'contact forms'
		]);


		$endpoint->getFilters()
			->addFilter($endpoint->getPreHookName(), function (FormsCollection $collection) use ($form) {
					$collection->addForm($form);
					return $collection;
			});

		$response = $endpoint->handleRequest(new Request());

		$this->assertEquals($form->getId(), $response->getData()[$formId]['id']);
		$this->assertEquals($form->getName(), $response->getData()[$formId]['name']);
	}

	/**
	 * @covers \calderawp\caldera\restApi\Endpoints\Form\GetForms::handleRequest()
	 */
	public function testHandleRequestFilterResponse()
	{
		$module = $this->createCalderaModuleRestApi();
		$endpoint = new GetForms($module);
		$formId = 'cf1';
		$form = FormModel::fromArray([
			'id' => $formId,
			'name' => 'contact forms'
		]);


		$endpoint->getFilters()
			->addFilter($endpoint->getResponseHookName(), function (Response $response) use ($form) {
				$response->addHeader('X-TOTAL', 4);
				return $response;
			});

		$response = $endpoint->handleRequest(new Request());

		$this->assertEquals(4, $response->getHeaders()['X-TOTAL']);
	}
}
