<?php namespace App\Models;


class Post extends Model {
	use \Conner\Tagging\TaggableTrait;

	public function comments(){
		return $this->morphMany('App\Models\Comment', 'commentable');
	}

	public function ratings(){
		return $this->morphMany('App\Models\Rating', 'rateable');
	}

	public function tagsHtml()
	{
		return $this->tagged->map(function($tag){
			$url = route('tag.view', \Str::slug($tag->tag_name));
			return ['html' => "<a href='{$url}'>{$tag->tag_name}</a>"];
		})->implode('html', ', ');
	}
}