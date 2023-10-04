<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // テストアカウント作成のシーディング用
        $this->call(TestUserSeeder::class);
        // ダミーアカウント作成のシーディング用
        $this->call(UsersTableSeeder::class);
    }
}
