<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Carbon\Carbon;
use App\Post;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\VoteLog;

class PostController extends Controller
{
    public function index(){
    	//アクセスした日時により、投票ページ(=1)と結果発表ページ(=2)のどちらを表示するか判定する処理
    	$dt = new Carbon('now');
    	$dtW = $dt->dayOfWeekIso;
    	if($dtW == 5){
    		$dtF = new Carbon('now');
    		$dtFt = $dtF->setTIme(18, 00, 00);
    		if($dt >= $dtFt){
    			$pageVer = 2;
    		}else{
    			$pageVer = 1;
    		}
    	}elseif($dtW == 6){
    		$pageVer = 2;
    	}elseif($dtW == 7){
    		$dtS = new Carbon('now');
    		$dtSt = $dtS->setTime(12, 00, 00);
    		if($dt >= $dtSt){
    			$pageVer = 1;
    		}else{
    			$pageVer= 2;
    		}
    	}else{
    		$pageVer = 1;
    	}

    	if($pageVer == 1){
			//必要な情報をテーブルから全て取得する
	    	$posts = Post::where('display', 0)->latest("updated_at")->with('user')->get();
	    	$comments = Comment::where('display', 0)->latest()->with('post')->get();
			$user = Auth::user();
			//ログイン時とゲストで場合わけ
			if($user == null){
			return view('index', [
				'posts' => $posts,
				'comments' => $comments,
				'user' => $user,
				'uvls' => null,
			]);
			}else{
	    	$uvls = VoteLog::where('display', 0)->where('user_id', $user->id)->get();
			return view('index', [
				'posts' => $posts,
				'comments' => $comments,
				'user' => $user,
				'uvls' => $uvls,
			]);
			}
    	}elseif($pageVer == 2){
    		$posts = Post::where('display', 0)->orderBy('point', 'desc')->with('user')->get();
    		$comments = Comment::where('display', 0)->latest()->get();
    		$vote_logs = VoteLog::where('display', 0)->with(['user', 'post'])->get();
    		return view('index2',[
				'posts' => $posts,
				'comments' => $comments,
				'vote_logs' => $vote_logs,
    		]);
    	}
    }

	//新規投稿時の処理
    public function store(PostRequest $request){
    	$user = Auth::user();
    	$post_user = User::where('id', $user->id);
    	$post_time = $post_user->value('post_time');
    	$posted = Post::where('display', 0)->latest()->first();
        if($posted != null){
            $posted_number = $posted->post_no;
            $post_no = $posted_number + 1;
        }else{
            $post_no = 1;
        }
    	if($post_time >= 1){
    		$post_user->decrement('post_time');
	    	$post = Post::create([
	    		'post_no' => $post_no,
	    		'user_id' => $user->id,
	    		'body' => $request->body,
	    	]);
	    	return redirect('/');
    	}else{
    		return redirect('/');
    	}
    }
	//投票時の処理
	public function point(Request $request){
		$user = Auth::user();
		$vote_user = User::where('id', $user->id);
		$vote_time = $vote_user->value('vote_time');
		if($vote_time >= 1 && $request->data[0] == 0){
			//ユーザーの投票回数を加算
			$vote_user->decrement('vote_time');
			//投票ログの登録
			$vote_log = VoteLog::create([
				'user_id' => $user->id,
				'post_id' => $request->data[1],
			]);
			//投票された俳句にポイントを加算
			$voted_post = Post::where('id', $request->data[1]);
			$voted_post->increment('point');
			return redirect('/');
		}else{
			return redirect('/');
		}
	}

	public function edit($post_id){
		$post = Post::findOrFail($post_id);
		$comments = Comment::where('display', 0)->latest()->get();
    	return view('post.edit', [
    		'post' => $post,
    		'comments' => $comments,
    	]);
	}

	public function update(Request $request, $post_id){
    	$post = Post::findOrFail($post_id);
    	if($post->correct_time >= 1){
	    	$post->decrement('correct_time');
	    	$post->update([
	    		'body' => $request->body,
	    	]);
    	}
		return redirect('/');
	}
}