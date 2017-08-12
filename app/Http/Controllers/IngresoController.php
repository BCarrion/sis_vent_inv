<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\IngresoFormRequest;
use App\Ingreso;
use App\DetalleIngreso;
use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class IngresoController extends Controller
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
         $ingresos=DB::table('ingreso as i')
         ->join('persona as p', 'i.idproveedor', '=', 'p.idpersona')
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
        $personas=DB::table('persona')->where('tipo_persona', '=', 'Proveedor')->get();
        $articulos=DB::table('articulo as art')
        ->select(DB::raw('CONCAT(art.codigo, " ", art.nombre) AS articulo'), 'art.idarticulo')
        ->where('art.estado', '=', 'Activo')
        ->get();

        return view('compras.ingreso.create', ['personas'=>$personas, 'articulos'=>$articulos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IngresoFormRequest $request)
    {
        try
        {
          $fecha=Date('ym');
          $registros= DB::table('ingreso')->count();
          DB::beginTransaction();
          $ingreso=new Ingreso();
          $ingreso->idproveedor=$request->get('idproveedor');
          $ingreso->tipo_comprobante=$request->get('tipo_comprobante');

          if($registros>0)
          {
            $consecutivo=Ingreso::all()->pluck('serie_comprobante')->last();
            $div=explode('-', $consecutivo);
            $numero=$div[2];
            $numero=$numero+1;
            if($numero / 10 < 1) $numero='000'.$numero;
            elseif ($numero / 10 > 1 && $numero /100 < 1) $numero='00'.$numero;
            elseif ($numero / 100 > 1 && $numero /1000 < 1) $numero='0'.$numero;
            else $numero;
            $ingreso->serie_comprobante= $fecha.'-'.$numero;
            $ingreso->num_comprobante= $fecha.'-'.$numero;
          }
          else
          {
            $ingreso->serie_comprobante= $fecha.'-'.'0001';
            $ingreso->num_comprobante= $fecha.'-'.'0001';
          }

          $mytime=Carbon::now('America/Bogota');
          $ingreso->fecha_hora=$mytime->toDateTimeString();

          if($ingreso->tipo_comprobante === 'factura')$ingreso->impuesto='19';
          elseif ($ingreso->tipo_comprobante === 'remision')$ingreso->impuesto='0';
          
          $ingreso->estado='A';
          $ingreso->save();

          $idarticulo=$request->get('idarticulo');
          $cantidad=$request->get('cantidad');
          $precio_compra=$request->get('precio_compra');
          $precio_venta=$request->get('precio_venta');

          $cont=0;

          while ($cont<count($idarticulo)) {
            $detalle=new DetalleIngreso();
            $detalle->idingreso=$ingreso->idingreso;
            $detalle->idarticulo=$idarticulo[$cont];
            $detalle->cantidad=$cantidad[$cont];
            $detalle->precio_compra=$precio_compra[$cont];
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

        return Redirect::to('compras/ingreso');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ingreso=DB::table('ingreso as i')
        ->join('persona as p', 'i.idproveedor', '=', 'p.idpersona')
        ->join('detalle_ingreso as di', 'i.idingreso', '=', 'di.idingreso')
        ->select('i.idingreso', 'i.fecha_hora', 'p.nombre', 'i.tipo_comprobante',
                 'i.serie_comprobante', 'i.num_comprobante', 'i.impuesto', 'i.estado',
                 DB::raw('sum(di.cantidad*precio_compra) as total'))
        ->where('i.idingreso', '=', $id)
        ->first();

        $detalles=DB::table('detalle_ingreso as d')
        ->join('articulo as a', 'd.idarticulo', '=', 'a.idarticulo')
        ->select('a.nombre as articulo', 'd.cantidad', 'd.precio_compra', 'd.precio_venta')
        ->where('d.idingreso', '=', $id )
        ->get();

        return view('compras.ingreso.show', ['ingreso'=>$ingreso, 'detalles'=>$detalles]);
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

        $ingreso=Ingreso::findOrFail($id);
        $ingreso->estado='C';
        $ingreso->update();

        return Redirect::to('compras/ingreso');
    }
}
