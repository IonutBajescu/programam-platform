<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Routing\Middleware;

class OldLinks implements Middleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$categories = [
			'php' => 'Tutoriale PHP',
			'mysql' => 'Tutoriale MySQL',
			'php-si-mysql' => 'Tutoriale PHP si MySQL',
			'programare-web' => 'Tutoriale programare web',
		];
		$categories = array_map(function($v){
			return '#categorie/([0-9])/'.str_replace(' ', '_', strtolower($v)).'\.php#';
		}, $categories);

		foreach($categories as $to => $cat){
			if(preg_match($cat, $request->path())){
				return redirect(route('tag.view', [$to]), 301);
			}
		}

		return $next($request);
	}

}
