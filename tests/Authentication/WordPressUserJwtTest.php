<?php


use calderawp\caldera\restApi\Authentication\WordPressUserJwt;
use calderawp\caldera\restApi\Contracts\UserFactoryContract;
use Brain\Monkey;
use Brain\Monkey\Functions;

class WordPressUserJwtTest extends \calderawp\caldera\restApi\Tests\TestCase
{
	protected function tearDown()
	{
		Monkey\tearDown();
		parent::tearDown();
	}

	/** @covers \calderawp\caldera\restApi\Authentication\WordPressUserJwt::userFromToken() */
	public function testUserFromToken()
	{
		$secret = '1234';
		$iss = 'https://hiroy.club';
		$userFactory = Mockery::mock(UserFactoryContract::class);
		$user = Mockery::mock('\WP_User');
		Functions\when('is_wp_error')->justReturn(false);
		Functions\when('wp_authenticate')->justReturn($user);
		$user = Mockery::mock('\WP_User');
		$user->ID = 1;
		$userFactory->shouldReceive('byId')->andReturn($user);
		$jwt = new WordPressUserJwt($userFactory, $secret, $iss);
		$token = \Firebase\JWT\JWT::encode([
			'iat' => time(), 'iss' => $iss, 'data' => [
				'user' => ['id' => 1 ]
			]
		], $secret);
		$this->assertEquals($user, $jwt->userFromToken($token));
	}

	/** @covers \calderawp\caldera\restApi\Authentication\WordPressUserJwt::userFromToken() */
	public function testUserFromInvalidToken()
	{
		$this->expectException(\calderawp\caldera\restApi\Authentication\AuthenticationException::class);
		$this->expectExceptionCode(500);
		$secret = '1234';
		$iss = 'https://hiroy.club';
		$userFactory = Mockery::mock(UserFactoryContract::class);
		$jwt = new WordPressUserJwt($userFactory, $secret, $iss);
		$jwt->userFromToken('aaaa');//random token
	}


	/** @covers \calderawp\caldera\restApi\Authentication\WordPressUserJwt::userFromToken() */
	public function testUserFromTokenInvalidIss()
	{
		$this->expectException(\calderawp\caldera\restApi\Authentication\AuthenticationException::class);
		$this->expectExceptionCode(401);
		$this->expectExceptionMessage('Invalid Token ISS');
		$secret = '1234';
		$iss = 'https://hiroy.club';
		$userFactory = Mockery::mock(UserFactoryContract::class);
		$user = Mockery::mock('\WP_User');
		$user->ID = 1;
		$userFactory->shouldReceive('byId')->andReturn($user);
		$jwt = new WordPressUserJwt($userFactory, $secret, $iss);
		$token = \Firebase\JWT\JWT::encode([
			'iat' => time(),
			'iss' => 'https://someothersite.com',//Do not allow other site's tokens to be used
			'data' => [
				'user' => ['id' => 1 ]
			]
		], $secret);
		$this->assertEquals($user, $jwt->userFromToken($token));
	}

	/** @covers \calderawp\caldera\restApi\Authentication\WordPressUserJwt::userFromToken() */
	public function testUserFromTokenMissingId()
	{
		$this->expectExceptionCode(401);
		$this->expectExceptionMessage('Invalid User');
		$secret = '1234';
		$iss = 'https://hiroy.club';
		$userFactory = Mockery::mock(UserFactoryContract::class);
		$user = Mockery::mock('\WP_User');
		Functions\when('is_wp_error')->justReturn(false);
		Functions\when('wp_authenticate')->justReturn($user);
		$user = Mockery::mock('\WP_User');
		$userFactory->shouldReceive('byId')->andReturn($user);
		$jwt = new WordPressUserJwt($userFactory, $secret, $iss);
		$token = \Firebase\JWT\JWT::encode([
			'iat' => time(), 'iss' => $iss, 'data' => [
				'user' => ['user_name' => 'admin' ] //no ID? no decode
			]
		], $secret);
		$this->assertEquals($user, $jwt->userFromToken($token));
	}

	/** @covers \calderawp\caldera\restApi\Authentication\WordPressUserJwt::userFromToken() */
	public function testUserFromTokenDifferentUserId()
	{
		$this->expectExceptionCode(401);
		$this->expectExceptionMessage('Invalid User');
		$secret = '1234';
		$iss = 'https://hiroy.club';
		$userFactory = Mockery::mock(UserFactoryContract::class);
		$user = Mockery::mock('\WP_User');
		Functions\when('is_wp_error')->justReturn(false);
		Functions\when('wp_authenticate')->justReturn($user);
		$user = Mockery::mock('\WP_User');
		$user->ID = 1;
		$userFactory->shouldReceive('byId')->andReturn($user);
		$jwt = new WordPressUserJwt($userFactory, $secret, $iss);
		$token = \Firebase\JWT\JWT::encode([
			'iat' => time(), 'iss' => $iss, 'data' => [
				'user' => ['id' => 2 ]//prevent decoding tokens issued for other users
			]
		], $secret);
		$this->assertEquals($user, $jwt->userFromToken($token));
	}


	/** @covers \calderawp\caldera\restApi\Authentication\WordPressUserJwt::tokenFromUser() */
	public function testTokenFromUser()
	{
		$secret = '1234';
		$iss = 'https://hiroy.club';
		$user = Mockery::mock('\WP_User');
		$user->ID = 1;
		$userFactory = Mockery::mock(UserFactoryContract::class);
		$jwt = new WordPressUserJwt($userFactory, $secret, $iss);
		$this->assertIsString($jwt->tokenFromUser($user));
		$this->assertIsString($jwt->tokenFromUser($user, ['aa' => 1]));
	}

	/** @covers \calderawp\caldera\restApi\Authentication\WordPressUserJwt::getUserFactory() */
	public function testGetUserFactory()
	{
		$secret = '1234';
		$iss = 'https://hiroy.club';
		$userFactory = Mockery::mock(UserFactoryContract::class);
		$jwt = new WordPressUserJwt($userFactory, $secret, $iss);
		$this->assertSame($userFactory, $jwt->getUserFactory());
	}
}
