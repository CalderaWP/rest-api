<?php


namespace calderawp\caldera\restApi\Endpoints\Entry;

trait RespondsForEntry
{
	/** @inheritdoc */
	public function getArgs(): array
	{
		return [
			'id' => [
				'type' => 'integer'
			]
		];
	}


	/** @inheritdoc */
	public function handleRequest(Request $request) : Response
	{

		$entry = EntryModel::fromRequest($request);

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
