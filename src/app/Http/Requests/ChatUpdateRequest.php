<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChatUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $chat = $this->route('chat');
        return $chat && $chat->user_id === auth()->id();
    }

    public function rules(): array
    {
        return [
            'message' => ['required', 'string', 'max:400'],
        ];
    }

    public function messages()
    {
        return [
            'message.required' => '本文を入力してください',
            'message.string' => '本文は文字列で入力してください',
            'message.max' => '本文は400文字以内で入力してください',
        ];
    }
}
