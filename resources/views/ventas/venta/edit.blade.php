@extends ('layouts.admin')
@section ('contenido')
  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <h3>Editar Proveedor: {{$persona->nombre}}</h3>
      @if(count($errors)>0)
      <div class="alert alert-danger">
        <ul>
          @foreach($errors->all() as $error)
          <li>{{$error}}</li>

          @endforeach
        </ul>
        </div>
        @endif
      </div>
    </div>

      {!!Form::model($persona, ['method'=>'PATCH', 'route'=>['proveedor.update', $persona->idpersona]])!!}
      {!!Form::token()!!}
      <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" required value="{{$persona->nombre}}" class="form-control">
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="form-group">
            <label for="apellidos">Apellidos</label>
            <input type="text" name="apellidos" value="{{$persona->apellidos}}" class="form-control">
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="form-group">
            <label for="direccion">Dirección</label>
            <input type="text" name="direccion" value="{{$persona->direccion}}" class="form-control">
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="form-group">
            <label>Documento</label>
            <select class="form-control" name="tipo_documento">
              @if($persona->tipo_documento=='CC')
              <option value="CC" selected>CC</option>
              <option value="CE">CE</option>
              <option value="NIT">NIT</option>
              @elseif($persona->tipo_documento=='CE')
              <option value="CC">CC</option>
              <option value="CE" selected>CE</option>
              <option value="NIT">NIT</option>
              @else
              <option value="CC">CC</option>
              <option value="CE">CE</option>
              <option value="NIT" selected>NIT</option>
              @endif
            </select>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="form-group">
            <label for="num_documento">Número Documento</label>
            <input type="text" name="num_documento" required value="{{$persona->num_documento}}" class="form-control">
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" name="telefono" value="{{$persona->telefono}}" class="form-control">
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="form-group">
            <label for="correo">Email</label>
            <input type="text" name="correo" value="{{$persona->correo}}" class="form-control">
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <button type="reset" class="btn btn-danger">Cancelar</button>
          </div>
        </div>
      </div>
      {!!Form::close()!!}

@endsection
