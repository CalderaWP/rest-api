<?php


namespace calderawp\caldera\restApi\Endpoints\Form;

class PutForm extends FormEndpoint
{

	use RespondsForForm, HasFullFormArgs;

	/** @inheritdoc */
	public function getArgs(): array
	{
		return $this->getFullFormArgs();
	}

	public function hookSpecifier(): string
	{
		return 'postForm';
	}

	/** @inheritdoc */
	public function getHttpMethod(): string
	{
		return 'POST';
	}
}
