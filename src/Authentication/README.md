# JWT Authentication For The WordPress REST API

NOTE: All example code assumes Guzzle is availble.

```php
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
```
### Obtain A Token
You can exchange username and password for a JWT token by making a request to `<wp-json-url>/caldera-api/v1/jwt`

```php
$response = $client->request('POST', '/wp-json/caldera-api/v1/jwt', [
    'verify' => false,
    'json' => [
        'user' => 'admin',
        'pass' => 'password',
    ],
]);
if( 201 == response->getStatusCode()){
    $body = json_decode($response->getBody(), true);
    $jwtToken = $body['token'];
}


```

### Verify Token
```php
$response = $client->request('GET', '/wp-json/caldera-api/v1/jwt', [
        'verify' => false,
        'json' => [
            'token' => $token,
        ],
]);
```

### Make An Authenticated Request To The WordPress REST API
```php
$headers = [
    'Authorization' => 'Bearer: ' . $token,
    'Accept' => 'application/json',
    'X-WP-NONCE' => 'This Should Not Be Needed But It Is Right Now',
];

$response = $client->request( 'GET', "wp/v2/users/me", [
    'headers' => $headers,
    'verify' => false,
]);
```
