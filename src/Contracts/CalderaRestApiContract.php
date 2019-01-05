<?php


namespace calderawp\caldera\restApi\Contracts;

use calderawp\caldera\Events\CalderaEvents;
use calderawp\interop\Contracts\CalderaModule;
use \calderawp\interop\Contracts\TokenContract;

interface CalderaRestApiContract extends CalderaModule
{

	/**
	 * @return CalderaEvents
	 */
	public function getCalderaEvents(): CalderaEvents;

	public function addRoute(RouteContract $route): CalderaRestApiContract;

	public function getRoute(string $className) : RouteContract;
}
