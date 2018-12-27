<?php


namespace calderawp\caldera\restApi\Endpoints\Form;

use calderawp\caldera\Forms\FormModel;
use calderawp\caldera\Forms\FormsCollection;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Contracts\Rest\RestResponseContract as Response;

class GetForm extends FormEndpoint
{


	/** @inheritdoc */
	public function getArgs(): array
	{
		return [
			'formId' => [
				'type' => 'string'
			]
		];
	}


	public function handleRequest(Request $request): Response
	{
		return $this->getRoute()->getForm($request);
	}

	/** @inheritdoc */
	public function getHttpMethod(): string
	{
		return 'GET';
	}
}
