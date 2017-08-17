<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ArticuloFormRequest;
use App\Articulo;
use Carbon\Carbon;
use DB;
use PDF;

class InventarioController extends Controller
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
        $articulos=DB::table('articulo as a')
        ->join('categoria as c', 'a.idcategoria', '=', 'c.idcategoria')
        ->select('a.idarticulo', 'c.nombre as categoria', 'a.codigo', 'a.nombre', 'a.cantidad',  'a.descripcion', 'a.imagen', 'a.estado')
        ->where('a.nombre', 'LIKE', '%'.$query.'%')
        ->orwhere('c.nombre', 'LIKE', '%'.$query.'%')
        ->orderBy('a.idarticulo', 'DESC')
        ->paginate(8);

        return view('informes.inventario.index', ['articulos'=>$articulos, 'searchText'=>$query]);
      }

    }

    public function reporteIventario(Request $request)
    {
      $fecha_reporte= Carbon::now()->format('Y-m-d');
      if ($request->has('download')) {
        $query=trim($request->get('searchText'));
        $arts= Articulo::all();
        $articulos=DB::table('articulo as a')
        ->join('categoria as c', 'a.idcategoria', '=', 'c.idcategoria')
        ->select('a.idarticulo', 'c.nombre as categoria', 'a.codigo', 'a.nombre', 'a.cantidad',  'a.descripcion', 'a.imagen', 'a.estado')
        ->where('a.nombre', 'LIKE', '%'.$query.'%')
        ->orwhere('c.nombre', 'LIKE', '%'.$query.'%')
        ->orderBy('a.idarticulo', 'DESC')
        ->get();
        $pdf = PDF::loadView('informes.inventario.reporte_inventario', array('articulos'=>$articulos))->setPaper('letter', 'landscape');
        return $pdf->stream('Inventario '.$fecha_reporte.'.pdf');
      }
    }
}
