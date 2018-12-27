<?php


namespace calderawp\caldera\restApi\Endpoints\Form;

use calderawp\caldera\Events\CalderaEvents;
use calderawp\caldera\restApi\CalderaRestApi;
use calderawp\caldera\restApi\Endpoint;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Contracts\WordPress\ApplysFilters;
use calderawp\interop\Contracts\Rest\RestResponseContract as Response;

abstract class FormEndpoint extends Endpoint
{



	/** @inheritdoc */
	protected function hookPrefix(): string
	{
		return 'forms';
	}

	/** @inheritdoc */
	public function getUri(): string
	{
		return '/forms';
	}

	/** @inheritdoc */
	public function authorizeRequest(Request $request): bool
	{
		return true;
	}
}
