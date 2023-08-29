<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GeneratorRequest extends FormRequest
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
            'tool_id' => ['nullable', Rule::exists('tools', 'id')->whereNull('deleted_at')],
            'name' => 'required|string|min:2',
            'link' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'nullable|min:3',
        ];
    }
}
