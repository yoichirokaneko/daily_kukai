<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Post;
use App\Comment;

class AdminCommentController extends Controller
{
    public function index($post_id){
    	$post = Post::with('user')->findOrFail($post_id);
    	$comments = Comment::where('post_id',$post_id)->latest()->get();
		return view('admin.comment',[
			'post' => $post,
			'comments' => $comments,
		]);
    }

    public function store(CommentRequest $request, $post_id){
    	$comment = Comment::create([
    		'post_id' => $post_id,
    		'body' => $request->body,
    	]);
    	return redirect()->route('admin.comment',['post_id' => $post_id]);
    }

    public function edit($post_id, $comment_id){
    	$post = Post::findOrFail($post_id);
    	$comment = Comment::findOrFail($comment_id);
    	return view('admin.comment.edit', [
			'post' => $post,
    		'comment' => $comment,
    	]);
    }

    public function update(CommentRequest $request, $post_id, $comment_id){
    	$comment = Comment::findOrFail($comment_id);
    	$comment->update([
                'body' => $request->body,
        ]);
        return redirect()->route('admin.comment', ['post_id' => $post_id]);
    }
}
