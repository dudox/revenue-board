<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            [
                'name' => 'Emmanuel Ogolekwu',
                'admin' => 1,
                'email' => 'emmanuel@mayapro1.com',
                'email_verified_at' => Carbon\Carbon::now(),
                'password' => \Hash::make('my33pesd#'),
                'created_at' => Carbon\Carbon::now(),
                'active' => 1,
            ],
            [
                'name' => 'Abuja Revenue Services',
                'admin' => 0,
                'email' => 'david@mayapro1.com',
                'email_verified_at' => Carbon\Carbon::now(),
                'password' => \Hash::make('password'),
                'created_at' => Carbon\Carbon::now(),
                'active' => 1,
            ],
            [
                'name' => 'Sunday Walter',
                'admin' => 0,
                'email' => 'sunday@mayapro1.com',
                'email_verified_at' => Carbon\Carbon::now(),
                'password' => \Hash::make('password'),
                'created_at' => Carbon\Carbon::now(),
                'active' => 1,
            ],
            [
                'name' => 'John Sani',
                'admin' => 0,
                'email' => 'john@mayapro1.com',
                'email_verified_at' => Carbon\Carbon::now(),
                'password' => \Hash::make('password'),
                'created_at' => Carbon\Carbon::now(),
                'active' => 1,
            ],
            [
                'name' => 'Emeka Eze',
                'admin' => 0,
                'email' => 'emeka@mayapro1.com',
                'email_verified_at' => Carbon\Carbon::now(),
                'password' => \Hash::make('password'),
                'created_at' => Carbon\Carbon::now(),
                'active' => 1,
            ],
            [
                'name' => 'Tunde Fasasi',
                'admin' => 0,
                'email' => 'fasasi@mayapro1.com',
                'email_verified_at' => Carbon\Carbon::now(),
                'password' => \Hash::make('password'),
                'created_at' => Carbon\Carbon::now(),
                'active' => 1,
            ],
            [
                'name' => 'John Adamu',
                'admin' => 0,
                'email' => 'adams@mayapro1.com',
                'email_verified_at' => Carbon\Carbon::now(),
                'password' => \Hash::make('password'),
                'created_at' => Carbon\Carbon::now(),
                'active' => 1,
            ],
            [
                'name' => 'Julius Ajayi',
                'admin' => 0,
                'email' => 'ajayi.j@mayapro1.com',
                'email_verified_at' => Carbon\Carbon::now(),
                'password' => \Hash::make('password'),
                'created_at' => Carbon\Carbon::now(),
                'active' => 1,
            ],
            [
                'name' => 'Micheal Odion',
                'admin' => 0,
                'email' => 'mike@mayapro1.com',
                'email_verified_at' => Carbon\Carbon::now(),
                'password' => \Hash::make('password'),
                'created_at' => Carbon\Carbon::now(),
                'active' => 1,
            ],
            [
                'name' => 'Mayowa Ojo',
                'admin' => 0,
                'email' => 'mayowa@mayapro1.com',
                'email_verified_at' => Carbon\Carbon::now(),
                'password' => \Hash::make('password'),
                'created_at' => Carbon\Carbon::now(),
                'active' => 1,
            ],
            [
                'name' => 'Mike Edunaye',
                'admin' => 0,
                'email' => 'edunaye@mayapro1.com',
                'email_verified_at' => Carbon\Carbon::now(),
                'password' => \Hash::make('password'),
                'created_at' => Carbon\Carbon::now(),
                'active' => 1,
            ],
            [
                'name' => 'Jim Morrison',
                'admin' => 0,
                'email' => 'jim@mayapro1.com',
                'email_verified_at' => Carbon\Carbon::now(),
                'password' => \Hash::make('password'),
                'created_at' => Carbon\Carbon::now(),
                'active' => 1,
            ],
            [
                'name' => 'Vicky Moore',
                'admin' => 0,
                'email' => 'vikky@mayapro1.com',
                'email_verified_at' => Carbon\Carbon::now(),
                'password' => \Hash::make('password'),
                'created_at' => Carbon\Carbon::now(),
                'active' => 1,
            ],
            [
                'name' => 'Edwin Paul',
                'admin' => 0,
                'email' => 'paul@mayapro1.com',
                'email_verified_at' => Carbon\Carbon::now(),
                'password' => \Hash::make('password'),
                'created_at' => Carbon\Carbon::now(),
                'active' => 1,
            ],            [
                'name' => 'Musa Adams',
                'admin' => 0,
                'email' => 'musa@mayapro1.com',
                'email_verified_at' => Carbon\Carbon::now(),
                'password' => \Hash::make('password'),
                'created_at' => Carbon\Carbon::now(),
                'active' => 1,
            ],

            [
                'name' => 'Rita Anaseh',
                'admin' => 0,
                'email' => 'rita@mayapro1.com',
                'email_verified_at' => Carbon\Carbon::now(),
                'password' => \Hash::make('password'),
                'created_at' => Carbon\Carbon::now(),
                'active' => 1,
            ],
            [
                'name' => 'Joseph Mark',
                'admin' => 0,
                'email' => 'joseph@mayapro1.com',
                'email_verified_at' => Carbon\Carbon::now(),
                'password' => \Hash::make('password'),
                'created_at' => Carbon\Carbon::now(),
                'active' => 1,
            ],
        ]);
    }
}
