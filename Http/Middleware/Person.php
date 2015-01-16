<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Routing\Middleware;

class Person implements Middleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{

		$session = $request->session();
		if( ! $session->has('person')){
			if($request->has('person')){
				$this->savePerson($request, $session);
			} else{
				$this->saveOldInput($request, $session);
				return view('personify');
			}
		}

		return $next($request);
	}

	/**
	 * @param $request
	 * @param $session
	 */
	public function reloadOldInput($request, $session)
	{
		$request->replace($session->get('old'));
		$session->remove('old');
	}

	/**
	 * @param $request
	 * @param $session
	 */
	public function savePerson($request, $session)
	{
		$session->set('person', $request->get('person'));
		$this->reloadOldInput($request, $session);
	}

	/**
	 * @param $request
	 * @param $session
	 */
	public function saveOldInput($request, $session)
	{
		$session->put('old', $request->all());
	}

}
