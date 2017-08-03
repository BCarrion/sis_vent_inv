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
      if($request)
      {
      $query1=trim($request->get('searchText1'));
      $query2=trim($request->get('searchText2'));
      if($query1!="" && $query2!="")
      {
        $query1=$query1.' 00:00:00';
        $query2=$query2.' 23:59:59';
      }
      $ventas=DB::table('venta as v')
      ->join('persona as p', 'v.idcliente', '=', 'p.idpersona')
      ->join('detalle_venta as dv', 'v.idventa', '=', 'dv.idventa')
      ->select('v.idventa', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante',
               'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estado',
               'v.total_venta')
      ->where('v.fecha_hora', '>=', $query1, 'and', '<=', $query2)
      ->orderBy('v.idventa', 'DESC')
      ->groupBy('v.idventa', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante',
               'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estado', 'v.total_venta')
      ->paginate(8);
        return view('informes.ventas.ventas_general.index', ['ventas'=>$ventas, 'searchText1'=>$query1, 'searchText2'=>$query2]);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function reporteGeneral(Request $request)
     {
       $fecha_inicial='2017-01-01 00:00:00';
       $fecha_final='2017-08-01 00:00:00';

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
         $pdf = PDF::loadView('informes.ventas.ventas_general.reporte_general', array('ventas'=>$ventas));
         return $pdf->stream('inventario');

     }
   }
}
