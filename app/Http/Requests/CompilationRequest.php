<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Compilation;

class CompilationRequest extends FormRequest
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
        return Compilation::getCompilationValidationRulesArray($request->get('id'), []);
    }

    public function messages()
    {
        return [
            'title.required' => 'Введите наименование подборки',
            'title.unique'   => 'Подборка с введенным наименованием уже используется',
            'ordering.required' => 'Введите порядковый номер подборки',
            'ordering.integer' => 'Порядковый номер должен быть целым числом',
        ];
    }
}
