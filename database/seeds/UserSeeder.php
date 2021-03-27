<?php

use App\User;
use App\Roles;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create admin user
        User::create([
            "name" => "Admin",
            "email" => "admin@crowdfunding.com",
            "email_verified_at" => Carbon::now(),
            "password" => bcrypt('admin1'),
            "role_id" => Roles::where('role', 'admin')->first()->role_id
        ]);

        // create user
        factory(User::class, 5)->create();
    }
}
