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
        $this->authorize('view', $currentOrder);
        $reviewSubmitted = $currentOrder->reviews()
            ->where('reviewer_id', auth()->id())
            ->exists();
        if ($reviewSubmitted === true) {
            return redirect()->route('items.index')
                ->with('message', 'すでにレビューを投稿済みです');
        }

        $item = Item::findOrFail($currentOrder->item_id);
        $reviewReceived = $currentOrder->reviews()
            ->where('reviewed_user_id', auth()->id())
            ->exists();

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

        return view('dealing_chat', compact('currentOrder', 'item', 'reviewSubmitted', 'reviewReceived', 'otherUser', 'messages', 'otherOrders'));
    }

    public function store(ChatStoreRequest $request)
    {
        if ($request->filled('send.message')) {
            $chat = new Chat();
            $chat->fill([
                'order_id' => $request->route('orderId'),
                'user_id' => auth()->id(),
                'is_read' => Chat::STATUS_UNREAD,
                'message' => $request->input('send.message'),
            ]);

            if ($request->hasFile('send.image')) {
                $chat->image = $request->file('send.image')->store('chats', 'public');
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
            'message' => $request->input('edit.message'),
        ]);
        $chat->save();

        return back();
    }

    public function destroy(Chat $chat)
    {
        $this->authorize('delete', $chat);

        if ($chat->image) {
            Storage::disk('public')->delete($chat->image);
        }

        $chat->delete();

        return back();
    }
}
