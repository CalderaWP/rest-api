<?php


namespace calderawp\caldera\restApi\Endpoints\Form;

use calderawp\caldera\Forms\FormModel;
use calderawp\caldera\Forms\FormsCollection;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Contracts\Rest\RestResponseContract as Response;

class GetForm extends FormEndpoint
{

	use RespondsForForm;

	/** @inheritdoc */
	public function hookSpecifier(): string
	{
		return 'getForm';
	}


	/** @inheritdoc */
	public function getHttpMethod(): string
	{
		return 'GET';
	}
}
