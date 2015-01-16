<?php namespace App\Models;

class Rating extends Model {

	public function rateable()
	{
		return $this->morphTo();
	}
} 