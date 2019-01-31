<?php


namespace calderawp\caldera\restApi\Contracts;

interface AuthenticateRestApiContract
{

	public function initTokenRoutes(): AuthenticateRestApiContract;

	/**
	 * Determine user via token
	 *
	 * @param int|null $user_id
	 *
	 * @return int
	 */

	public function determineUser(?int $user_id);

	/**
	 * Get token from current request
	 *
	 * @return string
	 */
	public function getToken(): string;

	/**
	 * Set token
	 *
	 * Probably from $_SERVER[ 'HTTP_AUTHORIZATION' ]
	 */
	public function setTokenFromHeaders(): void;
}
