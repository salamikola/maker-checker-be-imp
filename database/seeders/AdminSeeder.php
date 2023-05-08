<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users = [
            [
                'email' => 'admin1@admin.com',
                'first_name' => 'Salami',
                'last_name' => 'Kolawole',
                'password' => bcrypt('password'),
                'email_verified_at'=>now(),
                'created_at'=>now(),
                'updated_at'=>now(),
            ],
            [
                'email' => 'admin2@admin.com',
                'first_name' => 'Femi',
                'last_name' => 'Ogundaro',
                'password' => bcrypt('password'),
                'email_verified_at'=>now(),
                'created_at'=>now(),
                'updated_at'=>now(),
            ],
        ];
        Admin::insert($users);
    }
}
