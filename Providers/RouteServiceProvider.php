<?php namespace App\Providers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Routing\Annotations\DirClassesFinder;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider {

	/**
	 * This namespace is applied to the controller routes in your routes file.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'App\Http\Controllers';

	protected $scanWhenLocal = true;

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function boot(Router $router)
	{
		parent::boot($router);

		$router->bind('post_slug', function($slug){
			return Post::whereSlug($slug)->first();
		});

		$router->bind('tag_slug', function($slug){
			return Tag::whereSlug($slug)->first();
		});
	}

	public function __construct(){
		$this->scan = (new DirClassesFinder())->getClasses();
		parent::__construct(app());
	}

	/**
	 * Define the routes for the application.
	 *
	 * @return void
	 */
	public function map()
	{
		$this->loadRoutesFrom(app_path('Http/routes.php'));
	}

}



namespace Illuminate\Routing\Annotations;

use Illuminate\Console\AppNamespaceDetectorTrait;
use Symfony\Component\Finder\Finder;

class DirClassesFinder {
	use AppNamespaceDetectorTrait;

	protected $root;
	protected $namespace;

	function __construct($dir = null)
	{
		$dir = $dir ?: 'Http/Controllers';

		$this->root = app_path($dir);
		$this->namespace = $this->getAppNamespace().$this->invertSlashes($dir);
	}


	public function getClasses(){
		$files = Finder::create()->files()->in($this->root);

		return array_map([$this, 'formatClassFromEachPath'], iterator_to_array($files));
	}

	protected function formatClassFromEachPath($file)
	{
		$path = $file->getPathname();
		$path = str_replace([$this->root, '.php'], '', $path);
		$path = $this->invertSlashes($path);

		return $this->namespace . $path;
	}

	protected function invertSlashes($path)
	{
		return str_replace('/', '\\', $path);
	}
}
