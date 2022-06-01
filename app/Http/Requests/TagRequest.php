<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Tag;

class TagRequest extends FormRequest
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
        $request = request();

        return Tag::getTagValidationRulesArray($request->get('id'), []);
    }

    public function messages()
    {
        return [
            'title.required' => 'Введите наименование тега',
            'title.unique'   => 'Тег с введенным наименованием уже используется',
            'slug.required'  => 'Введите slug тега',
        ];
    }
}
