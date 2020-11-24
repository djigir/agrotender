<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileCompanyNewsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'content' => 'required',
        ];
    }


    public function messages()
    {
        return [
            'title.required' => 'Введите заголовок',

            'logo.image' => 'Только картинка может быть логотипом',
            'logo.mimes' => 'Выбран неверный формат изображения',

            'content.required' => 'Введите описание',
        ];
    }
}
