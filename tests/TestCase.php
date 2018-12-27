<?php


namespace calderawp\caldera\restApi\Tests;

use calderawp\caldera\core\CalderaCore;
use calderawp\caldera\Events\CalderaEvents;
use calderawp\caldera\restApi\CalderaRestApi;
use calderawp\caldera\Core\Tests\Traits\SharedFactories;
use calderawp\CalderaContainers\Service\Container;

abstract class TestCase extends \Mockery\Adapter\Phpunit\MockeryTestCase
{
	use  SharedFactories;
}
