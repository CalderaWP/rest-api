<?php


namespace calderawp\caldera\restApi\Endpoints\Form;

class DeleteForm extends FormEndpoint
{

	use RespondsForForm, HasFullFormArgs;

	public function hookSpecifier(): string
	{
		return 'deleteForm';
	}

	/** @inheritdoc */
	public function getHttpMethod(): string
	{
		return 'DELETE';
	}
}
