<?php

use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('states')->insert([
            [
                'name' => 'Abia',
                'user_id' => null,
            ],
            [
                'name' => 'Abuja',
                'user_id' => 2,
            ],
            [
                'name' => 'Adamawa',
                'user_id' => 3,
            ],
            [
                'name' => 'Akwa Ibom',
                'user_id' => 4,
            ],
            [
                'name' => 'Anambra',
                'user_id' => 5,
            ],
            [
                'name' => 'Bauchi',
                'user_id' => 6,
            ],
            [
                'name' => 'Bayelsa',
                'user_id' => 7,
            ],
            [
                'name' => 'Benue',
                'user_id' => 8,
            ],
            [
                'name' => 'Borno',
                'user_id' => 9,
            ],
            [
                'name' => 'Cross River',
                'user_id' => 10,
            ],
            [
                'name' => 'Delta',
                'user_id' => 11,
            ],
            [
                'name' => 'Ebonyi',
                'user_id' => 12,
            ],
            [
                'name' => 'Edo',
                'user_id' => 13,
            ],
            [
                'name' => 'Ekiti',
                'user_id' => 14,
            ],
            [
                'name' => 'Enugu',
                'user_id' => 15,
            ],
            [
                'name' => 'Gombe',
                'user_id' => 16,
            ],
            [
                'name' => 'Imo',
                'user_id' => null,
            ],
            [
                'name' => 'Jigawa',
                'user_id' => null,
            ],
            [
                'name' => 'Kaduna',
                'user_id' => null,
            ],
            [
                'name' => 'Kano',
                'user_id' => null,
            ],
            [
                'name' => 'Katsina',
                'user_id' => null,
            ],
            [
                'name' => 'Kebbi',
                'user_id' => null,
            ],
            [
                'name' => 'Kogi',
                'user_id' => null,
            ],
            [
                'name' => 'Kwara',
                'user_id' => null,
            ],
            [
                'name' => 'Lagos',
                'user_id' => null,
            ],
            [
                'name' => 'Nassarawa',
                'user_id' => null,
            ],
            [
                'name' => 'Niger',
                'user_id' => null,
            ],
            [
                'name' => 'Ogun',
                'user_id' => null,
            ],
            [
                'name' => 'Ondo',
                'user_id' => null,
            ],
            [
                'name' => 'Osun',
                'user_id' => null,
            ],
            [
                'name' => 'Oyo',
                'user_id' => null,
            ],
            [
                'name' => 'Plateau',
                'user_id' => null,
            ],
            [
                'name' => 'Rivers',
                'user_id' => null,
            ],
            [
                'name' => 'Sokoto',
                'user_id' => null,
            ],
            [
                'name' => 'Taraba',
                'user_id' => null,
            ],
            [
                'name' => 'Yobe',
                'user_id' => null,
            ],
            [
                'name' => 'Zamfara',
                'user_id' => null,
            ]
        ]);
    }
}
