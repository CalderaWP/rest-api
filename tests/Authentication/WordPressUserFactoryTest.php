<?php


use calderawp\caldera\restApi\Authentication\WordPressUserFactory;
use Brain\Monkey;
use Brain\Monkey\Functions;

class WordPressUserFactoryTest extends \calderawp\caldera\restApi\Tests\TestCase
{
	protected function tearDown()
	{
		Monkey\tearDown();
		parent::tearDown();
	}

	/**
	 * @covers \calderawp\caldera\restApi\Authentication\WordPressUserFactory::fromNamePass()
	 */
	public function testFromNamePassValid()
	{
		$user = Mockery::mock('\WP_User');
		Functions\when('is_wp_error')->justReturn(false);
		Functions\when('wp_authenticate')->justReturn($user);
		$factory = new WordPressUserFactory();

		$this->assertEquals($user, $factory->fromNamePass('strong', 'pass'));
	}

	/**
	 * @covers \calderawp\caldera\restApi\Authentication\WordPressUserFactory::fromNamePass()
	 */
	public function testFromPublicKey()
	{
		$user = Mockery::mock('\WP_User');
		Functions\when('get_users')->justReturn([$user]);
		$factory = new WordPressUserFactory();

		$this->assertEquals($user, $factory->fromPublicKey('strong'));
	}


	/**
	 * @covers \calderawp\caldera\restApi\Authentication\WordPressUserFactory::fromNamePass()
	 */
	public function testFormNamePassInValid()
	{
		$this->expectException(\calderawp\caldera\restApi\Authentication\AuthenticationException::class);
		Functions\when('is_wp_error')->justReturn(true);
		Functions\when('wp_authenticate')->justReturn(false);

		$factory = new WordPressUserFactory();
		$factory->fromNamePass('strong', 'pass');
	}

	/**
	 * @covers \calderawp\caldera\restApi\Authentication\WordPressUserFactory::byId()
	 */
	public function testByIdValid()
	{
		$user = Mockery::mock('\WP_User');
		Functions\when('get_user_by')->justReturn($user);
		$factory = new WordPressUserFactory();
		$this->assertEquals($user, $factory->byId(1));
	}

	/**
	 * @covers \calderawp\caldera\restApi\Authentication\WordPressUserFactory::byId()
	 */
	public function testByIdInvValid()
	{
		$this->expectException(\calderawp\caldera\restApi\Authentication\UserNotFoundException::class);
		Functions\when('get_user_by')->justReturn(false);
		$factory = new WordPressUserFactory();
		$this->assertFalse($factory->byId(1));
	}
}
