<?php


use calderawp\caldera\restApi\Authentication\Endpoints\GenerateToken;
use calderawp\caldera\restApi\Contracts\UserFactoryContract;

class GenerateTokenTest extends \calderawp\caldera\restApi\Tests\TestCase
{

	/**
	 * @covers \calderawp\caldera\restApi\Authentication\Endpoints\GenerateToken::getHttpMethod()
	 */
	public function testGetMethod()
	{
		$wpJwt = Mockery::mock(\calderawp\caldera\restApi\Authentication\WordPressUserJwt::class);
		$endpoint = new GenerateToken($wpJwt);
		$this->assertSame('POST', $endpoint->getHttpMethod());
	}
	/**
	 * @covers \calderawp\caldera\restApi\Authentication\Endpoints\GenerateToken::getArgs()
	 */
	public function testGetArgs()
	{
		$wpJwt = Mockery::mock(\calderawp\caldera\restApi\Authentication\WordPressUserJwt::class);
		$endpoint = new GenerateToken($wpJwt);
		$this->assertIsArray($endpoint->getArgs());
		$this->assertIsArray($endpoint->getArgs()[ 'user' ]);
		$this->assertIsArray($endpoint->getArgs()[ 'pass' ]);
	}

	/**
	 * @covers \calderawp\caldera\restApi\Authentication\Endpoints\GenerateToken::handleRequest()
	 */
	public function testHandleRequest()
	{
		$user = Mockery::mock('\WP_User');
		$userFactory = Mockery::mock(UserFactoryContract::class);
		$userFactory
			->shouldReceive('fromNamePass')
			->andReturn($user);
		$user = Mockery::mock('\\WP_User');
		$wpJwt = Mockery::mock(\calderawp\caldera\restApi\Authentication\WordPressUserJwt::class);
		$wpJwt
			->shouldReceive('tokenFromUser')
			->andReturn('12345.12345.12345');
		$wpJwt
			->shouldReceive('getUserFactory')
			->andReturn($userFactory);
		$endpoint = new GenerateToken($wpJwt);
		$request = Mockery::mock(\calderawp\caldera\restApi\Request::class);
		$request
			->shouldReceive('getParam')
			->andReturn('12345');
		$response = $endpoint->handleRequest($request);

		$this->assertIsObject($endpoint->handleRequest($request));
		$this->assertSame(201, $response->getStatus());
	}

	/**
	 * @covers \calderawp\caldera\restApi\Authentication\Endpoints\GenerateToken::handleRequest()
	 */
	public function testHandleInvalidUserOrPass()
	{
		$userFactory = Mockery::mock(UserFactoryContract::class);
		$userFactory
			->shouldReceive('fromNamePass')
			->andThrow(\calderawp\caldera\restApi\Authentication\AuthenticationException::class);
		$wpJwt = Mockery::mock(\calderawp\caldera\restApi\Authentication\WordPressUserJwt::class);
		$wpJwt
			->shouldReceive('getUserFactory')
			->andReturn($userFactory);
		$endpoint = new GenerateToken($wpJwt);
		$request = Mockery::mock(\calderawp\caldera\restApi\Request::class);
		$request
			->shouldReceive('getParam')
			->andReturn('strong');
		$response = $endpoint->handleRequest($request);
		$this->assertFalse($response->getData()[ 'token' ]);
		$this->assertSame(401, $response->getStatus());
	}

	/**
	 * @covers \calderawp\caldera\restApi\Authentication\Endpoints\GenerateToken::handleRequest()
	 */
	public function testHandleInvalidUser()
	{

		$user = Mockery::mock('\Wp_User');
		$userFactory = Mockery::mock(UserFactoryContract::class);
		$userFactory
			->shouldReceive('fromNamePass')
			->andReturn($user);

		$wpJwt = Mockery::mock(\calderawp\caldera\restApi\Authentication\WordPressUserJwt::class);
		$wpJwt
			->shouldReceive('getUserFactory')
			->andReturn($userFactory);

		$wpJwt
			->shouldReceive('tokenFromUser')
			->andThrow(\calderawp\caldera\restApi\Authentication\AuthenticationException::class);
		$endpoint = new GenerateToken($wpJwt);
		$request = Mockery::mock(\calderawp\caldera\restApi\Request::class);
		$request
			->shouldReceive('getParam')
			->andReturn('strong');
		$response = $endpoint->handleRequest($request);
		$this->assertFalse($response->getData()[ 'token' ]);
		$this->assertSame(401, $response->getStatus());
	}
}
