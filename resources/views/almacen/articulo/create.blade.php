@extends ('layouts.admin')
@section ('contenido')
<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <h3>Nueva Articulo</h3>
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

{!!Form::open(array('url'=>'almacen/articulo', 'method'=>'POST', 'autocomplete'=>'off', 'files'=>'true'))!!}
{!!Form::token()!!}
<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <div class="form-group">
      <label for="nombre">Nombre</label>
      <input type="text" name="nombre" required value="{{old('nombre')}}" class="form-control" placeholder="Nombre...">
    </div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <div class="form-group">
      <label>Categoria</label>
      <select class="form-control" name="idcategoria">
        @foreach ($categorias as $cat)
        <option value="{{$cat->idcategoria}}">{{$cat->nombre}}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <div class="form-group">
      <label for="nombre">Código</label>
      <input type="text" name="codigo" required value="{{old('categoria')}}" class="form-control" placeholder="Codigo del articulo...">
    </div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <div class="form-group">
      <label for="cantidad">Disponible</label>
      <input type="text" name="cantidad" required value="{{old('cantidad')}}" class="form-control" placeholder="Disponible del articulo...">
    </div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <div class="form-group">
      <label for="descripcion">Descripción</label>
      <input type="text" name="descripcion" value="{{old('descripcion')}}" class="form-control" placeholder="Descripción del articulo...">
    </div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <div class="form-group">
      <label for="imagen">Imágen</label>
      <input type="file" name="imagen" class="form-control">
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
