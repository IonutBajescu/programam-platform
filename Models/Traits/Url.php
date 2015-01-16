<?php namespace App\Models\Traits;

trait Url {

	public function getUrlAttribute(){
		return $this->url();
	}

	public function url($action = 'view'){
		$class    = explode('\\', get_class($this));
		$class    = last($class);
		$resource = strtolower(str_singular($class));
		$route    = $resource.'.'.$action;

		$routeUri = app('router')->getRoutes()->getByName($route)->getUri();
		if(preg_match('/slug}/', $routeUri)){
			return route($route, [$this->slug]);
		}

		return route($route, [$this->id]);
	}

	public function redirect($action = 'view'){
		return redirect($this->url($action));
	}
} 