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


	/**
	 * Get a token, using current token system
	 *
	 * @param string $nonceAction Unique ID -- think WordPress nonce action -- for token
	 *
	 * @return TokenContract
	 */
	public function getToken(string $nonceAction): TokenContract;
}
