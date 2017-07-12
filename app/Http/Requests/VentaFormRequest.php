<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VentaFormRequest extends FormRequest
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
            'tipo_comprobante'=>'required|max:20',
            'serie_comprobante'=>'required|max:20',
            'num_comprobante'=>'required|max:20',
            'fecha_hora'=>'required',
            'impuesto'=>'required',
            'total_venta'=>'required',
            'estado'=>'required|max:20'
        ];
    }
}
