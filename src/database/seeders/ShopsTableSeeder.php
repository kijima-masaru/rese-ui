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

        // 飲食店名のリスト
        $restaurantNames = [
            'すしや さくら',
            '焼肉 炭火亭',
            'イタリアン レストラン ベラ',
            '居酒屋 とりの家',
            'ラーメン 一楽',
            '寿司の宝石',
            '焼肉の楽園',
            'イタリア料理 ラ・トラットリア',
            '居酒屋 かっぱ',
            'ラーメン天国',
            '魚料理 うみねこ',
            '焼き鳥屋 やきとり本舗',
            'フレンチ クリスタル',
            '居酒屋 まるたん',
            '中華料理 龍門',
            '寿司の匠',
            'カフェ ペルラ',
            '焼肉 たんか',
            '洋食屋 ベルサイユ',
            '居酒屋 かんざし',
            'ラーメンラボ',
            '天ぷら 美味庵',
            'ホルモン焼き やきもん',
            'イタリアン グランデ',
            '寿司の楽しみ',
            'しゃぶしゃぶ温野菜',
            '居酒屋 花より団子',
            'ラーメン家 あさみ',
            '天ぷらの宝石',
        ];

        // エリアとジャンルの選択肢
        $areas = ['東京都', '大阪府', '福岡県'];
        $genres = ['寿司', '焼肉', 'イタリアン', '居酒屋', 'ラーメン'];

        // ダミー店舗を30件生成
        for ($i = 1; $i <= 30; $i++) {
            $shopId = DB::table('shops')->insertGetId([
                'name' => $faker->randomElement($restaurantNames), // 飲食店名をランダムに選択
                'overview' => $faker->realText(200), // 飲食店の概要を生成
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
