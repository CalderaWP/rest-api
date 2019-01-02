<?php


namespace calderawp\caldera\restApi;

use calderawp\caldera\Forms\Controllers\EntryController;
use calderawp\caldera\Forms\Controllers\FormsController;
use calderawp\caldera\restApi\Contracts\CalderaRestApiContract;
use calderawp\caldera\Events\CalderaEvents;
use calderawp\caldera\restApi\Endpoints\Entry\CreateEntry;
use calderawp\caldera\restApi\Endpoints\Entry\GetEntries;
use calderawp\caldera\restApi\Endpoints\Entry\GetEntry;
use calderawp\caldera\restApi\Endpoints\Form\GetForm;
use calderawp\caldera\restApi\Endpoints\Form\GetForms;
use calderawp\caldera\restApi\Routes\EntryRoute;
use calderawp\caldera\restApi\Routes\FormRoute;
use calderawp\caldera\restApi\Token\Csfr;
use calderawp\interop\Contracts\CalderaModule;
use calderawp\interop\Module;
use calderawp\CalderaContainers\Service\Container as ServiceContainer;
use calderawp\caldera\restApi\Contracts\RouteContract;
use \calderawp\interop\Contracts\TokenContract;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class CalderaRestApi extends Module implements CalderaRestApiContract
{

	const IDENTIFIER = 'rest-api';
	/**
	 * @var CalderaRestApiContract[]
	 */
	protected $routes;

	public function getIdentifier(): string
	{
		return self::IDENTIFIER;
	}

	/** @inheritdoc */
	public function registerServices(ServiceContainer $container): CalderaModule
	{
		$this->addRoute(
			(new EntryRoute($this))
				->setController(new EntryController($this->core->getCalderaForms()))
				->addEndpoints([
					new CreateEntry($this),
					new GetEntry($this),
					new GetEntries($this),
				])
		);
		$this->addRoute(
			(new FormRoute($this))
				->setController(new FormsController($this->core->getCalderaForms()))
				->addEndpoints([
					new GetForms($this),
					new GetForm($this),
				])
		);

		$container
			->singleton(
				CsrfTokenManagerInterface::class,
				function () {
					return new CsrfTokenManager();
				}
			);

		return $this;
	}

	public function getCalderaEvents(): CalderaEvents
	{
		return $this
			->getCore()
			->getEvents();
	}


	public function addRoute(RouteContract $route): CalderaRestApiContract
	{
		$this->routes[ get_class($route) ] = $route;
		return $this;
	}

	public function getRoute(string $className): RouteContract
	{
		if (isset($this->routes[ $className ])) {
			return $this->routes[ $className ];
		}
		throw new Exception('Route not registered', 500);
	}

	/** @inheritdoc */
	public function getToken(string $nonceAction): TokenContract
	{
		$manger = $this
			->getServiceContainer()
			->make(CsrfTokenManagerInterface::class);
		return ( new Csfr($nonceAction, $manger));
	}
}
