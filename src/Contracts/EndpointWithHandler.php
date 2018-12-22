<?php


namespace calderawp\caldera\restApi\Contracts;

use calderawp\caldera\Events\CalderaEvents;
use calderawp\caldera\restApi\Exception;
use calderawp\interop\Contracts\Rest\Endpoint as EndpointContract;
use calderawp\interop\Contracts\WordPress\ApplysFilters;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Contracts\Rest\RestResponseContract as Response;

interface EndpointWithHandler extends EndpointContract
{

	/**
	 * Get name of filter to apply to before create response
	 *
	 * @return string
	 */
	public function getPreHookName() : string;

	/**
	 * Get the name of hook to filter response on
	 *
	 * @return string
	 */
	public function getResponseHookName(): string;
	/**
	 * Get hooks abstraction
	 *
	 * @return ApplysFilters
	 */
	public function getFilters(): ApplysFilters;
	/**
	 * Handle request
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function handleRequest(Request $request) : Response;

	/**
	 * @param Request $request
	 *
	 * @return bool
	 * @throws Exception
	 */
	public function authorizeRequest(Request $request) : bool;
}
