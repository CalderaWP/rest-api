<?php


namespace calderawp\caldera\restApi\Contracts;

use calderawp\caldera\restApi\Authentication\AuthenticationException;
use calderawp\caldera\restApi\Authentication\UserNotFoundException;
use calderawp\caldera\restApi\Contracts\UserFactoryContract as UserFactory;

interface WordPressUserContract
{
	/**
	 * @return UserFactory
	 */
	public function getUserFactory(): UserFactory;

	/**
	 * Attempt to find a WordPress user from a token with their ID encoded in it.
	 *
	 * @param string $token
	 *
	 * @return \WP_User
	 * @throws AuthenticationException
	 * @throws UserNotFoundException
	 */
	public function userFromToken(string $token): \WP_User;

	/**
	 * Create a JWT token for a WordPress User
	 *
	 * @param \WP_User $user
	 * @param array $data
	 *
	 * @return string
	 */
	public function tokenFromUser(\WP_User $user, array $data = []): string;
}
