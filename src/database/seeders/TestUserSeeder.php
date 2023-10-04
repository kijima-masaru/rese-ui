<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TestUserSeeder extends Seeder
{
    public function run()
    {
        // 1つ目のテストアカウント
        DB::table('users')->insert([
            'name' => '管理者',
            'email' => 'admin@example.com',
            'password' => Hash::make('11111111'),
            'role' => 'admin',
            'email_verified_at' => now(), // 認証済み
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2つ目のテストアカウント
        DB::table('users')->insert([
            'name' => '店舗代表者',
            'email' => 'owner@example.com',
            'password' => Hash::make('22222222'),
            'role' => 'owner',
            'email_verified_at' => now(), // 認証済み
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3つ目のテストアカウント
        DB::table('users')->insert([
            'name' => '一般ユーザー',
            'email' => 'user@example.com',
            'password' => Hash::make('33333333'),
            'role' => 'user',
            'email_verified_at' => now(), // 認証済み
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

