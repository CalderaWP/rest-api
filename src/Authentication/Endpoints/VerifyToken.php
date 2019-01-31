<?php


namespace calderawp\caldera\restApi\Authentication\Endpoints;

use calderawp\caldera\restApi\Authentication\AuthenticationException;
use calderawp\caldera\restApi\Authentication\UserNotFoundException;
use calderawp\caldera\restApi\Response;
use calderawp\interop\Contracts\Rest\RestRequestContract;
use calderawp\interop\Contracts\Rest\RestResponseContract;

class VerifyToken extends Endpoint
{

	public function getArgs(): array
	{
		return [
			'token' => [
				'type' => 'string',
				'required' => true,
			]
		];
	}



	public function handleRequest(RestRequestContract $request): RestResponseContract
	{
		$headers = [];
		try {
			$this->wpJwt->userFromToken($this->getToken($request));
		} catch (AuthenticationException $e) {
			return Response::fromArray([
				'status' => $e->getCode(),
				'data' => [ 'verified' => false, 'message' => $e->getMessage() ],
				'headers' => $headers
			]);
		} catch (UserNotFoundException $e) {
			return Response::fromArray([
				'status' => $e->getCode(),
				'data' => [ 'verified' => false, 'message' => $e->getMessage() ],
				'headers' => $headers
			]);
		}

		return Response::fromArray([
			'status' => 200,
			'data' => [ 'verified' => true, 'message' => 'valid' ],
			'headers' => $headers
		]);
	}
}
