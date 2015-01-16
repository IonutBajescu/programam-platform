<?php namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * @Get("/")
	 */
	public function index(){
 		return view('index', ['title' => 'Tutoriale PHP, Symfony, Laravel', 'meta_description' => 'Tutoriale despre PHP, Laravel, Symfony.']);
	}

	public function notFound(Request $request)
	{
		$old_slugs = Post::select('id', 'title')->get()->map(function($post){
			$slug = str_replace(' ', '_', $post->title);
			$slug = preg_replace('/[^a-z_]/', '', strtolower($slug));
			return $post->id.'-'.trim($slug, '_').'.html';
		});

		if($k = $old_slugs->search($request->path())){
			preg_match('/^([0-9]+)/', $old_slugs[$k], $m);
			return redirect(Post::find($m[1])->url, 301);
		}

		return new Response(view('errors.404', ['title' => 'Pagina nu a fost gasita.']));
	}

	/**
	 * @Get("contact")
	 */
	public function contact()
	{
		return view('contact');
	}

	/**
	 * @Get("teste/php/1")
	 */
	public function testPhp1()
	{
		return view('test-php');
	}
}
