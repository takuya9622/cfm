<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run()
    {
        $testUser1 = User::where('name', 'test_user1')->first();
        $testUser2 = User::where('name', 'test_user2')->first();

        $presetItems = [
            [
                'title' => '腕時計',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'price' => '15000',
                'condition' => '1',
                'item_image' => 'items/1.jpg',
            ],
            [
                'title' => 'HDD',
                'description' => '高速で信頼性の高いハードディスク',
                'price' => '5000',
                'condition' => '2',
                'item_image' => 'items/2.jpg',
            ],
            [
                'title' => '玉ねぎ3束',
                'description' => '新鮮な玉ねぎ3束のセット',
                'price' => '300',
                'condition' => '3',
                'item_image' => 'items/3.jpg',
            ],
            [
                'title' => '革靴',
                'description' => 'クラシックなデザインの革靴',
                'price' => '4000',
                'condition' => '4',
                'item_image' => 'items/4.jpg',
            ],
            [
                'title' => 'ノートPC',
                'description' => '高性能なノートパソコン',
                'price' => '45000',
                'condition' => '1',
                'item_image' => 'items/5.jpg',
            ],
            [
                'title' => 'マイク',
                'description' => '高音質のレコーディング用マイク',
                'price' => '8000',
                'condition' => '2',
                'item_image' => 'items/6.jpg',
            ],
            [
                'title' => 'ショルダーバッグ',
                'description' => 'おしゃれなショルダーバッグ',
                'price' => '3500',
                'condition' => '3',
                'item_image' => 'items/7.jpg',
            ],
            [
                'title' => 'タンブラー',
                'description' => '使いやすいタンブラー',
                'price' => '500',
                'condition' => '4',
                'item_image' => 'items/8.jpg',
            ],
            [
                'title' => 'コーヒーミル',
                'description' => '手動のコーヒーミル',
                'price' => '4000',
                'condition' => '1',
                'item_image' => 'items/9.jpg',
            ],
            [
                'title' => 'メイクセット',
                'description' => '便利なメイクアップセット',
                'price' => '2500',
                'condition' => '2',
                'item_image' => 'items/10.jpg',
            ],
        ];

        foreach (range(0, 4) as $i) {
            Item::factory()->state(function (array $attributes) use ($testUser1, $presetItems, $i) {
                return array_merge($attributes, [
                    'seller_id' => $testUser1->id,
                ], $presetItems[$i]);
            })->create();
        }

        foreach (range(5, 9) as $i) {
            Item::factory()->state(function (array $attributes) use ($testUser2, $presetItems, $i) {
                return array_merge($attributes, [
                    'seller_id' => $testUser2->id,
                ], $presetItems[$i]);
            })->create();
        }
    }
}
