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
use PDF;

class VentasDiaController extends Controller
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
    public function index()
    {
      $fecha_reporte= Carbon::now()->format('Y-m-d');
      $fecha_inicial= Carbon::now()->format('Y-m-d').' 00:00:00';
      $fecha_final= Carbon::now()->format('Y-m-d').' 23:59:59';
      $ventas=DB::table('venta as v')
      ->join('persona as p', 'v.idcliente', '=', 'p.idpersona')
      ->join('detalle_venta as dv', 'v.idventa', '=', 'dv.idventa')
      ->select('v.idventa', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante',
               'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estado',
               'v.total_venta')
      ->where('v.fecha_hora', '>=', $fecha_inicial, 'and', '<=', $fecha_final)
      ->orderBy('v.idventa', 'DESC')
      ->groupBy('v.idventa', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante',
               'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estado', 'v.total_venta')
      ->paginate(8);
        return view('informes.ventas.ventas_dia.index', ['ventas'=>$ventas, 'fecha_reporte'=>$fecha_reporte]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function reporteDia(Request $request)
     {
       $fecha_reporte= Carbon::now()->format('Y-m-d');
       $fecha_inicial= Carbon::now()->format('Y-m-d').' 00:00:00';
       $fecha_final= Carbon::now()->format('Y-m-d').' 23:59:59';

       if ($request->has('download')) {
         $ventas=DB::table('venta as v')
         ->join('persona as p', 'v.idcliente', '=', 'p.idpersona')
         ->join('detalle_venta as dv', 'v.idventa', '=', 'dv.idventa')
         ->select('v.idventa', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante',
                  'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estado',
                  'v.total_venta')
         ->where('v.fecha_hora', '>=', $fecha_inicial, 'and', '<=', $fecha_final)
         ->orderBy('v.idventa', 'DESC')
         ->groupBy('v.idventa', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante',
                  'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estado', 'v.total_venta')
         ->get();
         $pdf = PDF::loadView('informes.ventas.ventas_dia.reporte_dia', array('ventas'=>$ventas, 'fecha_reporte'=>$fecha_reporte))->setPaper('letter', 'landscape');
         return $pdf->stream('Ventas '.$fecha_reporte.'.pdf');
       }
     }

}
