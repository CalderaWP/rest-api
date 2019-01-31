<?php


namespace calderawp\caldera\restApi\Contracts;

use calderawp\caldera\restApi\Authentication\AuthenticationException;
use calderawp\caldera\restApi\Authentication\UserNotFoundException;

interface UserFactoryContract
{
	/**
	 * Find a WordPress user by user ID
	 *
	 * @param int $id
	 *
	 * @return \WP_User
	 * @throws UserNotFoundException
	 */
	public function byId(int $id): \WP_User;

	/**
	 * Attempt to login a user by WordPress user/pass
	 *
	 * @param string $user
	 * @param string $pass
	 *
	 * @return \WP_User
	 * @throws AuthenticationException
	 */
	public function fromNamePass(string $user, string $pass);
}
