<?php


namespace calderawp\caldera\restApi\Authentication;



use calderawp\caldera\restApi\Authentication\Endpoints\GenerateToken;
use calderawp\caldera\restApi\Authentication\Endpoints\VerifyToken;
use calderawp\caldera\restApi\Traits\CreatesWordPressEndpoints;
use calderawp\caldera\restApi\Contracts\AuthenticateRestApiContract;

class WpRestApi implements AuthenticateRestApiContract
{

	use CreatesWordPressEndpoints;

	/** @var string */
	protected $siteUrl;

	/** @var callable */
	protected $registerFunction;

	/** @var string */
	protected $token;

	/** @var string */
	protected $namespace = 'caldera-api/v1';

	/** @var WordPressUserJwt */
	protected $wpJwt;

	public function __construct(WordPressUserJwt $wpJwt, string $siteUrl )
	{

		$this->wpJwt = $wpJwt;
		$this->siteUrl = $siteUrl;
		$this->registerFunction = 'register_rest_route';
	}


	public function addHooks(){
		add_filter( 'rest_pre_serve_request', function( $served, $result, $request) {
			return $served;
		}, 10,3 );
		add_filter( 'determine_current_user', [$this,'determineUser' ]);
		return add_filter( 'rest_api_init', [$this, 'initTokenRoutes' ] );
	}

	/**
	 * Get token from current request
	 *
	 * @return string
	 */
	public function getToken(): string
	{
		return $this->token;
	}

	/**
	 * @return AuthenticateRestApiContract
	 */
	public function initTokenRoutes() :AuthenticateRestApiContract
	{
		$verifyToken = (new VerifyToken($this->wpJwt))->setToken($this->token);
		$generateToken = (new GenerateToken($this->wpJwt))->setToken($this->token);
		$this->registerRouteWithWordPress($verifyToken);
		$this->registerRouteWithWordPress($generateToken);
		return $this;
	}


	/**
	 * @param $user_id
	 *
	 * @return int
	 */
	public function determineUser(?int $user_id)
	{
		if( $user_id ){
			return $user_id;
		}
		$this->setTokenFromHeaders();
		if (! empty( $this->getToken())) {
			try {
				$user = $this->wpJwt->userFromToken($this->getToken());
				$user_id = $user->ID;
			} catch (AuthenticationException $e) {
			} catch (UserNotFoundException $e) {
			}
		}
		return $user_id;

	}

	public function setTokenFromHeaders(): void
	{
		$this->token = isset($_SERVER[ 'HTTP_AUTHORIZATION' ]) ? strip_tags($_SERVER[ 'HTTP_AUTHORIZATION' ]) : '';
	}

}
