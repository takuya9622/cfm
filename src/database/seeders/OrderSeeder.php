<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $items = Item::all();
        $selectedItems = $items->random(floor($items->count() / 3));

        foreach ($selectedItems as $item) {
            $buyer = $users->where('id', '!=', $item->seller_id)->random();

            Order::factory()->create([
                'item_id' => $item->id,
                'buyer_id' => $buyer->id,
                'seller_id' => $item->seller_id,
                'status' => 0,
            ]);

            $item->update(['status' => Item::STATUS_SOLD]);
        }
    }
}
