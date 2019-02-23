<?php


namespace calderawp\caldera\restApi\Contracts;

use calderawp\interop\Contracts\HttpRequestContract as Request;
use calderawp\interop\Contracts\HttpResponseContract as Response;

interface RestControllerContract
{
	public function get(Request $request): Response;
	public function create(Request$request): Response;
	public function update(Request$request): Response;
	public function delete(Request$request): Response;
	public function list(Request$request): Response;
	public function anonymize(Request$request): Response;
	public function authorizeRequest(Request$request):bool;
	public function search(Request$request):Response;
}
