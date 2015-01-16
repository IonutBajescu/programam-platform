<?php namespace App\Models;

class Comment extends Model {

	public function commentable(){
		return $this->morphTo();
	}
} 