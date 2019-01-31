<?php


use calderawp\caldera\restApi\Authentication\Endpoints\GenerateToken;

class GenerateTokenTest extends \calderawp\caldera\restApi\Tests\TestCase
{

	/**
	 * @covers \calderawp\caldera\restApi\Authentication\Endpoints\GenerateToken::getArgs()
	 */
	public function testGetArgs()
	{
		$wpJwt = Mockery::mock(\calderawp\caldera\restApi\Authentication\WordPressUserJwt::class );
		$endpoint = new GenerateToken($wpJwt);
		$this->assertIsArray($endpoint->getArgs());
		$this->assertIsArray($endpoint->getArgs()['user']);
		$this->assertIsArray($endpoint->getArgs()['pass']);
	}

	/**
	 * @covers \calderawp\caldera\restApi\Authentication\Endpoints\GenerateToken::handleRequest()
	 */
	public function testHandleRequest()
	{
		$user= Mockery::mock( '\\WP_User');
		$wpJwt = Mockery::mock(\calderawp\caldera\restApi\Authentication\WordPressUserJwt::class );
		$wpJwt
			->shouldReceive( 'userFormToken' )
			->andReturn($user);
		$endpoint = new GenerateToken($wpJwt);
		$request = Mockery::mock(\calderawp\caldera\restApi\Request::class );
		$request
			->shouldReceive('getParam' )
			->andReturn( '12345' );
		$this->assertIsObject($endpoint->handleRequest($request));
	}

	/**
	 * @covers \calderawp\caldera\restApi\Authentication\Endpoints\GenerateToken::handleRequest()
	 */
	public function testHandleInvalidRequest()
	{
		$user= Mockery::mock( '\\WP_User');
		$wpJwt = Mockery::mock(\calderawp\caldera\restApi\Authentication\WordPressUserJwt::class );
		$wpJwt
			->shouldReceive( 'userFormToken' )
			->andReturn(false);
		$endpoint = new GenerateToken($wpJwt);
		$request = Mockery::mock(\calderawp\caldera\restApi\Request::class );
		$this->expectException(\Exception::class);
		$endpoint->handleRequest($request);
	}
}
