<?php

use Illuminate\Database\Seeder;

class ScreensTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('screens')->insert([
            [
                'message' => 'Activate revenue code',
                'type' => 1,
                'created_at' => Carbon\Carbon::now(),
            ],
            [
                'message' => 'Validate revenue code',
                'type' => 2,
                'created_at' => Carbon\Carbon::now(),
            ],
        ]);
    }
}
