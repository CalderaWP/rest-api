<?php


use calderawp\caldera\restApi\Authentication\Endpoints\VerifyToken;
use PHPUnit\Framework\TestCase;

class VerifyTokenTest extends TestCase
{

	/**
	 * @covers \calderawp\caldera\restApi\Authentication\Endpoints\Endpoint::authorizeRequest()
	 */
	public function testAuthorizeRequest()
	{
		$wpJwt = Mockery::mock(\calderawp\caldera\restApi\Authentication\WordPressUserJwt::class);
		$endpoint = new VerifyToken($wpJwt);
		$request = Mockery::mock(\calderawp\caldera\restApi\Request::class);

		$this->assertTrue($endpoint->authorizeRequest($request));
	}

	/**
	 * @covers \calderawp\caldera\restApi\Authentication\Endpoints\VerifyToken::authorizeRequest()
	 */
	public function testHandleRequest()
	{
		$token = 'token.token.token';
		$wpJwt = Mockery::mock(\calderawp\caldera\restApi\Authentication\WordPressUserJwt::class);
		$wpJwt->shouldReceive('tokenFromUser')
			->andReturn($token);
		$endpoint = new VerifyToken($wpJwt);
		$request = Mockery::mock(\calderawp\caldera\restApi\Request::class);

		$this->assertTrue($endpoint->authorizeRequest($request));
	}

	/**
	 * @covers \calderawp\caldera\restApi\Authentication\Endpoints\Endpoint::getToken()
	 */
	public function testGetToken()
	{
		$wpJwt = Mockery::mock(\calderawp\caldera\restApi\Authentication\WordPressUserJwt::class);
		$endpoint = new VerifyToken($wpJwt);
		$request = Mockery::mock(\calderawp\caldera\restApi\Request::class);
		$request->shouldReceive('getParam' )->andReturn('a');
		$this->assertEquals('a', $endpoint->getToken($request));
	}

	/**
	 * @covers \calderawp\caldera\restApi\Authentication\Endpoints\VerifyToken::getArgs()
	 */
	public function testGetArgs()
	{
		$wpJwt = Mockery::mock(\calderawp\caldera\restApi\Authentication\WordPressUserJwt::class);
		$endpoint = new VerifyToken($wpJwt);
		$this->assertIsArray($endpoint->getArgs());
		$this->assertIsArray($endpoint->getArgs()['token']);
	}

	/**
	 * @covers \calderawp\caldera\restApi\Authentication\Endpoints\VerifyToken::getUri()
	 */
	public function testGetUri()
	{
		$wpJwt = Mockery::mock(\calderawp\caldera\restApi\Authentication\WordPressUserJwt::class);
		$endpoint = new VerifyToken($wpJwt);
		$this->assertEquals('/jwt', $endpoint->getUri());
	}

	/**
	 * @covers \calderawp\caldera\restApi\Authentication\Endpoints\Endpoint::setToken()
	 */
	public function testSetToken()
	{
		$wpJwt = Mockery::mock(\calderawp\caldera\restApi\Authentication\WordPressUserJwt::class);
		$endpoint = new VerifyToken($wpJwt);
		$endpoint->setToken('a');
		$this->assertAttributeEquals('a', 'token', $endpoint);
	}
}
