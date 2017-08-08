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

class VentasGeneralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $fecha_reporte= Carbon::now()->format('Y-m-d');

      if($request)
      {
      $query1=trim($request->get('searchText1'));
      $query2=trim($request->get('searchText2'));
      $query1=$query1.' 00:00:00';
      $query2=$query2.' 23:59:59';
      $ventas=DB::table('venta as v')
      ->join('persona as p', 'v.idcliente', '=', 'p.idpersona')
      ->join('detalle_venta as dv', 'v.idventa', '=', 'dv.idventa')
      ->select('v.idventa', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante',
               'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estado',
               'v.total_venta')
      ->whereBetween('v.fecha_hora',array( $query1, $query2))
      ->orderBy('v.idventa', 'DESC')
      ->groupBy('v.idventa', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante',
               'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estado', 'v.total_venta')
      ->paginate(8);
        return view('informes.ventas.ventas_general.index', ['ventas'=>$ventas, 'searchText1'=>$query1, 'searchText2'=>$query2, 'fecha_reporte'=>$fecha_reporte]);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function reporteGeneral(Request $request)
     {
       $fecha_reporte= Carbon::now()->format('Y-m-d');

       if ($request->has('download')) {
         $query1=trim($request->get('searchText1'));
         $query2=trim($request->get('searchText2'));
         $ventas=DB::table('venta as v')
         ->join('persona as p', 'v.idcliente', '=', 'p.idpersona')
         ->join('detalle_venta as dv', 'v.idventa', '=', 'dv.idventa')
         ->select('v.idventa', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante',
                  'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estado',
                  'v.total_venta')
         ->whereBetween('v.fecha_hora', array($query1, $query2))
         ->orderBy('v.idventa', 'DESC')
         ->groupBy('v.idventa', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante',
                  'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estado', 'v.total_venta')
         ->get();
         $pdf = PDF::loadView('informes.ventas.ventas_general.reporte_general', array('ventas'=>$ventas))->setPaper('letter', 'landscape');
         return $pdf->stream('Ventas Generales '.$fecha_reporte.'.pdf');

     }
   }
}
