<?php


namespace calderawp\caldera\restApi\Contracts;

use calderawp\interop\Contracts\Rest\Route as BaseRouteContract;
use calderawp\interop\Contracts\WordPress\ApplysFilters;

interface RouteContract extends BaseRouteContract
{

	/**
	 * Get hooks abstraction
	 *
	 * @return ApplysFilters
	 */
	public function getFilters(): ApplysFilters;
}
