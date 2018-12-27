<?php


namespace calderawp\caldera\restApi\Contracts;

use calderawp\caldera\Events\CalderaEvents;
use calderawp\interop\Contracts\CalderaModule;

interface CalderaRestApiContract extends CalderaModule
{

	public function setCalderaEvents(CalderaEvents $events);
	public function getCalderaEvents(): CalderaEvents;
}
