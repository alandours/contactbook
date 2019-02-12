<?php

use Illuminate\Database\Seeder;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $types = [
            ['id' => 1, 'name' => 'home/personal'],
            ['id' => 2, 'name' => 'mobile'],
            ['id' => 3, 'name' => 'secondary'],
            ['id' => 4, 'name' => 'work'],
            ['id' => 5, 'name' => 'custom'],
            
        ];

        DB::table('types')->insert($types);

    }
}
