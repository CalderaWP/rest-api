<?php


namespace calderawp\caldera\restApi\Endpoints\Form;

use calderawp\caldera\Forms\FormModel;
use calderawp\caldera\Forms\FormsCollection;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Contracts\Rest\RestResponseContract as Response;

class GetForms extends FormEndpoint
{
	/** @inheritdoc */
	public function getArgs(): array
	{
		return [

		];
	}
	/** @inheritdoc */
	public function getResponseHookName(): string
	{
		return 'restApi/forms/getForm/response';
	}

	/** @inheritdoc */
	public function getPreHookName(): string
	{
		return 'restApi/forms/getForm/forms';
	}

	/** @inheritdoc */
	public function handleRequest(Request $request): Response
	{
		$forms = new FormsCollection();

		$forms = $this
			->getFilters()
			->applyFilters($this->getPreHookName(), $forms, $request);

		$response =  $this
			->getFilters()
			->applyFilters($this->getResponseHookName(), $forms->toResponse(), $forms, $request);
		return $response;
	}



	/** @inheritdoc */
	public function getHttpMethod(): string
	{
		return 'GET';
	}
}
