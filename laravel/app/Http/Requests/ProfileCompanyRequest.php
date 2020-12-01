<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileCompanyRequest extends FormRequest
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
            'obl_id' => 'required',
            'rubrics' => 'required|max:5',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Введите название компании',

            'logo.image' => 'Только картинка может быть логотипом',
            'logo.mimes' => 'Выбран неверный формат изображения',

            'content.required' => 'Введите описание компании',

            'obl_id.required' => 'Вы не выбрали область',

            'rubrics.required' => 'Необходимо обязательно выбрать хотя бы один вид деятельности для компании',
//            'rubrics.min' => 'Необходимо обязательно выбрать хотя бы один вид деятельности для компании',
            'rubrics.max' => 'Вы не можете выбрать более 5 видов деятельности для компании',
        ];
    }
}
