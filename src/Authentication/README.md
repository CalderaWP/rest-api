# JWT Authentication For The WordPress REST API

NOTE: All example code assumes Guzzle is availble.

```php
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
```
### Obtain A Token
You can exchange username and password for a JWT token by making a request to `<wp-json-url>/caldera-api/v1/jwt`

```php
$response = $client->request('POST', $url, [
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
