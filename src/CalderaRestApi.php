<?php


namespace calderawp\caldera\restApi;

use calderawp\caldera\core\CalderaCore;
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

	public function registerServices(ServiceContainer $container): CalderaModule
	{
		return $this;
	}

	public function getCalderaEvents(): CalderaEvents
	{
		return $this
			->getCore()
			->getEvents();
	}
}
