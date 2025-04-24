<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatStoreRequest;
use App\Http\Requests\ChatUpdateRequest;
use App\Models\Chat;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    public function show($orderId)
    {
        $currentOrder = Order::findOrFail($orderId);
        $item = Item::findOrFail($currentOrder->item_id);

        $user = auth()->user();
        $otherUser = $currentOrder->buyer_id === $user->id ? $currentOrder->seller : $currentOrder->buyer;

        $messages = Chat::with('user')
            ->where('order_id', $currentOrder->id)
            ->orderBy('created_at', 'asc')
            ->get();

        Chat::where('order_id', $currentOrder->id)
            ->where('user_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $otherOrders = Order::with('item')
            ->withMax('chats', 'updated_at')
            ->where(function ($query) use ($user) {
                $query->where('buyer_id', $user->id)
                    ->orWhere('seller_id', $user->id);
            })
            ->where('status', 0)
            ->where('id', '!=', $currentOrder->id)
            ->orderBy('chats_max_updated_at', 'desc')
            ->get();

        return view('dealing_chat', compact('currentOrder', 'item', 'otherUser', 'messages', 'otherOrders'));
    }

    public function store(ChatStoreRequest $request)
    {

        if ($request->filled('message')) {
            $chat = new Chat();
            $chat->fill([
                'order_id' => $request->route('orderId'),
                'user_id' => auth()->id(),
                'is_read' => Chat::STATUS_UNREAD,
                'message' => $request->input('message'),
            ]);

            if ($request->hasFile('image')) {
                $chat->image = $request->file('image')->store('chats', 'public');
            }

            $chat->save();
        }

        return redirect()->route('chat.show', $request->route('orderId'));
    }

    public function update(ChatUpdateRequest $request, Chat $chat)
    {
        $this->authorize('update', $chat);

        $chat->fill([
            'is_read' => Chat::STATUS_UNREAD,
            'message' => $request->input('message'),
        ]);
        $chat->save();

        return back()->with('status', 'チャットを更新しました');
    }

    public function destroy(Chat $chat)
    {
        $this->authorize('delete', $chat);

        if ($chat->image) {
            Storage::disk('public')->delete($chat->image);
        }

        $chat->delete();

        return back()->with('status', 'チャットを削除しました');
    }
}
