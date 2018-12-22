<?php


namespace calderawp\caldera\restApi;

use calderawp\caldera\Events\CalderaEvents;
use calderawp\interop\Contracts\CalderaModule;
use calderawp\interop\Module;

class CalderaRestApi extends Module
{

	public function getIdentifier(): string
	{
		return 'rest-api';
	}

	public function registerServices(): CalderaModule
	{
		return $this;
	}


	public function setCalderaEvents(CalderaEvents $events)
	{
		$this->getServiceContainer()->singleton(
			CalderaEvents::class,
			function () use ($events) {
				return $events;
			}
		);
	}

	public function getCalderaEvents(): CalderaEvents
	{
		return $this->getServiceContainer()->make(CalderaEvents::class);
	}
}
