<?php namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class CommentsController extends Controller {

	/**
	 * @Middleware("App\Http\Middleware\Person")
	 * @Post("comments/create", as="comments.create")
	 */
	public function create(Request $request)
	{
		$comment = $request->only('content', 'commentable_id', 'commentable_type')+$request->session()->get('person');
		$comment = Comment::create($comment);
		return $comment->commentable->redirect();
	}

}