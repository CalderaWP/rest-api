<?php


namespace calderawp\caldera\restApi\Routes;

use calderawp\caldera\Forms\FormModel;
use calderawp\caldera\restApi\CalderaRestApi;
use calderawp\caldera\restApi\Endpoints\Form\DeleteForm;
use calderawp\caldera\restApi\Endpoints\Form\GetForms;
use calderawp\caldera\restApi\Endpoints\Form\GetForm;
use calderawp\caldera\restApi\Endpoints\Form\PostForm;
use calderawp\caldera\restApi\Endpoints\Form\PutForm;
use calderawp\caldera\restApi\Route;

class Form extends Route
{


	public function __construct(CalderaRestApi $module)
	{
		parent::__construct($module);
		$this->addEndpoint(new GetForms($module));
		$this->addEndpoint(new GetForm($module));
		$this->addEndpoint(new PutForm($module));
		$this->addEndpoint(new PostForm($module));
		$this->addEndpoint(new DeleteForm($module));
	}
}
