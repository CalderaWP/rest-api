<?php


namespace calderawp\caldera\restApi\Endpoints\Form;

use calderawp\caldera\Forms\FormModel;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Contracts\Rest\RestResponseContract as Response;

trait RespondsForForm
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
}
