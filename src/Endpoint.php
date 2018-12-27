<?php


namespace calderawp\caldera\restApi;

use calderawp\interop\Contracts\Rest\Endpoint as EndpointContract;
use calderawp\interop\Traits\Rest\ProvidesRestEndpoint;
use calderawp\interop\Contracts\WordPress\ApplysFilters;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Contracts\Rest\RestResponseContract as Response;

abstract class Endpoint implements EndpointContract
{
	use ProvidesRestEndpoint;

	/** @var CalderaRestApi  */
	protected $module;


	public function __construct(CalderaRestApi $module)
	{
		$this->module = $module;
	}

	public function getFilters(): ApplysFilters
	{
		return $this->module->getCalderaEvents()->getHooks();
	}
}
