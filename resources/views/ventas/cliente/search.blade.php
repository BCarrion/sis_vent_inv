{!!Form::open(array('url'=>'ventas/cliente', 'method'=>'GET','autocomplete'=>'off', 'role'=>'search' ))!!}
<div class="form-group">
  <div class="input-group">
    <input type="text" class="form-control" name="searchText" value="{{$searchText}}" placeholder="Buscar">
    <span class="input-group-btn">
      <button type="submit" class="btn btn-primary">Buscar Categoria</button>
    </span>
  </div>
</div>

{!!Form::close()!!}
