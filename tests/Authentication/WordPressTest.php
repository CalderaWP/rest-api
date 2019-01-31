<?php


use calderawp\caldera\restApi\Authentication\WpRestApi;
use Brain\Monkey;
use Brain\Monkey\Functions;
use calderawp\caldera\restApi\Contracts\UserFactoryContract;


class WordPressTest extends \calderawp\caldera\restApi\Tests\TestCase
{

	public function setUp()
	{
		$_SERVER['HTTP_AUTHORIZATION'] = '1234';
		parent::setUp();
	}

	protected function tearDown()
	{
		Monkey\tearDown();
		parent::tearDown();
	}

	public function testGetToken()
	{
		$jwt = Mockery::mock(\calderawp\caldera\restApi\Authentication\WordPressUserJwt::class);
		$siteUrl = 'https://calderaforms.com';
		$auth = new WpRestApi($jwt,$siteUrl);
		$auth->setTokenFromHeaders();
		$this->assertSame('1234',$auth->getToken() );
	}

	public function testDetermineUser()
	{
		$_SERVER['HTTP_AUTHORIZATION'] = '1234';

		Functions\when('add_filter')->justReturn(true );
		$user = Mockery::mock('\WP_User');
		$user->ID = 7;
		$jwt = Mockery::mock(\calderawp\caldera\restApi\Authentication\WordPressUserJwt::class);
		$jwt
			->shouldReceive( 'userFromToken' )
			->andReturn( $user);
		$siteUrl = 'https://calderaforms.com';
		$auth = new WpRestApi($jwt,$siteUrl);
		$this->assertSame(1,$auth->determineUser(1) ); //do nothing if already set

		$this->assertSame( 7, $auth->determineUser(null) ); //should set ID from supplied user




	}

	public function testAddHooks()
	{
		Functions\when('add_filter')->justReturn(true );
		$userFactory = Mockery::mock(UserFactoryContract::class);
		$jwt = Mockery::mock(\calderawp\caldera\restApi\Authentication\WordPressUserJwt::class);
		$siteUrl = 'https://calderaforms.com';
		$auth = new WpRestApi($jwt,$siteUrl);
		$this->assertTrue($auth->addHooks());

	}

	public function testInitTokenRoutes()
	{
		Functions\when('register_rest_route')->justReturn(true );
		$userFactory = Mockery::mock(UserFactoryContract::class);
		$jwt = Mockery::mock(\calderawp\caldera\restApi\Authentication\WordPressUserJwt::class);
		$siteUrl = 'https://calderaforms.com';
		$auth = new WpRestApi($jwt,$siteUrl);
		$auth->setTokenFromHeaders();
		$this->assertIsObject($auth->initTokenRoutes());

	}

	/**
	 * @covers \calderawp\caldera\restApi\Authentication\WpRestApi::setTokenFromHeaders()
	 */
	public function testSetTokenFromHeaders()
	{
		$jwt = Mockery::mock(\calderawp\caldera\restApi\Authentication\WordPressUserJwt::class);
		$siteUrl = 'https://calderaforms.com';
		$auth = new WpRestApi($jwt,$siteUrl);
		$auth->setTokenFromHeaders();
		$this->assertAttributeEquals('1234','token',$auth);

	}

}
