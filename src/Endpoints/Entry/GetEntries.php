<?php


namespace calderawp\caldera\restApi\Endpoints\Entry;

use calderawp\caldera\restApi\Routes\EntryRoute;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Contracts\Rest\RestResponseContract as Response;

class GetEntries extends EntryEndpoint
{
	/**
	 * @inheritDoc
	 */
	public function handleRequest(Request $request): Response
	{
		return $this->getRoute()->getEntries($request);
	}
}
