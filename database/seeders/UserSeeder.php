<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('admin'),
                'role' => 'admin'
            ],
            [
                'name' => 'costumer1',
                'email' => 'costumer1@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('costumer1'),
                'role' => 'costumer'
            ],
            [
                'name' => 'costumer2',
                'email' => 'costumer2@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('costumer2'),
                'role' => 'costumer'
            ]
        ]);
    }
}
