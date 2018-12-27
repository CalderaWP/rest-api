<?php


namespace calderawp\caldera\restApi\Routes;

use calderawp\caldera\Forms\Controllers\EntryController;
use calderawp\caldera\restApi\CalderaRestApi;
use calderawp\interop\Exception;
use calderawp\caldera\restApi\Request;
use calderawp\caldera\restApi\Response;
use calderawp\caldera\restApi\Route;
use calderawp\interop\Contracts\Rest\RestResponseContract;

class EntryRoute extends Route
{

	/**
	 * @var EntryController
	 */
	protected $controller;

	/**
	 * Set controller
	 *
	 * @param EntryController $controller
	 *
	 * @return EntryRoute
	 */
	public function setController(EntryController $controller): EntryRoute
	{
		$this->controller = $controller;
		return $this;
	}

	/**
	 * Route request for an entry
	 *
	 * @param Request $request
	 *
	 * @return RestResponseContract
	 */
	public function getEntry(Request $request) : RestResponseContract
	{

		try {
			$entry = $this->controller->getEntry(null, $request);
			return $this->controller->entryToResponse($entry);
		} catch (Exception $e) {
			return $this->exceptionToResponse($e);
		}
	}

	/**
	 * Route request for entries
	 *
	 * @param Request $request
	 *
	 * @return RestResponseContract
	 */
	public function getEntries(Request$request) : RestResponseContract
	{
		try {
			$entries = $this->controller->getEntries(null, $request);
			return $this->controller->entriesToResponse($entries);
		} catch (Exception $e) {
			return $this->exceptionToResponse($e);
		}
	}

	/**
	 * Route request to create entry
	 *
	 * @param Request $request
	 *
	 * @return RestResponseContract
	 */
	public function createEntry(Request $request): RestResponseContract
	{
		try {
			$entry = $this->controller->createEntry(null, $request);
			return $this->controller->entryToResponse($entry);
		} catch (Exception $e) {
			return $this->exceptionToResponse($e);
		}
	}
}
