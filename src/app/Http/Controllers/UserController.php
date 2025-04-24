<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Http\Requests\ProfileRequest;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request) {
        $tab = $request->query('tab', 'sell');

        $query = Item::query();

        switch ($tab) {
            case 'sell':
            default:
                $query->where('seller_id', auth()->id());
                break;


            case 'buy':
                $query->whereIn('id', function ($query) {
                    $query->select('item_id')
                        ->from('orders')
                        ->where('buyer_id', auth()->id());
                });
                break;

            case 'dealing':
                $query->whereIn('id', function ($subQuery) {
                    $subQuery->select('item_id')
                        ->from('orders')
                        ->where(function ($q) {
                            $q->where('buyer_id', auth()->id())
                                ->orWhere('seller_id', auth()->id());
                        });
                });
                break;
        }
        $items = $query->with([
            'orders.chats' => function ($query) {
                $query->where('is_read', false);
        }])->get();

        $unreadCount = Order::where('status', 0)
            ->where(function ($q) {
                $q->where('buyer_id', auth()->id())
                    ->orWhere('seller_id', auth()->id());
            })
            ->with(['chats' => function ($query) {
                $query->where('user_id', '!=', auth()->id())
                        ->where('is_read', false);
            }])
            ->get()
            ->sum(fn($order) => $order->chats->count());

        return view('profile', compact('items', 'tab', 'unreadCount'));
    }

    public function editProfile() {
        $profile = auth()->user();

        return view('edit_profile', compact('profile'));
    }

    public function updateProfile(ProfileRequest $request) {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image && $user->profile_image !== 'users/default.png') {
                Storage::disk('public')->delete($user->profile_image);
            }

            $path = $request->file('profile_image')->store('users', 'public');
            $user->profile_image = $path;
        }

        $user->name = $request->input('name');
        $user->postal_code = $request->input('postal_code');
        $user->address = $request->input('address');
        $user->building = $request->input('building');
        $user->save();

        return redirect()->route('profile.edit');
    }
}
