<?php

namespace App\Http\Requests;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class ChatStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        $orderId = $this->route('orderId');
        $order = Order::find($orderId);

        return $order &&
            ($order->buyer_id === auth()->id() || $order->seller_id === auth()->id());
    }

    public function rules(): array
    {
        return [
            'send.message' => ['required', 'string', 'max:400'],
            'send.image' => ['image', 'mimes:jpeg,png', 'max:2048'],
        ];
    }

    public function messages()
    {
        return [
            'send.message.required' => '本文を入力してください',
            'send.message.string' => '本文は文字列で入力してください',
            'send.message.max' => '本文は400文字以内で入力してください',
            'send.image.image' => '「.png」または「.jpeg」形式でアップロードしてください',
            'send.image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
            'send.image.max' => '画像のサイズは2MB以下にしてください',
        ];
    }
}
