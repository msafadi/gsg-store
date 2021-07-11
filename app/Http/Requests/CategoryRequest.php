<?php

namespace App\Http\Requests;

use App\Rules\Filter;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        $id = $this->route('id');
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'min:3',
                'unique:categories,id,' . $id,
                function($attribute, $value, $fail) {
                    if (stripos($value, 'god') !== false) {
                        $fail('You cannot use "god" word in your input');
                    }
                }
            ],
            'parent_id' => 'required|int|exists:categories,id',
            'description' => [
                'nullable',
                'min:5',
                'filter:php,laravel',
                //new Filter(['php', 'laravel', 'css']),
            ],
            'status' => 'required|in:active,draft',
            'image' => 'image|max:512000|dimensions:min_width=300,min_height=300',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'الحقل :attribute مطلوب.',
        ];
    }
}
