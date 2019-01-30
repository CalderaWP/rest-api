<?php


namespace calderawp\caldera\restApi\Authentication\Endpoints;


use calderawp\caldera\restApi\Authentication\WordPressUserJwt;
use calderawp\caldera\restApi\CalderaRestApi;
use calderawp\interop\Contracts\Rest\Endpoint as EndpointContract;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Traits\Rest\ProvidesRestEndpoint;

abstract class Endpoint implements EndpointContract
{

	use ProvidesRestEndpoint;
	/**
	 * @var WordPressUserJwt
	 */
	protected $wpJwt;
	public function __construct(WordPressUserJwt $wpJwt )
	{
		$this->wpJwt = $wpJwt;
	}

	/** @inheritdoc */
	public function authorizeRequest(Request $request): bool
	{
		//These endpoints for authentication, anyone can try.
		return true;
	}

	/** @inheritdoc */
	public function getUri(): string
	{
		return '/jwt';
	}

	/** @inheritdoc */
	public function getToken(Request $request): string
	{
		//not used
		return '';
	}

}
