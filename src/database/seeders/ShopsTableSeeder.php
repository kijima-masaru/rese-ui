<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ShopsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('ja_JP'); // 日本語データ生成に切り替え

        // エリアとジャンルの選択肢
        $areas = ['東京都', '大阪府', '福岡県'];
        $genres = ['寿司', '焼肉', 'イタリアン', '居酒屋', 'ラーメン'];

        // ダミー店舗を30件生成
        for ($i = 1; $i <= 30; $i++) {
            $shopId = DB::table('shops')->insertGetId([
                'name' => $faker->company, // 飲食店の名前を生成
                'overview' => $faker->realText(100), // 飲食店の概要を生成
                'img' => 'shop' . $i . '.jpg',
                'user_id' => 1, // ユーザーIDを適切な値に変更
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // エリアをシーディング
            DB::table('areas')->insert([
                'area' => $faker->randomElement($areas),
                'shop_id' => $shopId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // ジャンルをシーディング
            DB::table('genres')->insert([
                'genre' => $faker->randomElement($genres),
                'shop_id' => $shopId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
