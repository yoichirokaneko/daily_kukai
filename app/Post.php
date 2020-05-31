<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
	    'user_id',
		'body',
	];

	public function comments(){
		return $this->hasMany('App\Comment');
	}

	public function vote_logs(){
        return $this->hasMany('App\VoteLog');
    }

	public function user(){
		return $this->belongsTo('App\User');
	}

}
