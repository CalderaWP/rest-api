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

	/** @inheritdoc */
	public function handleRequest(Request $request) : Response
	{
		$form = FormModel::fromRequest($request);

		$form = $this
			->getFilters()
			->applyFilters($this->getPreHookName(), $form, $request);

		$response =  $this
			->getFilters()
			->applyFilters($this->getResponseHookName(), $form->toResponse(), $form, $request);
		return $response;
	}

	abstract function hookSpecifier():string;

	/** @inheritdoc */
	public function getResponseHookName(): string
	{
		return "restApi/forms/{$this->hookSpecifier()}/response";
	}

	/** @inheritdoc */
	public function getPreHookName(): string
	{
		return "restApi/forms/{$this->hookSpecifier()}/form";
	}

}
