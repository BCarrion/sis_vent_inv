@extends ('layouts.admin')
@section ('contenido')
  <div class="row">
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
      <h3>Listado De Usuarios | <a href="usuario/create"><button class="btn btn-success" type="button" name="button">Nuevo</button></a></h3>
      @include('administracion.usuario.search')
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="table-responsive">
        <table class="table table-stripped table-bordered table-condensed table-bordered">
          <thead>
            <th>Id</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Opciones</th>
          </thead>
          @foreach($usuarios as $usr)
          <tr>
            <td>{{$usr->id}}</td>
            <td>{{$usr->name}}</td>
            <td>{{$usr->email}}</td>
            <td>
              <a href="{{URL::action('UsuarioController@edit', $usr->id)}}"><button class="btn btn-info">Editar</button></a>
              <a href="#" data-target="#modal-delete-{{$usr->id}}" data-toggle="modal"><button class="btn btn-danger">Eliminar</button></a>
            </td>
          </tr>
          @include('administracion.usuario.modal')
          @endforeach
        </table>
      </div>
      {{$usuarios->render()}}
      </div>
  </div>
@endsection
