<?php


namespace calderawp\caldera\restApi\Endpoints\Form;

use calderawp\caldera\Forms\FormModel;
use calderawp\caldera\Forms\FormsCollection;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Contracts\Rest\RestResponseContract as Response;

class GetForms extends FormEndpoint
{
	use RespondsForForms;
	/** @inheritdoc */
	public function getArgs(): array
	{
		return [

		];
	}

	public function hookSpecifier(): string
	{
		return 'getForms';
	}


	public function getUri(): string
	{
		return parent::getUri() . '/<formId>';
	}


	/** @inheritdoc */
	public function getHttpMethod(): string
	{
		return 'GET';
	}
}
