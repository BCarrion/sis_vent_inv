<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonaFormRequest extends FormRequest
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
            'tipo_persona'=>'required|max:20',
            'nombre'=>'required|max:50',
            'apellidos'=>'max:50',
            'tipo_documento'=>'required|max:50',
            'num_documento'=>'required|max:50',
            'direccion'=>'max:100',
            'telefono'=>'max:15',
            'correo'=>'max:50'
        ];
    }
}
