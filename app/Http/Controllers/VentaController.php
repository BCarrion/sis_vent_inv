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


class VentaController extends Controller
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
       if($request)
       {
         $query=trim($request->get('searchText'));
         $ventas=DB::table('venta as v')
         ->join('persona as p', 'v.idcliente', '=', 'p.idpersona')
         ->join('detalle_venta as dv', 'v.idventa', '=', 'dv.idventa')
         ->select('v.idventa', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante',
                  'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estado',
                  'v.total_venta')
         ->where('v.num_comprobante', 'LIKE', '%'.$query.'%')
         ->orderBy('v.idventa', 'DESC')
         ->groupBy('v.idventa', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante',
                  'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estado', 'v.total_venta')
         ->paginate(8);

         return view('ventas.venta.index', ['ventas'=>$ventas, 'searchText'=>$query]);
       }
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $personas=DB::table('persona')->where('tipo_persona', '=', 'Cliente')->get();
        $articulos=DB::table('articulo as art')
        ->join('detalle_ingreso as di', 'art.idarticulo', '=', 'di.idarticulo')
        ->select(DB::raw('CONCAT(art.codigo, " ", art.nombre) AS articulo'),
        'art.idarticulo', 'art.cantidad', DB::raw('avg(di.precio_venta) AS precio_promedio'))
        ->where('art.estado', '=', 'Activo')
        ->where('art.cantidad', '>', '0')
        ->groupBy('articulo', 'art.idarticulo', 'art.cantidad')
        ->get();

        return view('ventas.venta.create', ['personas'=>$personas, 'articulos'=>$articulos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VentaFormRequest $request)
    {
        try
        {
          $fecha=Date('ym');
          $registros= DB::table('venta')->count();
          DB::beginTransaction();
          $venta=new Venta();
          if($registros>0)
          {
            $consecutivo=Venta::all()->pluck('serie_comprobante')->last();
            $div=explode('-', $consecutivo);
            $numero=$div[1];
            $numero=$numero+1;
            if($numero / 10 < 1) $numero='000'.$numero;
            elseif ($numero / 10 > 1 && $numero /100 < 1) $numero='00'.$numero;
            elseif ($numero / 100 > 1 && $numero /1000 < 1) $numero='0'.$numero;
            else $numero;
            $venta->serie_comprobante= $fecha.'-'.$numero;
            $venta->num_comprobante= $fecha.'-'.$numero;
          }
          else
          {
            $venta->serie_comprobante= $fecha.'-'.'0001';
            $venta->num_comprobante= $fecha.'-'.'0001';
          }
          $venta->idcliente=$request->get('idcliente');
          $venta->tipo_comprobante=$request->get('tipo_comprobante');
          $venta->total_venta=$request->get('total_venta');

          $mytime=Carbon::now('America/Bogota');
          $venta->fecha_hora=$mytime->toDateTimeString();
          if($venta->tipo_comprobante === 'factura')$venta->impuesto='19';
          elseif ($venta->tipo_comprobante === 'remision')$venta->impuesto='0';
          $venta->estado='A';
          $venta->save();

          $idarticulo=$request->get('idarticulo');
          $cantidad=$request->get('cantidad');
          $descuento=$request->get('descuento');
          $precio_venta=$request->get('precio_venta');

          $cont=0;

          while ($cont<count($idarticulo)) {
            $detalle=new DetalleVenta();
            $detalle->idventa=$venta->idventa;
            $detalle->idarticulo=$idarticulo[$cont];
            $detalle->cantidad=$cantidad[$cont];
            $detalle->descuento=$descuento[$cont];
            $detalle->precio_venta=$precio_venta[$cont];
            $detalle->save();

            $cont=$cont+1;
          }

          DB::commit();
        }
        catch (\Exception $e)
        {
          DB::rollback();
        }

        return Redirect::to('ventas/venta');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $venta=DB::table('venta as v')
        ->join('persona as p', 'v.idcliente', '=', 'p.idpersona')
        ->join('detalle_venta as dv', 'v.idventa', '=', 'dv.idventa')
        ->select('v.idventa', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante',
                 'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estado',
                 'v.total_venta')
        ->where('v.idventa', '=', $id)
        ->first();

        $detalles=DB::table('detalle_venta as d')
        ->join('articulo as a', 'd.idarticulo', '=', 'a.idarticulo')
        ->select('a.nombre as articulo', 'd.cantidad', 'd.descuento', 'd.precio_venta')
        ->where('d.idventa', '=', $id )
        ->get();

        return view('ventas.venta.show', ['venta'=>$venta, 'detalles'=>$detalles]);
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

        $venta=Venta::findOrFail($id);
        $venta->estado='C';
        $venta->update();

        return Redirect::to('ventas/venta');
    }
}
