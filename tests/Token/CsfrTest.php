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
		$this->assertIsString((new Csfr('id',new CsrfTokenManager()))->getToken());
	}

	/**
	 * @covers Csfr::validateToken()
	 */
	public function testValidateToken()
	{
		$manager = new CsrfTokenManager();
		$action = 'form-submit';
		$token = new Csfr($action,$manager);
		$tokenString = $token->getToken();
		$this->assertTrue($token->validateToken($tokenString));
	}
}
