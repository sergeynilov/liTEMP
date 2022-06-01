<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Photo;

class UploadPhotoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $request = request();
//        \Log::info(varDump($request, ' -1 UploadPhotoRequest $request::'));
        $uploaded_file_max_mib = (int)\Config::get('app.uploaded_file_max_mib', 10);
        $max_size              = 1024 * $uploaded_file_max_mib;  // 1024*2 = 2Mib
        \Log::info(  varDump($max_size, ' -1 $max_size::') );

        $mimes_str= '';
        $uploaded_documents_extensions = config('app.uploaded_documents_extensions', []);
        foreach( $uploaded_documents_extensions as $next_uploaded_documents_extension ) {
            $mimes_str.= $next_uploaded_documents_extension.',';
        }
        $mimes_str= trimRightSubString($mimes_str, ',');

        $photo_dimension_limits = config('app.photo_dimension_limits');
        $max_width              = $photo_dimension_limits['max_width'] ?? 2400;
        \Log::info(  varDump($max_width , ' -1 $max_width::') );

        $rules= [
            'image' => [
                'required',
//                'mimes:jpeg,png,jpg',
                'max:' . $max_size,
                'dimensions:max_width=' . $max_width
            ]
        ];
        if(!empty($mimes_str)) {
//            $rules['image'][] = 'mimes:'.$mimes_str;
        }
        \Log::info(  varDump($rules, ' -1 $rules::') );
        return $rules;
    }

    public function messages()
    {
        $photo_dimension_limits = config('app.photo_dimension_limits');
        $max_width              = $photo_dimension_limits['max_width'] ?? 2400;
        $uploaded_file_max_mib  = (int)\Config::get('app.uploaded_file_max_mib', 1);

        $mimes_str= '';
        $uploaded_documents_extensions = config('app.uploaded_documents_extensions', []);
        foreach( $uploaded_documents_extensions as $next_uploaded_documents_extension ) {
            $mimes_str.= $next_uploaded_documents_extension.', ';
        }
        $mimes_str= trimRightSubString($mimes_str, ', ');

        return [
            'image.dimensions'    => 'Выбранная картинка слишком широкая. Максимальная ширина : ' . $max_width . 'px',
            'image.max'           => 'Размер выбранной фото не может превышать ' . $uploaded_file_max_mib . ' мб',
//            'uploaded' => 'Размер выбранной фото не может превышать ' . $uploaded_file_max_mib . ' мб и с максимальной шириной : ' . $max_width . 'px',
            'mimes' => 'Недопустимый формат фото. Допустимые форматы ' . $mimes_str,
        ];
    }
}
