<?php


namespace calderawp\caldera\restApi\Authentication;


class WordPressUserJwt
{

	public function userFromToken(string $token ) : \WP_User
	{

	}

	public function tokenFromUser( \WP_User $user, array  $data = [] ) : string 
	{

	}
}
