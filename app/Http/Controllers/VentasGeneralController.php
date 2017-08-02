<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VentasGeneralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('informes.ventas.ventas_general.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function reporteGeneral(Request $request)
     {

     }
}
