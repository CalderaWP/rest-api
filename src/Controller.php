<?php


namespace calderawp\caldera\restApi;

use calderawp\caldera\DataSource\Contracts\SourceContract as DataSource;
use calderawp\interop\Contracts\HttpRequestContract as Request;
use calderawp\interop\Contracts\HttpResponseContract as Response;

abstract class Controller implements \calderawp\caldera\restApi\Contracts\RestControllerContract
{

	/** @var DataSource  */
	protected $dataSource;
	/** @var callable  */
	protected $handleAuth;
	public function __construct(DataSource $dataSource,callable $handleAuth)
	{
		$this->dataSource =$dataSource;
		$this->handleAuth = $handleAuth;
	}

	public function get(Request $request): Response
	{
		$data = $this->dataSource->read($this->getId($request));
		return$this->response($data);
	}

	public function create(Request $request): Response
	{
		$data = $this->dataSource->create($request->getParams());
		return$this->response($data);

	}

	public function update(Request $request): Response
	{
		$data = $this->dataSource->update($this->getId($request),$request->getParams());
		return$this->response($data);

	}

	public function delete(Request $request): Response
	{
		$data = $this->dataSource->delete($this->getId($request));
		return$this->response($data);

	}

	public function list(Request $request): Response
	{
		$data = $this->dataSource;
		return$this->response($data);

	}

	public function annonymize(Request $request): Response
	{
		$column = $request->getParam( 'column' );
		$data = $this->dataSource->anonymize($this->getId($request), $column);
		return$this->response($data);

	}

	public function authorizeRequest(Request $request): bool
	{
		return $this->handleAuth($request);
	}

	public function search(Request $request): bool
	{
		$searchType = $request->getParam( 'searchType', 'where' );
		$searchColumn = $request->getParam( 'searchColumn' );
		$searchValue = $request->getParam( 'searchValue' );
		if( 'id' === $searchColumn  ){
			$data =  $this->dataSource->findIn($searchValue,'id');
		}elseif( is_array($searchValue)){
			$data = $this->dataSource->findIn($searchValue,$searchColumn);
		}else{
			$data = $this->dataSource->findWhere($searchColumn,$searchValue);
		}
		return$this->response($data);


	}

	protected function response(array $data,int $status = 200 ): Response
	{
		return (new \calderawp\caldera\restApi\Response() )->setStatus($status)->setData($data);
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	private function getId(Request $request): mixed
	{
		return $request->getParam('id');
	}


}
