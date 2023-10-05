<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OwnerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'area' => 'required|string',
            'genre' => 'required|string',
            'overview' => 'required|string',
            'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // 画像ファイルのバリデーションルール
        ];
    }
}
