<?php namespace App\Models\Values;

class Value {
	protected $value;

	function __construct($original)
	{
		$this->value = $original;
	}

	/**
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * @param mixed $original
	 */
	public function setValue($original)
	{
		$this->value = $original;
	}

	public function __toString(){
		return $this->getValue();
	}
}