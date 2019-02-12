<?php

use Illuminate\Database\Seeder;

class NetworksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $networks = [
            ['id' => 1, 'name' => 'website'],
            ['id' => 2, 'name' => 'instagram'],
            ['id' => 3, 'name' => 'facebook'],
            ['id' => 4, 'name' => 'twitter'],
            ['id' => 5, 'name' => 'tumblr'],
            ['id' => 6, 'name' => 'snapchat'],
            ['id' => 7, 'name' => 'linkedin'],
            ['id' => 8, 'name' => 'flickr'],
            ['id' => 9, 'name' => 'reddit'],
            ['id' => 10, 'name' => 'letterboxd'],
            ['id' => 11, 'name' => 'skype'],
            ['id' => 12, 'name' => 'behance'],
            ['id' => 13, 'name' => 'pinterest'],
            ['id' => 14, 'name' => '500px'],
            ['id' => 16, 'name' => 'youtube'],
            ['id' => 999, 'name' => 'custom'],
            
        ];

        DB::table('networks')->insert($networks);

    }
}
