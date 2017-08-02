<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ArticuloFormRequest;
use App\Articulo;
use DB;
use PDF;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $articulos=DB::table('articulo as a')
      ->join('categoria as c', 'a.idcategoria', '=', 'c.idcategoria')
      ->select('a.idarticulo', 'c.nombre as categoria', 'a.codigo', 'a.nombre', 'a.cantidad',  'a.descripcion', 'a.imagen', 'a.estado')
      ->orderBy('a.idarticulo', 'DESC')
      ->paginate(8);

      return view('informes.inventario.index', ['articulos'=>$articulos]);
    }

    public function reporteIventario(Request $request)
    {
      if ($request->has('download')) {
        $arts= Articulo::all();
        $articulos=DB::table('articulo as a')
        ->join('categoria as c', 'a.idcategoria', '=', 'c.idcategoria')
        ->select('a.idarticulo', 'c.nombre as categoria', 'a.codigo', 'a.nombre', 'a.cantidad',  'a.descripcion', 'a.imagen', 'a.estado')
        ->orderBy('a.idarticulo', 'DESC')
        ->get();
        $pdf = PDF::loadView('informes.inventario.reporte_inventario', array('articulos'=>$articulos));
        return $pdf->stream('inventario');
      }
    }
}
