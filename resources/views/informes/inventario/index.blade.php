@extends ('layouts.admin')
@section('contenido')
<div class="row">
  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
    <h3>Inventario De Articulos | <a href="inventario/reporteInventario"><button class="btn btn-success" type="button" name="button">Descargar</button></a></h3>
  </div>
</div>
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="table-responsive">
      <table class="table table-stripped table-bordered table-condensed table-bordered">
        <thead style="background-color: #A9D0F5">
          <th>Id</th>
          <th>Nombre</th>
          <th>Código</th>
          <th>Categoría</th>
          <th>Disponible</th>
          <th>Estado</th>
        </thead>
        @foreach($articulos as $art)
        <tr>
          <td>{{$art->idarticulo}}</td>
          <td>{{$art->nombre}}</td>
          <td>{{$art->codigo}}</td>
          <td>{{$art->categoria}}</td>
          <td>{{$art->cantidad}}</td>
          <td>{{$art->estado}}</td>
        </tr>
        @endforeach
      </table>
    </div>
    </div>
          {{$articulos->render()}}
</div>
@endsection
