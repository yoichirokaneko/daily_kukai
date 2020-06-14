<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PageLog;
use App\Post;
use App\Comment;

class AdminPastController extends Controller
{
    public function index(){
        $pagelogs = PageLog::latest()->get();
        return view('admin.pagelog.index', ['pagelogs' => $pagelogs]);
    }

    public function show($id, $pagetitle){
        $posts = Post::where('display', $id)->orderBy('point', 'desc')->with('user')->get();  
        $comments = Comment::where('display', $id)->latest()->get();    
        return view('admin.pagelog.show',[
                'posts' => $posts,
                'comments' => $comments,
                'pagetitle' => $pagetitle,
            ]);
    }
}
