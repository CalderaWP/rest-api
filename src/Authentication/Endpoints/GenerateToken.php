<?php


namespace calderawp\caldera\restApi\Authentication\Endpoints;
use calderawp\caldera\restApi\Response;
use calderawp\interop\Contracts\Rest\RestRequestContract;
use calderawp\interop\Contracts\Rest\RestResponseContract;


class GenerateToken extends Endpoint
{

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



	public function handleRequest(RestRequestContract $request): RestResponseContract
	{
		$status = 200;
		$data = [];
		$headers = [];
		return Response::fromArray([
			'status' => $status,
			'data' => $data,
			'headers' => $headers
		]);
	}
}
