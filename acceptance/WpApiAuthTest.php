<?php


namespace calderawp\caldera\restApi\Acceptance;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class WpApiAuthTest extends TestCase
{


	protected $wpApiUrl = 'https://caldera.lndo.site/wp-json/caldera-api/v1';

	public function testCanReachWordPressViaHttp()
	{

		$client = new Client();
		$response = $client->request('GET', $this->wpApiUrl, ['verify' => false]);
		$this->assertSame(200, $response->getStatusCode());
	}


	public function testCanExchangeUserCredsForJwt()
	{
		$client = new Client();
		$url = "$this->wpApiUrl/jwt";
		$response = $client->request('POST', $url, [
			'verify' => false,
			'json' => [
				'user' => 'admin',
				'pass' => 'password',
			],
		]);

		$this->assertSame(201, $response->getStatusCode());
		$body = json_decode($response->getBody(), true);
		$this->assertIsString($body[ 'token' ]);
		$this->assertTrue($body[ 'verified' ]);
		$this->assertSame('verified', $body[ 'message' ]);

	}

	public function testCanNotExchangeInvalidUserCredsForJwt()
	{
		$this->expectException(GuzzleException::class);

		$client = new Client();
		$url = "$this->wpApiUrl/jwt";
		$client->request('POST', $url, [
			'verify' => false,
			'json' => [
				'user' => 'admin',
				'pass' => '12345',
			],
		]);

	}

	public function testCanVerifyToken()
	{
		$client = new Client();
		$url = "$this->wpApiUrl/jwt";
		$response = $client->request('POST', $url, [
			'verify' => false,
			'json' => [
				'user' => 'admin',
				'pass' => 'password',
			],
		]);
		$body = json_decode($response->getBody(), true);
		$token = $body[ 'token' ];
		$response = $client->request('GET', $url, [
			'verify' => false,
			'json' => [
				'token' => $token,
			],
		]);
		$this->assertSame(200, $response->getStatusCode());
		$body = json_decode($response->getBody(), true);
		$this->assertIsString($body[ 'token' ]);
		$this->assertTrue($body[ 'verified' ]);
		$this->assertSame('valid', $body[ 'message' ]);

	}

	public function testCanNotVerifyInvalidToken()
	{
		$this->expectException(GuzzleException::class);
		$client = new Client();
		$url = "$this->wpApiUrl/jwt";
		$token = '111.111.111';
		$response = $client->request('GET', $url, [
			'verify' => false,
			'json' => [
				'token' => $token,
			],
		]);
		$this->assertSame(200, $response->getStatusCode());
		$body = json_decode($response->getBody(), true);
		$this->assertIsString($body[ 'token' ]);
		$this->assertTrue($body[ 'verified' ]);
		$this->assertSame('valid', $body[ 'message' ]);

	}
}
