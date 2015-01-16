<?php namespace App\Models\Values;

class Email extends Value {

	public function gravatar($size = 40){
		$hash = md5(strtolower(trim($this->getValue())));
		return "http://www.gravatar.com/avatar/".$hash."?d=mm&s=".$size;
	}
} 