<?php


namespace calderawp\caldera\restApi\Endpoints\Entry;

use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Contracts\Rest\RestResponseContract as Response;

class GetEntry extends EntryEndpoint
{
	/**
	 * @inheritDoc
	 */
	public function getPreHookName(): string
	{
		// TODO: Implement getPreHookName() method.
	}

	/**
	 * @inheritDoc
	 */
	public function getResponseHookName(): string
	{
		// TODO: Implement getResponseHookName() method.
	}

	/**
	 * @inheritDoc
	 */
	public function handleRequest(Request $request): Response
	{
		// TODO: Implement handleRequest() method.
	}

	/** @inheritdoc */
	public function getUri(): string
	{
		return '/entries/<entryId>';
	}
}
