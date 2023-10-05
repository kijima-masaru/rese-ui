<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:400',
            'img' => 'nullable|image|mimes:jpeg,png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'rating.required' => '5段階評価は必須です。',
            'rating.integer' => '5段階評価を指定してください。',
            'rating.between' => '評価は1から5の範囲で指定してください。',
            'comment.max' => '口コミは400文字以内で入力してください。',
            'img.image' => '画像ファイルを指定してください。',
            'img.mimes' => '画像はjpeg、png形式のみアップロードできます。',
            'img.max' => '画像ファイルのサイズは2MB以下にしてください。',
        ];
    }
}
