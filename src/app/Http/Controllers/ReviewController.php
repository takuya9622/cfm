<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(ReviewRequest $request, Order $order)
    {
        $reviewerId = auth()->id();
        $buyerId = $order->buyer_id;
        $sellerId = $order->seller_id;
        $reviewedUserId = $buyerId === $reviewerId ? $sellerId : $buyerId;

        $review = new Review();
        $review->fill([
            'order_id' => $order->id,
            'reviewer_id' => $reviewerId,
            'reviewed_user_id' => $reviewedUserId,
            'rating' => $request->input('rating'),
        ]);
        $review->save();

        $orderId = $order->id;

        $buyerReviewed = Review::where('order_id', $orderId)
            ->where('reviewer_id', $buyerId)
            ->where('reviewed_user_id', $sellerId)
            ->exists();

        $sellerReviewed = Review::where('order_id', $orderId)
            ->where('reviewer_id', $sellerId)
            ->where('reviewed_user_id', $buyerId)
            ->exists();

        if ($buyerReviewed && $sellerReviewed) {
            Order::where('id', $orderId)->update(['status' => Order::STATUS_COMPLETED]);
        }

        return redirect()->route('items.index')
            ->with('message', 'レビューを投稿しました');
    }
}
