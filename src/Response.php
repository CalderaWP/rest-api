<?php


namespace calderawp\caldera\restApi;

use calderawp\interop\Contracts\Rest\RestResponseContract;
use calderawp\interop\Traits\Rest\ProvidesRestResponse;

class Response implements RestResponseContract
{

	use ProvidesRestResponse;

	/**
	 * @param string $name
	 * @param string $value
	 *
	 * @return Response
	 */
	public function addHeader(string $name, string $value): Response
	{
		$headers = $this->getHeaders();
		if (!is_array($headers)) {
			$headers = [];
		}

		$this->headers[ $name ] = $value;
		return $this;
	}

	public static function fromArray($items): RestResponseContract
	{
		$obj = new static();
		foreach ([
					 'data' => 'setData',
					 'headers' => 'setHeaders',
					 'status' => 'setStatus',
				 ] as $key => $setter) {
			if (isset($items[ $key ])) {
				call_user_func([$obj, $setter], $items[ $key ]);
			}
		}

		return $obj;
	}
}
