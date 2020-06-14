<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Post;
use App\Comment;
use App\PageLog;
use Carbon\Carbon;


class DBStatusResetCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:dbstatusreset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset DB status';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        User::query()->update([
            'vote_time' => 4,
            'post_time' => 5,
        ]);

        Post::increment('display');
        Comment::increment('display');
        
        $now = Carbon::now();
        $title = $now->format('ymd');
        $pagelog = PageLog::create([
            'title' => $title,
        ]);
    }
}
