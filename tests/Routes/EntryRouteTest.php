<?php

namespace calderawp\caldera\restApi\Tests\Routes;

use calderawp\caldera\Forms\Controllers\EntryController;
use calderawp\caldera\Forms\Entry\Entry;
use calderawp\caldera\restApi\CalderaRestApi;
use calderawp\caldera\restApi\Request;
use calderawp\caldera\restApi\Routes\EntryRoute;
use calderawp\caldera\restApi\Tests\TestCase;
use calderawp\interop\Tests\Mocks\MockRequest;

class EntryRouteTest extends TestCase
{
	/**
	 * @covers \calderawp\caldera\restApi\Routes\EntryRoute::getEntries()
	 */
	public function testGetEntries()
	{
		$entryId = 5;
		$formId = 'cf1';
		$calderaForms = $this->calderaForms();
		$calderaForms
			->getEntries()
			->addEntry(Entry::fromArray(
				[
					'id' => $entryId,
					'formId' => $formId
				]
			));
		$calderaForms
			->getEntries()
			->addEntry(Entry::fromArray(
				[
					'id' => 6,
					'formId' => $formId
				]
			));

		$route = new EntryRoute($this->calderaRestApi());
		$route->setController(new EntryController($calderaForms));
		$request = new Request();

		$this->assertCount(2, $route->getEntries($request)->getData());
	}

	/**
	 * @covers \calderawp\caldera\restApi\Routes\EntryRoute::getEntry()
	 */
	public function testGetEntry()
	{
		$entryId = 5;
		$formId = 'cf1';
		$calderaForms = $this->calderaForms();
		$calderaForms
			->getEntries()
			->addEntry(Entry::fromArray(
				[
					'id' => $entryId,
					'formId' => $formId
				]
			));
		$calderaForms
			->getEntries()
			->addEntry(Entry::fromArray(
				[
					'id' => 6,
					'formId' => $formId
				]
			));

		$route = new EntryRoute($this->calderaRestApi());
		$route->setController(new EntryController($calderaForms));
		$request = new Request();
		$request->setParam('id', $entryId);

		$response = $route->getEntry($request);
		$this->assertEquals($entryId, $response->getData()['id']);
	}

	/**
	 * @covers \calderawp\caldera\restApi\Routes\EntryRoute::setController()
	 */
	public function testSetController()
	{
		$calderaForms = $this->calderaForms();
		$route = new EntryRoute($this->calderaRestApi());
		$controller = new EntryController($calderaForms);
		$route->setController(new EntryController($calderaForms));
		$this->assertAttributeEquals($controller, 'controller', $route);
	}
}
