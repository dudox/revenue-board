<?php

namespace App\Http\Requests\Admin\Batches;

use Illuminate\Foundation\Http\FormRequest;

class CreateDenomination extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'batch' => 'required|exists:batches,id',
            'cost' => 'required|numeric',
            // 'description' => 'required',
            'duration' => 'required|exists:durations,id',
        ];
    }
}
