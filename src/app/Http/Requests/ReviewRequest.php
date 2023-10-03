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
            'comment' => 'nullable|string|max:400',
            'img' => 'nullable|image|mimes:jpeg,png|max:2048',
        ];
    }
}
