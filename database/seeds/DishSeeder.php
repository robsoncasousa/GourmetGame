<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dishes')->insert(
            [
                [
                    'id' => 1,
                    'name' => 'Lasanha',
                ],
                [
                    'id' => 2,
                    'name' => 'Bolo de chocolate',
                ]
            ]
        );
    }
}
