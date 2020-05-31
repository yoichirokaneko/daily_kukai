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
		//必要な情報をテーブルから全て取得する
    	$posts = Post::where('display', 1)->latest()->with('user')->get();
    	$comments = Comment::where('display', 1)->latest()->with('post')->get();
		$user = Auth::user();
		//ログイン時とゲストで場合わけ
		if($user == null){
		return view('index', [
			'pageVer' => $pageVer,
			'posts' => $posts,
			'comments' => $comments,
			'uvls' => null,
		]);
		}else{
    	$uvls = VoteLog::where('user_id', $user->id)->get();
		return view('index', [
			'pageVer' => $pageVer,
			'posts' => $posts,
			'comments' => $comments,
			'uvls' => $uvls,
		]);
		}
    }

	//新規投稿時の処理
    public function store(PostRequest $request){
    	$user = Auth::user();
    	$post_user = User::where('id', $user->id);
    	$post_time = $post_user->value('post_time');
    	if($post_time <= 4){
    		$post_user->increment('post_time');
	    	$post = Post::create([
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
		if($vote_time <= 3 && $request->data[0] == 0){
			//ユーザーの投票回数を加算
			$vote_user->increment('vote_time');
			//投票ログの登録
			$vote_log = VoteLog::create([
				'user_id' => $user->id,
				'post_id' => $request->data[1],
			]);
			//投票された俳句にポイントを加算
			$voted_post = Post::where('id', $request->post_id);
			$voted_post->increment('point');
			return redirect('/');
		}else{
			return redirect('/');
		}
	}



}