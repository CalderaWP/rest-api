<?php


namespace calderawp\caldera\restApi\Authentication;

use calderawp\caldera\restApi\Contracts\UserFactoryContract;

class WordPressUserFactory implements UserFactoryContract
{


	/**
	 * Find a WordPress user by user ID
	 *
	 * @param int $id
	 *
	 * @return \WP_User
	 * @throws UserNotFoundException
	 */
	public function byId(int $id): \WP_User
	{
		$user = get_user_by('id', $id);
		if (! $user) {
			throw new UserNotFoundException('User Not Found', 404);
		}
		return $user;
	}

	/**
	 * Attempt to login a user by WordPress user/pass
	 *
	 * @param string $user
	 * @param string $pass
	 *
	 * @return \WP_User
	 * @throws AuthenticationException
	 */
	public function fromNamePass(string $user, string $pass)
	{
		$user = wp_authenticate($user, $pass);
		if (is_wp_error($user)) {
			throw new AuthenticationException('Invalid user or password', 401);
		}
		return $user;
	}

	/**
	 * Find User by public key
	 * @param string $key
	 *
	 * @return \WP_User|bool
	 */
	public function fromPublicKey(string  $key)
	{
		$users = get_users(['meta_key' => '_calderaPublicKey', 'meta_value' => $key]);
		if (! empty($users)) {
			return $users[0];
		}
		return false;
	}

	/**
	 * Set user public key
	 *
	 * @param int $userId
	 * @param string $key
	 */
	public function setUserPublicKey(int$userId, string $key):void
	{
		delete_user_meta($userId, '_calderaPublicKey');
		add_user_meta($userId, '_calderaPublicKey', $key);
	}

	/**
	 * Get a user's public key, creating if needed.
	 *
	 * @param \WP_User $user
	 *
	 * @return string
	 */
	public function getPublicKeyFromUser(\WP_User $user ) : string
	{
		$publicKey = $user->get('_calderaPublicKey');
		if( empty( $publicKey)){
			$this->setUserPublicKey($user->ID, wp_generate_password());
			$publicKey = $user->get('_calderaPublicKey');
		}
		return $publicKey;
	}
}
