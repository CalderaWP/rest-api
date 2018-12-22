<?php


namespace calderawp\caldera\restApi;

use calderawp\interop\Contracts\Rest\RestRequestContract;
use calderawp\interop\Traits\Rest\ProvidesHttpHeaders;
use calderawp\interop\Traits\Rest\ProvidesRestParams;

class Request implements RestRequestContract
{

	use ProvidesHttpHeaders, ProvidesRestParams;


	public static function fromArray(array $items = ['headers' => [], 'params' => [] ])
	{
		$obj = new static();
		if (! empty($items['headers'])) {
			foreach ($items['headers'] as $header => $value) {
				$obj->setHeader($header, $value);
			}
		}

		if (! empty($items['params'])) {
			$obj->setParams($items['params']);
		}
		return $obj;
	}
}
