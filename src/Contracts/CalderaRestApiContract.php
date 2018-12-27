<?php


namespace calderawp\caldera\restApi\Contracts;

use calderawp\caldera\Events\CalderaEvents;
use calderawp\interop\Contracts\CalderaModule;

interface CalderaRestApiContract extends CalderaModule
{

	/**
	 * @return CalderaEvents
	 */
	public function getCalderaEvents(): CalderaEvents;
}
