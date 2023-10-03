<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CSVImportRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'csv_file' => 'required|mimes:csv,txt',
        ];
    }

    public function messages()
    {
        return [
            'csv_file.required' => 'CSVファイルを選択してください。',
            'csv_file.mimes' => 'CSVファイルの拡張子はcsvまたはtxtである必要があります。',
        ];
    }
}
