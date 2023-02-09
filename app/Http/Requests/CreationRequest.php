<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CreationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'user_id' => 'required',
            'likes' => 'required',
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validación de errores',
            'data'      => $validator->errors()
        ]));
    }
    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido.',
            'numeric' => 'El campo :attribute debe estar en formato númerico.',
            'min' => 'El campo :attribute debe tener mínimo :min dígitos.',
            'max' => 'El campo :attribute debe tener máximo :max dígitos.',
            'email' => 'El campo :attribute no tiene un formato válido de correo.',
            'digits_between' => 'El campo :attribute tiene mínimo :min y máximo :max dígitos',
            'unique' => 'El campo :attribute ya está registrado.'
        ];
    }
}
