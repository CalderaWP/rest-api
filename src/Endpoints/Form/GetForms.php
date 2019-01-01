<?php


namespace calderawp\caldera\restApi\Endpoints\Form;

use calderawp\caldera\Forms\FormModel;
use calderawp\caldera\Forms\FormsCollection;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Contracts\Rest\RestResponseContract as Response;

class GetForms extends FormEndpoint
{
	use HasFullFormArgs;
	/** @inheritdoc */
	public function getArgs(): array
	{
		return [

		];
	}


	public function handleRequest(Request $request): Response
	{
		return $this->getRoute()->getForms($request);
	}

	public function hookSpecifier(): string
	{
		return 'getForms';
	}



	/** @inheritdoc */
	public function getHttpMethod(): string
	{
		return 'GET';
	}
}
