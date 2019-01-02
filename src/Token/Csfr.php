<?php


namespace calderawp\caldera\restApi\Token;

use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use \calderawp\interop\Contracts\TokenContract;

/**
 * Class Csfr
 *
 * Manages anti-CSFR tokens
 */
class Csfr implements TokenContract
{

	/**
	 * @var CsrfTokenManagerInterface
	 */
	protected $tokenManager;
	/**
	 * @var string
	 */
	protected $nonceAction;

	/**
	 * Csfr constructor.
	 *
	 * @param string $nonceAction
	 * @param CsrfTokenManagerInterface $tokenManager
	 */
	public function __construct(string $nonceAction, CsrfTokenManagerInterface $tokenManager)
	{
		$this->nonceAction = $nonceAction;
		$this->tokenManager = $tokenManager;
	}

	/**
	 * Generate a token, returning its public
	 *
	 * @return string
	 */
	public function getToken() : string
	{
		return $this
			->tokenManager
			->getToken($this->nonceAction)
			->getValue();
	}

	/**
	 * Test if string is a valid public for a token of current manager
	 *
	 * @param string $tokenStringToValidate
	 *
	 * @return bool
	 */
	public function validateToken(string $tokenStringToValidate):bool
	{
		$token = $this
			->tokenManager
			->getToken($tokenStringToValidate);

		$tokenBeingValidated = $this
			->tokenManager
			->getToken($token);

		return   hash_equals(
			$token->getId(),
			$tokenStringToValidate
		);
	}
}
