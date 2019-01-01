<?php


namespace calderawp\caldera\restApi\Endpoints\Entry;

use calderawp\caldera\restApi\Routes\EntryRoute;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Contracts\Rest\RestResponseContract as Response;

class GetEntry extends EntryEndpoint
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

	/**
	 * @inheritDoc
	 */
	public function handleRequest(Request $request): Response
	{
		return $this->getRoute()->getEntry($request);
	}

	/** @inheritdoc */
	public function getUri(): string
	{
		return '/entries/<(?P<entryId>\d+)>';
	}
}
