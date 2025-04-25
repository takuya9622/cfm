<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    public function authorize()
    {
        $order = $this->route('order');

        return $order &&
            ($order->buyer_id === auth()->id() || $order->seller_id === auth()->id());
    }

    public function rules(): array
    {
        return [
            'rating' => ['required', 'integer','min:1', 'max:5'],
        ];
    }

    public function messages()
    {
        return [
            'rating.required' => '評価を入力してください',
            'rating.integer' => '評価の値が不正です',
            'rating.min' => '評価の値が不正です',
            'rating.max' => '評価の値が不正です',
        ];
    }
}
