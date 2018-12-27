<?php


namespace calderawp\caldera\restApi\Routes;

use calderawp\caldera\Forms\Controllers\FormsController;
use calderawp\interop\Exception;
use calderawp\caldera\restApi\Request;
use calderawp\caldera\restApi\Route;
use calderawp\interop\Contracts\Rest\RestResponseContract;

class FormRoute extends Route
{

	/**
	 * @var FormsController
	 */
	protected $controller;

	/**
	 * Set controller
	 *
	 * @param FormsController $controller
	 *
	 * @return FormRoute
	 */
	public function setController(FormsController $controller): FormRoute
	{
		$this->controller = $controller;
		return $this;
	}


	public function getForm(Request $request): RestResponseContract
	{
		try {
			$form = $this->controller->getForm(null, $request);
			return $this->controller->responseToForm($form);
		} catch (Exception $e) {
			return $this->exceptionToResponse($e);
		}
	}

	public function getForms(Request $request) : RestResponseContract
	{
		try {
			$forms = $this->controller->getForms(null, $request);
			return $this->controller->responseToForms($forms);
		} catch (Exception $e) {
			$this->exceptionToResponse($e);
		}
	}
}
