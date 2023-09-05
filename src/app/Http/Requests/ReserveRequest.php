<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReserveRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'day' => 'required|date|after:today', // 今日以降の日付
            'time' => 'required|date_format:H:i', // 時間形式 (HH:mm)
            'people' => 'required|integer|min:1', // 1以上の整数
        ];
    }

    public function messages()
    {
        return [
            'day.required' => '日付は必須項目です。',
            'day.date' => '日付は日付形式で入力してください。',
            'day.after' => '今日以降の日付を入力してください。',
            'time.required' => '時間は必須項目です。',
            'time.date_format' => '時間は時間形式（HH:MM）で入力してください。',
            'people.required' => '人数は必須項目です。',
            'people.integer' => '人数は整数で入力してください。',
            'people.min' => '人数は1人以上で入力してください。',
        ];
    }

}
