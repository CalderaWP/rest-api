<?php


namespace calderawp\caldera\restApi\Endpoints\Form;

trait HasFullFormArgs
{
	/**
	 * @return array
	 */
	public function getFullFormArgs():array
	{
		return [
			'formId' => [
				'type' => 'string'
			],
			'name' => [
				'type' => 'string'
			],
			'fields' => [
				'type' => 'array'
			],
			'settings' => [
				'type' => 'array'
			],
			'conditionals' => [
				'type' => 'array'
			]
		];
	}
}
