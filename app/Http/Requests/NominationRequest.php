<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Nomination;

class NominationRequest extends FormRequest
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
        return Nomination::getNominationValidationRulesArray($request->get('id'), []);
    }

    public function messages()
    {
        return [
            'title.required' => 'Введите наименование номинации',
            'title.unique'   => 'Номинация с введенным наименованием уже используется',
            'slug.required' => 'Введите slug номинации',
            'color.required' => 'Введите цвет номинации',
            'ordering.required' => 'Введите порядковый номер номинации',
            'ordering.integer' => 'Порядковый номер должен быть целым числом',
        ];
    }
}
