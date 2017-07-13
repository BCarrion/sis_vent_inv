@extends ('layouts.admin')
@section ('contenido')
  <div class="row">
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
      <h3>Listado De Categorias | <a href="categoria/create"><button class="btn btn-success" type="button" name="button">Nuevo</button></a></h3>
      @include('almacen.categoria.search')
    </div>
  </div>
  <div class="row">
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
      <div class="table-responsive">
        <table class="table table-stripped table-bordered table-condensed table-bordered">
          <thead>
            <th>Id</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Opciones</th>
          </thead>
          @foreach($categorias as $cat)
          <tr>
            <td>{{$cat->idcategoria}}</td>
            <td>{{$cat->nombre}}</td>
            <td>{{$cat->descripcion}}</td>
            <td>
              <a href="#" class="btn btn-info">Editar</a>
              <a href="#" class="btn btn-danger">Eliminar</a>
            </td>
          </tr>
          @endforeach
        </table>
      </div>
      {{$categorias->render()}}
      </div>
  </div>
@endsection
