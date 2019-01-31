<?php


namespace calderawp\caldera\restApi\Tests\Mocks;

use calderawp\caldera\restApi\Traits\CreatesWordPressEndpoints;

class RegisterEndpointsWithWordPressMock
{

	use  CreatesWordPressEndpoints;

	/** @var callable */
	protected $registerFunction;

	/** @var string */
	protected $namespace = 'caldera-api/v1';

	protected $callbackCalled = false;


	public function __construct()
	{
		$this->registerFunction = [$this, 'callback'];
	}

	public function callback()
	{
		$this->callbackCalled = true;
	}
}
