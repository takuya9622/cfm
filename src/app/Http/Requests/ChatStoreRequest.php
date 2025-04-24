<?php

namespace App\Http\Requests;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class ChatStoreRequest extends FormRequest
{
    public function authorize()
    {
        $orderId = $this->route('orderId');
        $order = Order::find($orderId);

        return $order &&
            ($order->buyer_id === auth()->id() || $order->seller_id === auth()->id());
    }

    public function rules(): array
    {
        return [
            'message' => ['required', 'string', 'max:400'],
            'image' => ['image', 'mimes:jpeg,png', 'max:2048'],
        ];
    }

    public function messages()
    {
        return [
            'message.required' => '本文を入力してください',
            'message.string' => '本文は文字列で入力してください',
            'message.max' => '本文は400文字以内で入力してください',
            'image.image' => '「.png」または「.jpeg」形式でアップロードしてください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
            'image.max' => '画像のサイズは2MB以下にしてください',
        ];
    }
}
