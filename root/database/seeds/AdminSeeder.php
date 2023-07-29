<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() :void
    {
        //
        DB::table('admins')->insert([
            'employee_id' => 'Admin_1',
            'email' => 'miichi@gmail.com',
            'password' => Hash::make('12345678'),
            'name' => 'miichi',
            'department_id' => '1',
        ]);
    }
}
