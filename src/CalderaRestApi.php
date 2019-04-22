<?php


namespace calderawp\caldera\restApi;

use calderawp\caldera\Forms\Controllers\EntryController;
use calderawp\caldera\Forms\Controllers\FormsController;
use calderawp\caldera\restApi\Authentication\WordPressUserFactory;
use calderawp\caldera\restApi\Authentication\WordPressUserJwt;
use calderawp\caldera\restApi\Authentication\WpRestApi;
use calderawp\caldera\restApi\Contracts\CalderaRestApiContract;
use calderawp\caldera\Events\CalderaEvents;
use calderawp\caldera\restApi\Endpoints\Entry\CreateEntry;
use calderawp\caldera\restApi\Endpoints\Entry\GetEntries;
use calderawp\caldera\restApi\Endpoints\Entry\GetEntry;
use calderawp\caldera\restApi\Endpoints\Form\GetForm;
use calderawp\caldera\restApi\Endpoints\Form\GetForms;
use calderawp\caldera\restApi\Routes\EntryRoute;
use calderawp\caldera\restApi\Routes\FormRoute;
use calderawp\interop\Contracts\CalderaModule;
use calderawp\interop\Module;
use calderawp\CalderaContainers\Service\Container as ServiceContainer;
use calderawp\caldera\restApi\Contracts\RouteContract;

use calderawp\caldera\restApi\Contracts\AuthenticateRestApiContract as WpRestApiAuth;
use calderawp\caldera\restApi\Contracts\UserFactoryContract as UserFactory;
use calderawp\caldera\restApi\Contracts\WordPressUserContract as WordPressUser;

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

		$container->bind(UserFactory::class, function () {
			return new WordPressUserFactory();
		});

		$siteUrl = isset($_ENV[ 'WP_SITE_URL' ]) ? $_ENV[ 'WP_SITE_URL' ] : 'https://caldera.lando.site';
		$container->bind(WordPressUser::class, function () use ($container, $siteUrl) {
			return new WordPressUserJwt(
				$container->make(UserFactory::class),
				isset($_ENV[ 'JWT_SECRET' ]) ? $_ENV[ 'JWT_SECRET' ] : 12345,
				$siteUrl
			);
		});


		$container->singleton(WpRestApiAuth::class, function () use ($container, $siteUrl) {
			return new WpRestApi(
				$container->make(WordPressUser::class),
				$siteUrl
			);
		});

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


	public function getWpRestApiAuth() :WpRestApiAuth
	{
		return$this->getServiceContainer()->make(WpRestApiAuth::class);
	}
}
