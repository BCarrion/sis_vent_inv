<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\DevolucionFormRequest;
use App\Persona;
use App\Venta;
use App\DetalleVenta;
use DB;
use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class DevolucionController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      if ($request) {

        $query=trim($request->get('searchText'));
        $devoluciones=DB::table('venta as v')
        ->join('persona as p', 'v.idcliente', '=', 'p.idpersona')
        ->join('detalle_venta as dv', 'v.idventa', '=', 'dv.idventa')
        ->select('v.idventa', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante',
                 'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estado',
                 'v.total_venta')
        ->where('p.nombre', '=', 'Devolucion')
        ->where('v.num_comprobante', 'LIKE', '%'.$query.'%')
        ->orderBy('v.idventa', 'DESC')
        ->groupBy('v.idventa', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante',
                 'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estado', 'v.total_venta')
        ->paginate(8);

        return view('ventas.devolucion.index', ['devoluciones'=>$devoluciones, 'searchText'=>$query]);
      }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $persona=DB::table('persona')->where('nombre', '=', 'Devolucion')->first();
      if($persona==null)
      {
        $persona= New persona();
        $persona->tipo_persona='Cliente';
        $persona->nombre='Devolucion';
        $persona->tipo_documento='CC';
        $persona->num_documento='123456';
        $persona->save();
      }
      $articulos=DB::table('articulo as art')
      ->join('detalle_ingreso as di', 'art.idarticulo', '=', 'di.idarticulo')
      ->select(DB::raw('CONCAT(art.codigo, " ", art.nombre) AS articulo'),
      'art.idarticulo', 'art.cantidad', DB::raw('avg(di.precio_venta) AS precio_promedio'))
      ->where('art.estado', '=', 'Activo')
      ->where('art.cantidad', '>', '0')
      ->groupBy('articulo', 'art.idarticulo', 'art.cantidad')
      ->get();

      return view('ventas.devolucion.create', ['persona'=>$persona, 'articulos'=>$articulos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DevolucionFormRequest $request)
    {
        if ($request->has('Remision')) {
            dd('llego el dato');
        }
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
