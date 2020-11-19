<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewLoginRequest extends FormRequest
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
            'passwd' => 'min:6|max:20',
            'login' => 'email|unique:torg_buyer',
        ];
    }

    public function messages()
    {
        return [
            'passwd.min' => 'Минимальная длина нового пароля 6 символов',
            'passwd.max' => 'Максимальная длина нового пароля 20 символов',
            'login.email' => 'Вы указали не коректный email',
            'login.unique' => 'Данный Email адрес уже зарегистрирован на сайте',
        ];
    }

}
