<?php


namespace calderawp\caldera\restApi\Traits;

use calderawp\caldera\restApi\Contracts\RouteContract as Route;
use calderawp\caldera\restApi\Request;

use calderawp\interop\Contracts\Rest\Endpoint as Endpoint;

trait CreatesWordPressEndpoints
{

	/**
	 * Register an endpoint with WordPress
	 *
	 * @param Endpoint $endpoint
	 */
	public function registerRouteWithWordPress(Endpoint $endpoint)
	{
		call_user_func($this->registerFunction, $this->getNamespace(), $endpoint->getUri(), $this->wpArgs($endpoint));
	}


	protected function getNamespace()
	{
		return 'caldera-api/v1';
	}

	/**
	 * Create arguments for register_rest_route()
	 *
	 * @param Endpoint $endpoint
	 *
	 * @return array
	 */
	public function wpArgs(Endpoint $endpoint)
	{
		$callback = $this->createCallBack([$endpoint,'handleRequest']);
		$permissionsCallback = $this->createAuthCallBack([$endpoint,'authorizeRequest']);
		return [
			'args' => $endpoint->getArgs(),
			'methods' => $endpoint->getHttpMethod(),
			'callback' => $callback,
			'permission_callback' => $permissionsCallback
		];
	}

	public function createCallBack(callable $handler) : callable
	{
		return function (\WP_REST_Request $_request) use ($handler) {
			$request = $this->requestFromWp($_request);
			$response = $handler($request);
			return new \WP_REST_Response(
				$response->getData(),
				$response->getStatus(),
				$response->getHeaders()
			);
		};
	}

	public function createAuthCallBack(callable $handler) : callable
	{
		return function ($_request) use ($handler) {
			$request = $this->requestFromWp($_request);
			return $handler($request);
		};
	}

	/**
	 * @param \WP_REST_Request $_request
	 *
	 * @return Request
	 */
	protected function requestFromWp(\WP_REST_Request $_request): Request
	{
		$request = new Request();
		$request->setParams($_request->get_params());
		foreach ($_request->get_headers() as $heder => $headerValue) {
			$request->setHeader($heder, $headerValue);
		}
		return $request;
	}

	/**
	 * @param Route $route
	 */
	protected function registerRoute(Route $route)
	{
		foreach ($route->getEndpoints() as $endpoint) {
			$this->registerRouteWithWordPress($endpoint);
		}
	}
}
