<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\IngresoFormRequest;
use Illuminate\Support\Facades\Input;
use App\Ingreso;
use App\DetalleIngreso;
use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;
use DB;

class IngresoController extends Controller
{
    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
     {
       if($request)
       {
         $query=trim($request->get('searchText'));
         $ingresos=DB::table('ingreso as i')
         ->join('persona as p', 'i.idpersona', '=', 'p.idpersona')
         ->join('detalle_ingreso as di', 'i.idingreso', '=', 'di.idingreso')
         ->select('i.idingreso', 'i.fecha_hora', 'p.nombre', 'i.tipo_comprobante',
                  'i.serie_comprobante', 'i.num_comprobante', 'i.impuesto', 'i.estado',
                  DB::raw('sum(di.cantidad*precio_compra) as total'))
         ->where('i.num_comprobante', 'LIKE', '%'.$query.'%')
         ->orderBy('i.idingreso', 'DESC')
         ->groupBy('i.idingreso', 'i.fecha_hora', 'p.nombre', 'i.tipo_comprobante',
                  'i.serie_comprobante', 'i.num_comprobante', 'i.impuesto', 'i.estado')
         ->paginate(8);

         return view('compras.ingreso.index', ['ingresos'=>$ingresos, 'searchText'=>$query]);
       }
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $persona=DB::table('persona')->where('tipo_persona', '=', 'Proveedor')->get();
        $articulos=DB::table('articulo as art')
        ->select(DB::raw('CONCAT(art.codigo, " ", art.nombre) AS articulo'), 'art.idarticulo')
        ->get()
        ->where('art.estado', '=', 'Activo');

        return view('compras.ingreso.create', ['persona'=>$persona, 'articulos'=>$articulos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
