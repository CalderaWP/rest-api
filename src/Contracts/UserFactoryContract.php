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

	/**
	 * Find User by public key
	 *
	 * @param string $key
	 *
	 * @return \WP_User|bool
	 */
	public function fromPublicKey(string $key);

	/**
	 * Set user public key
	 *
	 * @param int $userId
	 * @param string $key
	 */
	public function setUserPublicKey(int $userId, string $key): void;

	/**
	 * Get a user's public key, creating if needed.
	 *
	 * @param \WP_User $user
	 *
	 * @return string
	 */
	public function getPublicKeyFromUser(\WP_User $user ) : string;
}
