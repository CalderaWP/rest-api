<?php


namespace calderawp\caldera\restApi\Endpoints\Form;

class PostForm extends FormEndpoint
{

	use RespondsForForm, HasFullFormArgs;

	/** @inheritdoc */
	public function getArgs(): array
	{
		return $this->getFullFormArgs();
	}


	/** @inheritdoc */
	public function hookSpecifier(): string
	{
		return 'putForm';
	}

	/** @inheritdoc */
	public function getHttpMethod(): string
	{
		return 'PUT';
	}
}
