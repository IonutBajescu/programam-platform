<?php namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

/**
 * @Controller(prefix="posts")
 */
class PostsController extends Controller {

	/**
	 * @Get("random")
	 */
	public function random()
	{
		$post = Post::orderByRaw("RAND()")->first();
		return redirect($post->url);
	}

	/**
	 * @Get("view/{post_slug}", as="post.view")
	 */
	public function post($post)
	{
		return view('post', compact('post')+$post->seo());
	}

	/**
	 * @Get("tag/{tag_slug}", as="tag.view")
	 */
	public function byTag($tag = null)
	{
		if(!$tag){
			return view('posts', ['posts' => [], 'title' => 'Fara rezultate.']);
		}

		$posts = $this->posts()->withAnyTag($tag->name)->get();
		$title = "Tutoriale $tag->name";
		return view('posts', compact('posts', 'title'));
	}

	/**
	 * @Get("archive")
	 */
	public function archive()
	{
		return view('posts.archive', ['posts' => Post::all(), 'title' => 'Arhiva articole']);
	}

	/**
	 * @Get("tags", as="tag.all")
	 */
	public function tags()
	{
		$tags = Tag::all();
		return view('posts.tags', compact('tags')+['title' => 'Categorii articole']);
	}

	/**
	 * @Get("search", as="post.search")
	 */
	public function search()
	{
		$posts = $this->posts()->get();
		return view('posts.search', compact('posts'));
	}

	protected function posts(){
		$query = Post::latest();
		if($s = Input::get('s')){
			$s = e($s);
			$query->whereRaw("CONCAT(title, content) LIKE '%$s%'");
		}
		return $query;
	}
} 