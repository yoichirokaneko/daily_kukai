<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $faker = Faker::create('ja_JP');
    	DB::table('users')->insert([
	    	'family_name' => 'admin',
	    	'haiku_name' => 'haigou',
		    'email' => 'admin@admin.com',
			'password' => bcrypt('admin'),
			'prefecture' => $faker->city,
			'is_admin' => 1,
			'remember_token' => Str::random(10),
			'created_at' => now(),
			'updated_at' => now(),
		]);

        factory(User::class, 3)->create();
    }
}
