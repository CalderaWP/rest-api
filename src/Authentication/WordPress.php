<?php


namespace calderawp\caldera\restApi\Authentication;



use calderawp\caldera\restApi\Traits\CreatesWordPressEndpoints;

class WordPress
{

	use CreatesWordPressEndpoints;
	/** @var LogsInUser */
	protected $userLogin;

	/** @var AuthenticatesUser */
	protected $authenticatesUser;

	/** @var string */
	protected $siteUrl;

	/** @var callable */
	protected $registerFunction;

	/** @var string */
	protected $namespace = 'caldera-api/v1';

	public function __construct(LogsInUser $logsInUser, AuthenticatesUser $authenticatesUser, string $siteUrl )
	{
		$this->userLogin = $logsInUser;
		$this->authenticatesUser = $authenticatesUser;
		$this->siteUrl = $siteUrl;
	}


	public function addHooks(){
		add_filter( 'rest_pre_serve_request', function( $served, $result, $request) {
			return $served;
		}, 10, 3 );


		add_filter( 'determine_current_user', function($user ){
			//'HTTP_AUTHORIZATION';
			return $user;
		} );

		add_filter( 'rest_api_init', [$this, 'initTokenRoute' ] );
	}

	public function initTokenRoute()
	{

	}

	public function preServe($served, $result, $request )
	{

	}

}
