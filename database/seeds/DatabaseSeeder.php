<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('users')->insert([
            'email' => str_random(10).'@gmail.com',
            'region' => 'alsace',
	        'type' => 'dvd_films',
	        'words_searched' => 'batman',
	        'prix_max' => 20,
	        'prix_min' => 0
        ]);
    }
}
