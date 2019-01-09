# Caldera REST API

This is the forms package of the [Caldera Framework](https://github.com/CalderaWP/caldera) and provides REST API functionality to the framework.
 
## This Is Not Caldera Forms.
* Documentation for the [Caldera Forms REST API](https://calderaforms.com/doc/caldera-forms-rest-api/) for Caldera Forms 1.x.
* [Caldera Forms on Github](http://github.com/calderawp/caldera-forms/)
* [CalderaForms.com](http://calderaforms.com)

## Overview
This package is primarily responsible for:
* Objects that describe:
    * REST API requests
    * REST API responses
    * REST API endpoints
    * REST API routes
    * REST API controllers
* Converting Exceptions to REST API responses
* The forms REST API (this may get moved to forms package)
    - CRUD via REST for forms 
        - only read (GET) is implemented.
    - CRUD via REST for form entries
        * Read (GET) and write (POST) are implemented.

It is important to note that this package does not provide for form processing, or entry saving. This package should be a router only. It dispatches a serious of events - via the `CalderaHttp` module. Those events are used to

* The forms package subscribes to those events to provide entries or forms as needed. 
* The forms package subscribes to those events to provide form processors
* The WordPress plugin subscribes to those events to provide database CRUD

The Request and Response objects extend objects from the Http package. You should probably read that package's README before completing this README.

## Usage

### Install
* Add to your package:
    - `composer require calderawp/caldera-rest-api`
* Install for development:
    - `git clone git@github.com:CalderaWP/caldera-rest-api.git && composer install`

### Overview
Main module class methods:

* `getCalderaEvents(): CalderaEvents` - Short cut to get the event module instance from container.
* `addRoute(RouteContract $route): CalderaRestApiContract` Registers routes
* `getRoute(string $className): RouteContract` - Get registered routes.

To add a route, you create one or more endpoints, add them to a route and then register the route with the module class's `addRoute()` method. This is explained in more detail below.

### Using

* Access from main container:
```php
$http = \caldera()->getRestApi(); 
```


### Defining An Endpoint
Endpoints MUST implement the `calderawp\interop\Contracts\Rest\Endpoint` interface. This module has a `Endpoint` abstract class that provides most of the required methods. It is recommended to extend that class when creating an endpoint.

An endpoint represents a single entry point for the REST API. The endpoint class defines the endpoints rules and routes the request to wherever the business logic of the request lives -- probably the route.

When extending `Endpoint`, you have to add three methods to concrete class:

* `getArgs() : array` - The request arguments - same schema as a WordPress REST API endpoint -- or it should be :)
    - See: https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/#arguments
* `handleRequest(Request $request): Response` - Process request.
    - Given a Request object, produce a Response object or throw an exception to indicate an error/ invalid request.
    - Do not do business logic here, dispatch to a reusable function.
    - In your endpoint unit tests, mock the functions that it calls, and ensure they get called.
* `getUri(): string` The URI for the endpoint
    - Example: `/forms`
* `authorizeRequest(Request $request): bool` Return true or false to indicate authorization.
    - NOTE: Try not to roll a custom authentication here, use one of the authentication traits.
    - NOTE: The authentication traits don't exist yet, return true for now.
* `public function getHttpMethod(): string` - The HTTP method `GET`, `POST`, etc.



### Defining A Route

Endpoints MUST implement the `calderawp\caldera\restApi\Contracts` interface. This module has a `Route` abstract class that provides most of the required methods. It is recommended to extend that class when creating aroute.

An route represents a group of endpoints with the same base URL  -- `/forms` and `/forms/<form-id>`  -- are endpoints of the same route.

When extending `Route`, you have to add three methods to concrete class:
 * Nothing?
 
Routes MUST have an `addEndpoint(Endpoint $endpoint): Route` method. You can use this to add one or more endpoints to your route:

```php
$route->addEndpoint( $endpoint );
```
 
 
#### Make Your Route Do Something
The `handleRequest()` method of the endpoint, should send the request, when valid to your route. In your route, you can have business logic if its testable there. In the form API, I used another layer of abstraction -- a controller to make testing and reuse easier. That may or may not be too complex. When making your own endpoints, question if that extra layer of abstraction solves any actual problems.

### Connecting To The WordPress REST API
The WordPress plugin in mu-plugins has a trait that can be used to register these endpoint/ routes with WordPress. The README for that plugin explains more.

### Using With A Standards-Friendly PHP Framework
The `calderawp/http` package already has conversion from Caldera HTTP request/responses and PSR-7 request/responses. So it should not be hard to use this REST API with a PHP framework such as Slim. I fully intend to make a trait like the one I did in WordPress to handle that logic.

### Making A Remote HTTP Request From An Endpoint Callback
It is not uncommon for a REST API route to act as a proxy for a 3rd-party API. For example, a request to a Caldera endpoint might cause the system to find Stripe credentials, use them to query the Stripe API and then return formatted results to the client. In this case an HTTP request must be made on the server. This request MUST be made using the `calderawp/http` package. See that package's README for more info.

### Sending Responses
Your route MUST send a 

## Testing
* Run all tests (JK, just unit tests beacuse that's the pattern)
    - `composer test`
* Run unit tests
    - `composer test:unit`
* Run acceptance tests
    - `composer test:acceptance`
    
## License, Copyright, etc.
Copyright 2018+ CalderaWP LLC and licensed under the terms of the GNU GPL license. Please share with your neighbor.
