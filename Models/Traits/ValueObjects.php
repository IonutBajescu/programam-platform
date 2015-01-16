<?php namespace App\Models\Traits;

trait ValueObjects {

	protected $valueObjects = ['content' => 'App\\Models\\Values\\Html', 'email' => 'App\\Models\\Values\\Email'];

	public function __get($key)
	{
		if (isset($this->valueObjects[ $key ])) {
			return new $this->valueObjects[$key]($this->attributes[ $key ]);
		}

		return parent::__get($key);
	}
} 