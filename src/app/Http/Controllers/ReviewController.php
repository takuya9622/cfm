<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Order;
use App\Models\Review;
use App\Notifications\OrderCompleted;
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

        $this->notifySellerIfReviewedByBuyer($order, $reviewerId, $buyerId);

        $this->completeOrderIfBothReviewed($order);

        return redirect()->route('items.index')
            ->with('message', 'レビューを投稿しました');
    }

    private function notifySellerIfReviewedByBuyer(Order $order, int $reviewerId, int $buyerId): void
    {
        if ($reviewerId === $buyerId) {
            $order->seller->notify(new OrderCompleted($order));
        }
    }

    private function completeOrderIfBothReviewed(Order $order): void
    {
        $buyerId = $order->buyer_id;
        $sellerId = $order->seller_id;

        $buyerReviewed = Review::where('order_id', $order->id)
            ->where('reviewer_id', $buyerId)
            ->where('reviewed_user_id', $sellerId)
            ->exists();

        $sellerReviewed = Review::where('order_id', $order->id)
            ->where('reviewer_id', $sellerId)
            ->where('reviewed_user_id', $buyerId)
            ->exists();

        if ($buyerReviewed && $sellerReviewed) {
            $order->update(['status' => Order::STATUS_COMPLETED]);
        }
    }
}
