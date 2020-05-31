<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
	    'admin_id',
		'post_id',
		'body',
	];


	public function post(){
		return $this->belongsTo('App\Post');
	}
}
