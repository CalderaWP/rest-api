<?php


namespace calderawp\caldera\restApi\Authentication;


class WordPressUserJwt
{

	/** @var string */
	protected $siteUrl;
	protected $secret;
	/** @var WordPressUserFactory */
	protected $userFactory;

	/**
	 * Attempt to find a WordPress user from a token with their ID encoded in it.
	 *
	 * @param string $token
	 *
	 * @return \WP_User
	 * @throws AuthenticationException
	 * @throws UserNotFoundException
	 */
	public function userFromToken(string $token): \WP_User
	{

		try {
			$token = \Firebase\JWT\JWT::decode($token, $this->secret, ['HS256']);
		} catch (\Exception $e) {
			throw new AuthenticationException($e->getMessage(), $e->getCode());
		}

		if (!hash_equals($this->siteUrl, $token->iss)) {
			throw new AuthenticationException('Invalid Token ISS', 401);
		}

		if (!isset($token->data->user->id)) {
			throw new AuthenticationException('Invalid User', 401);
		}

		$user = $this->userFactory->byId($token->data->user->id);

		return $user;
	}

	/**
	 * Create a JWT token for a WordPress User
	 *
	 * @param \WP_User $user
	 * @param array $data
	 *
	 * @return string
	 */
	public function tokenFromUser(\WP_User $user, array $data = []): string
	{
		$issuedAt = time();
		$notBefore = $issuedAt;
		$tokenData = [
			'iss' => $this->siteUrl,
			'iat' => $issuedAt,
			'nbf' => $notBefore,
			'data' => array_merge([
				'user' => [
					'id' => $user->data->id,
				],
				$data
			]),
		];
		$token = \Firebase\JWT\JWT::encode( $tokenData, $this->secret );

		return $token;
	}
}
