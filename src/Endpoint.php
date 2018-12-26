<?php


namespace calderawp\caldera\restApi;

use calderawp\interop\Contracts\Rest\Endpoint as EndpointContract;
use calderawp\interop\Traits\Rest\ProvidesRestEndpoint;

abstract class Endpoint implements EndpointContract
{
	use ProvidesRestEndpoint;
}
