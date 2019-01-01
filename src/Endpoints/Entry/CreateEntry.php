<?php


namespace calderawp\caldera\restApi\Endpoints\Entry;

use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Contracts\Rest\RestResponseContract as Response;

class CreateEntry extends EntryEndpoint
{
	/** @inheritdoc */
	public function getArgs(): array
	{
		return [
			'id' => [
				'type' => 'integer'
			],
			'formId' => [
				'type' => 'string'
			],
			'entryValues' => [
				'type' => 'object'
			]
		];
	}

	/** @inheritdoc */
	public function handleRequest(Request $request): Response
	{
		return $this->getRoute()->createEntry($request);
	}

	public function getHttpMethod(): string
	{
		return 'PUT';
	}
}
