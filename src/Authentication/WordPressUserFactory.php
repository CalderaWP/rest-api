<?php


namespace calderawp\caldera\restApi\Authentication;


class WordPressUserFactory
{


	/**
	 * Find a WordPress user by user ID
	 *
	 * @param int $id
	 *
	 * @return \WP_User
	 * @throws UserNotFoundException
	 */
	public function byId(int $id ): \WP_User
	{
		$user = get_user_by('id', $id );
		if( ! $user ){
			throw new UserNotFoundException('User Not Found', 404 );
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
		$user = wp_authenticate($user,$pass);
		if( ! $user || is_wp_error( $user ) ){
			throw new AuthenticationException( 'Invalid user or password', 401 );

		}
		return $user;
	}
}
