<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Photo;

class PhotoRequest extends FormRequest
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
        return Photo::getPhotoValidationRulesArray($request->get('id'), ['owner_id','published_at']);
    }

    public function messages()
    {
        return [
            'owner_id.required' => 'Введите владельца фотографий',
            'name.required' => 'Введите наименование фотографий',
            'name.unique'   => 'Фотография с введенным наименованием уже используется',
            'slug.required' => 'Введите slug фотографий',
            'published_at.required' => 'Введите дату публикации фотографий',
            'published_at.date' => 'Дата публикации должна быть целым числом',
        ];
    }
}
