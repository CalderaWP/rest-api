<?php


namespace calderawp\caldera\restApi;

use calderawp\caldera\DataSource\Contracts\SourceContract as DataSource;
use calderawp\DB\Exceptions\InvalidColumnException;
use calderawp\interop\Contracts\HttpRequestContract as Request;
use calderawp\interop\Contracts\HttpResponseContract as Response;

abstract class Controller implements \calderawp\caldera\restApi\Contracts\RestControllerContract
{

	/** @var DataSource */
	protected $dataSource;
	/** @var callable */
	protected $handleAuth;

	public function __construct(DataSource $dataSource, callable $handleAuth)
	{
		$this->dataSource = $dataSource;
		$this->handleAuth = $handleAuth;
	}

	public function get(Request $request): Response
	{
		try {
			$data = $this->dataSource->read($this->getId($request));
		} catch (\Exception $e) {
			return $this->exceptionToResponse($e);
		}
		return $this->response($data);
	}

	public function create(Request $request): Response
	{
		try {
			$id = $this->dataSource->create($request->getParams());
		} catch (\Exception $e) {
			return $this->exceptionToResponse($e);
		}
		return $this->response(['id' => $id], 201);
	}

	public function update(Request $request): Response
	{
		try {
			$data = $this->dataSource->update($this->getId($request), $request->getParams());
		} catch (\Exception $e) {
			return $this->exceptionToResponse($e);
		}
		return $this->response($data, 201);
	}

	public function delete(Request $request): Response
	{
		try {
			$deleted = $this->dataSource->delete($this->getId($request));
		} catch (\Exception $e) {
			return $this->exceptionToResponse($e);
		}
		return $this->response(['deleted' => $deleted], $deleted ? 202 : 200);
	}

	public function list(Request $request): Response
	{
		return $this->response(['LOL' => true]);
	}

	public function anonymize(Request $request): Response
	{
		$column = $request->getParam('column');
		try {
			$data = $this->dataSource->anonymize($this->getId($request), $column);
		} catch (\Exception $e) {
			return $this->exceptionToResponse($e);
		}
		return $this->response($data, 202);
	}

	public function authorizeRequest(Request $request): bool
	{
		return (bool)call_user_func($this->handleAuth, $request);
	}

	public function search(Request $request): Response
	{
		$params = $request->getParams();
		$searchColumn = $params[ 'searchColumn' ] ? $params[ 'searchColumn' ] : 'id';
		$searchValue = $params[ 'searchValue' ] ? $params[ 'searchValue' ] : null;
		if ('id' === $searchColumn) {
			try {
				$data = $this->dataSource->findById((int)$searchValue, 'id');
			} catch (\Exception $e) {
				return $this->exceptionToResponse($e);
			}
		} elseif (is_array($searchValue)) {
			try {
				if (!empty($searchValue)) {
					foreach ($searchValue as $index => $value) {
						if (!is_numeric($value)) {
							unset($searchValue[ $index ]);
							continue;
						}
						$searchValue[ $index ] = (int)$value;
					}
				}

				$data = $this->dataSource->findIn($searchValue, 'id');
			} catch (\Exception $e) {
				return $this->exceptionToResponse($e);
			}
		} else {
			try {
				$data = $this->dataSource->findWhere($searchColumn, $searchValue);
			} catch (InvalidColumnException $e) {
				return $this->exceptionToResponse($e);
			} catch (\Exception $e) {
				return $this->exceptionToResponse($e);
			}
		}
		return $this->response($data);
	}

	protected function response(array $data, int $status = 200): Response
	{
		return (new \calderawp\caldera\restApi\Response())->setStatus($status)->setData($data);
	}

	protected function exceptionToResponse(Exception $exception): Response
	{
		return (new \calderawp\caldera\restApi\Response())->setStatus($exception->getCode())->setData(['message' => $exception->getMessage()]);
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	private function getId(Request $request)
	{
		return $request->getParam('id');
	}
}
