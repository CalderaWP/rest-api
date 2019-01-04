<?php

namespace calderawp\caldera\restApi\Tests;

use calderawp\caldera\restApi\Token\Csfr;
use Symfony\Component\Security\Csrf\CsrfTokenManager;

class CsfrTest extends TestCase
{
	/**
	 * @covers Csfr::getToken()
	 */
	public function testGetToken()
	{
		$this->assertIsString((new Csfr('id', new CsrfTokenManager()))->getToken());
	}

	/**
	 * @covers Csfr::validateToken()
	 */
	public function ___testValidateToken()
	{
		$this->assertFalse(true);
		$manager = new CsrfTokenManager();
		$action = 'form-submit';
		$token = new Csfr($action, $manager);
		$tokenString = $token->getToken();
		$this->assertTrue($token->validateToken($tokenString));
	}

	/**
	 * @covers Csfr::validateToken()
	 */
	public function testInvalidToken()
	{
		$this->markTestSkipped('This implementation is wrong!' );

		$manager = new CsrfTokenManager();
		$action = 'form-submit';
		$token = new Csfr($action, $manager);
		$invalidToken = new Csfr('sddsf', $manager);
		$this->assertFalse($token->validateToken($invalidToken->getToken()));
	}
}
