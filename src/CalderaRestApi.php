<?php


namespace calderawp\caldera\restApi;

use calderawp\caldera\Events\CalderaEvents;
use calderawp\interop\Contracts\CalderaModule;
use calderawp\interop\Module;
use calderawp\CalderaContainers\Service\Container as ServiceContainer;

class CalderaRestApi extends Module
{

	public function getIdentifier(): string
	{
		return 'rest-api';
	}

	public function registerServices(ServiceContainer$container): CalderaModule
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
