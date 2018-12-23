<?php


namespace calderawp\caldera\restApi\Endpoints\Form;

class PostForm extends FormEndpoint
{

	use RespondsForForm, HasFullFormArgs;

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
