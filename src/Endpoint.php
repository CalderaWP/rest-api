<?php


namespace calderawp\caldera\restApi;

use calderawp\caldera\restApi\Contracts\EndpointWithHandler as EndpointContract;
use calderawp\interop\Traits\Rest\ProvidesRestEndpoint;

abstract class Endpoint implements EndpointContract
{
	use ProvidesRestEndpoint;


	public function __construct()
	{
	}
}
