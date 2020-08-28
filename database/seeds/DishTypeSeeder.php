<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DishTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dish_types')->insert(
            [
                [
                    'type_id' => 1,
                    'dish_id' => 1,
                ],
                [
                    'type_id' => 2,
                    'dish_id' => 2,
                ]
            ]
        );
    }
}
