<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IngresoFormRequest extends FormRequest
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
            'tipo_comprobante'=>'required|max:20'
            'serie_comprobante'=>'max:15'
            'num_comprobante'=>'required|max:15'
            'fecha_hora'=>'required'
            'impuesto'=>'required'
            'valor'=>'required|max:45'
            'estado'=>'required|max:20'
        ];
    }
}
