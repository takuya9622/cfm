<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(){
        return [
            'title' => ['required'],
            'category' => ['required'],
            'description' => ['required', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
            'condition' => ['required'],
            'item_image' => ['required', 'image', 'mimes:jpeg,png', 'max:2048'],
        ];
    }

    public function messages(){
        return [
            'title.required' => '商品名を入力してください',
            'category.required' => 'カテゴリーを選択してください',
            'description.required' => '商品の説明を入力してください',
            'description.max' => '商品の説明は255文字以内で入力してください',
            'price.required' => '販売価格を入力してください',
            'price.integer' => '販売価格は数値で入力してください',
            'price.min' => '0円以上に設定してください',
            'condition.required' => '商品の状態を選択してください',
            'item_image.required' => '商品の画像をアップロードしてください',
            'item_image.image' => '画像ファイルをアップロードしてください',
            'item_image.mimes' => '商品画像はjpegまたはpng形式でアップロードしてください',
            'item_image.max' => '商品画像のサイズは2MB以下にしてください',
        ];
    }
}
