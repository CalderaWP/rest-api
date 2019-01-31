<?php


namespace calderawp\caldera\restApi\Authentication\Endpoints;

use calderawp\caldera\restApi\Authentication\AuthenticationException;
use calderawp\caldera\restApi\Response;
use calderawp\interop\Contracts\Rest\RestRequestContract;
use calderawp\interop\Contracts\Rest\RestResponseContract;

class GenerateToken extends Endpoint
{

	/**
	 * @return array
	 */
	public function getArgs(): array
	{
		return [
			'user' => [
				'type' => 'string',
				'required' => true,
			],
			'pass' => [
				'type' => 'string',
				'required' => true,
			],
		];
	}


	/** @inheritdoc */
	public function handleRequest(RestRequestContract $request): RestResponseContract
	{
		$headers = [];
		$userName = $request->getParam('user');
		$password = $request->getParam('pass');

		try {
			$user = $this->wpJwt->getUserFactory()->fromNamePass($userName, $password);
		} catch (AuthenticationException $e) {
			return Response::fromArray([
				'status' => 401,
				'data' => [ 'verified' => false, 'message' => $e->getMessage(), 'token' => false ],
				'headers' => $headers
			]);
		}

		try {
			$token = $this->wpJwt->tokenFromUser($user);
		} catch (AuthenticationException $e) {
			return Response::fromArray([
				'status' => 401,
				'data' => [ 'verified' => false, 'message' => $e->getMessage(), 'token' => false ],
				'headers' => $headers
			]);
		}

		return Response::fromArray([
			'status' => 201,
			'data' => [ 'verified' => true, 'message' => 'verified', 'token' => $token ],
			'headers' => $headers
		]);
	}
}
