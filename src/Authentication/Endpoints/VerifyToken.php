<?php


namespace calderawp\caldera\restApi\Authentication\Endpoints;

use calderawp\caldera\restApi\Authentication\AuthenticationException;
use calderawp\caldera\restApi\Authentication\UserNotFoundException;
use calderawp\caldera\restApi\Response;
use calderawp\interop\Contracts\Rest\RestRequestContract;
use calderawp\interop\Contracts\Rest\RestResponseContract;

class VerifyToken extends Endpoint
{

	/** @inheritdoc */
	public function getArgs(): array
	{
		return [
			'token' => [
				'type' => 'string',
				'required' => true,
			]
		];
	}


	/** @inheritdoc */
	public function getToken(RestRequestContract $request): string
	{
		return $request->getParam( 'token' );
	}

	/** @inheritdoc */
	public function handleRequest(RestRequestContract $request): RestResponseContract
	{
		$headers = [];
		$token = $this->getToken($request);
		try {
			$this->wpJwt->userFromToken($token);
		} catch (AuthenticationException $e) {
			return Response::fromArray([
				'status' => $e->getCode(),
				'data' => [ 'verified' => false, 'message' => $e->getMessage(), 'token' => false ],
				'headers' => $headers
			]);
		} catch (UserNotFoundException $e) {
			return Response::fromArray([
				'status' => $e->getCode(),
				'data' => [ 'verified' => false, 'message' => $e->getMessage(), 'token' => false ],
				'headers' => $headers
			]);
		}

		return Response::fromArray([
			'status' => 200,
			'data' => [ 'verified' => true, 'message' => 'valid', 'token' => $token ],
			'headers' => $headers
		]);
	}
}
