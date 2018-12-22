<?php


namespace calderawp\caldera\restApi;

use calderawp\interop\Contracts\Rest\Route as RouteContract;
use calderawp\interop\Traits\Rest\ProvidesRoute;

abstract class Route implements RouteContract
{
	use ProvidesRoute;
}
