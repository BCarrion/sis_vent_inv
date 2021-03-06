@extends ('layouts.admin')
@section ('contenido')
  <div class="row">
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
      <h3>Listado De Proveedores | <a href="proveedor/create"><button class="btn btn-success" type="button" name="button">Nuevo</button></a></h3>
      @include('compras.proveedor.search')
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="table-responsive">
        <table class="table table-stripped table-bordered table-condensed table-bordered">
          <thead>
            <th>Id</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Tipo Doc</th>
            <th>Número Doc</th>
            <th>Teléfono</th>
            <th>Email</th>
            <th>Opciones</th>
          </thead>
          @foreach($personas as $per)
          <tr>
            <td>{{$per->idpersona}}</td>
            <td>{{$per->nombre}}</td>
            <td>{{$per->apellidos}}</td>
            <td>{{$per->tipo_documento}}</td>
            <td>{{$per->num_documento}}</td>
            <td>{{$per->telefono}}</td>
            <td>{{$per->correo}}</td>

            <td>
              <a href="{{URL::action('ProveedorController@edit', $per->idpersona)}}"><button class="btn btn-info">Editar</button></a>
              <a href="#" data-target="#modal-delete-{{$per->idpersona}}" data-toggle="modal"><button class="btn btn-danger">Eliminar</button></a>
            </td>
          </tr>
          @include('compras.proveedor.modal')
          @endforeach
        </table>
      </div>
      {{$personas->render()}}
      </div>
  </div>
@endsection
