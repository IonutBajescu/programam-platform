<?php namespace App\Models;

use Carbon\Carbon;
use Illuminate\Routing\Route;

class Model extends \Illuminate\Database\Eloquent\Model {
	use Traits\Url, Traits\ValueObjects;

	protected $guarded = [];

	public function attachments(){
		return $this->morphMany('Attachment', 'attachable');
	}

	public function newCollection(array $models = array()){
		return new Collection($models);
	}

	public function getPrettyDateAttribute(){
		if(Carbon::now()->diffInDays() > 2){
			return $this->created_at->format('d.m.Y H:i');
		}

		return $this->created_at->diffForHumans();
	}

	public function seo(){
		return ['title' => $this->title, 'meta_keywords' => $this->meta_keywords, 'meta_description' => $this->meta_description];
	}

	public function addRelation($relation, $query){
		$refObject   = new ReflectionObject($relation);
		$refProperty = $refObject->getProperty('query');
		$refProperty->setAccessible(true);
		$refProperty->setValue($relation, $query);
		$relation->addConstraints();
		return $refProperty->getValue($query);
	}
}