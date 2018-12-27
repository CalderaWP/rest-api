<?php


namespace calderawp\caldera\restApi\Endpoints\Entry;

use calderawp\caldera\restApi\Endpoint;
use calderawp\caldera\restApi\Routes\EntryRoute;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Contracts\WordPress\ApplysFilters;
use calderawp\interop\Contracts\Rest\RestResponseContract as Response;

abstract class EntryEndpoint extends Endpoint
{

	/** @inheritdoc */
	public function getUri(): string
	{
		return '/entries';
	}

	/** @inheritdoc */
	public function authorizeRequest(Request $request): bool
	{
		return true;
	}

	protected function getRoute(): EntryRoute
	{
		return $this->module
			->getRoute(EntryRoute::class);
	}
}
