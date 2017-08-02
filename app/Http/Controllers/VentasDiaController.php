<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\VentaFormRequest;
use App\Venta;
use App\DetalleVenta;
use DB;
use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class VentasDiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fecha_actual= Carbon::now()->format('Y-m-d');
        dd($fecha_actual);
        return view('informes.ventas.ventas_dia.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function reporteDia(Request $request)
     {

     }

}
