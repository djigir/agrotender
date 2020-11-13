<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileCompany extends FormRequest
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
            'title' => 'required|string',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'content' => 'required|string',
            'region' => 'required',
            'rubrics' => 'min:1|max:5',
        ];
    }


    public function messages()
    {
        return [
            'title.required' => 'Введите название компании',
            'title.string' => 'Введите название компании строкой',

            'logo.image' => 'Только картинка может быть логотипом',
            'logo.mimes' => 'Выбран неверный формат изображения',

            'content.required' => 'Введите описание компании',
            'content.string' => 'Введите описание компании строкой',

            'region.required' => 'Вы не выбрали область',

            'rubrics.min' => 'Необходимо обязательно выбрать хотя бы один вид деятельности для компании',
            'rubrics.max' => 'Вы не можете выбрать более 5 видов деятельности для компании',
        ];
    }
}
