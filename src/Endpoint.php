<?php


namespace calderawp\caldera\restApi;

use calderawp\interop\Contracts\Rest\Endpoint as EndpointContract;
use calderawp\interop\Traits\Rest\ProvidesRestEndpoint;
use calderawp\interop\Contracts\WordPress\ApplysFilters;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Contracts\Rest\RestResponseContract as Response;

abstract class Endpoint implements EndpointContract
{
	use ProvidesRestEndpoint;

	/** @var CalderaRestApi  */
	protected $module;


	public function __construct(CalderaRestApi $module)
	{
		$this->module = $module;
	}

	public function getFilters(): ApplysFilters
	{
		return $this->module->getCalderaEvents()->getHooks();
	}
	/** @inheritdoc */
	public function handleRequest(Request $request) : Response
	{


		$form = $this
			->getFilters()
			->applyFilters($this->getPreHookName(), $form, $request);

		$response =  $this
			->getFilters()
			->applyFilters($this->getResponseHookName(), $form->toResponse(), $form, $request);
		return $response;
	}

	abstract function hookSpecifier():string;

	/** @inheritdoc */
	public function getResponseHookName(): string
	{
		return "restApi/{$this->hookPrefix()}/{$this->hookSpecifier()}/response";
	}

	/** @inheritdoc */
	public function getPreHookName(): string
	{
		return "restApi/{$this->hookPrefix()}/{$this->hookSpecifier()}/form";
	}

	abstract protected function hookPrefix(): string;
}
