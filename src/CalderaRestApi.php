<?php


namespace calderawp\caldera\restApi;

use calderawp\caldera\restApi\Contracts\CalderaRestApiContract;
use calderawp\caldera\Events\CalderaEvents;
use calderawp\interop\Contracts\CalderaModule;
use calderawp\interop\Module;
use calderawp\CalderaContainers\Service\Container as ServiceContainer;

class CalderaRestApi extends Module implements CalderaRestApiContract
{

	const IDENTIFIER = 'rest-api';
	public function getIdentifier(): string
	{
		return self::IDENTIFIER;
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
