<?php


namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class RequestLogin extends FormRequest
{
  /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password'=>'required|string',
            'email'=>'required|string|email',
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
            'unique' => 'El campo :attribute ya está registrado.',
            'email' => 'El campo :attribute tiene que ser un correo valido.'
        ];
    }
}
