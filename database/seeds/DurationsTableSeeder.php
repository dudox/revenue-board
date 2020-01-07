<?php

use Illuminate\Database\Seeder;

class DurationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('durations')->insert([
            [
                'name' => 'One Day',
                'type' => 'day',
                'value' => 1,
            ],
            [
                'name' => 'One Week',
                'type' => 'week',
                'value' => 1,
            ],
            [
                'name' => 'One Month',
                'type' => 'month',
                'value' => 1,
            ],
            [
                'name' => 'Two Days',
                'type' => 'day',
                'value' => 2,
            ],
            [
                'name' => 'Two Weeks',
                'type' => 'week',
                'value' => 2,
            ],
            [
                'name' => 'One Year',
                'type' => 'year',
                'value' => 1,
            ],
        ]);
    }
}
