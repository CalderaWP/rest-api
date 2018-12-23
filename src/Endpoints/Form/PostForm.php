<?php


namespace calderawp\caldera\restApi\Endpoints\Form;

class PutForm extends FormEndpoint
{

	use RespondsForForm, HasFullFormArgs;

	public function hookSpecifier(): string
	{
		return 'putForm';
	}


}
