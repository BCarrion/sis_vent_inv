{!!Form::open(array('url'=>'informes/ventas/ventas_general', 'method'=>'GET','autocomplete'=>'off', 'role'=>'search' ))!!}
<div class="form-group">
  <div class="input-group">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
      <label for="fecha_inicio">Fecha Inicio</label>
      <input type="date" class="form-control" name="searchText" value="{{$searchText}}" placeholder="Buscar">
      <span class="input-group-btn">
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
      <label for="fecha_final">Fecha Fin</label>
      <input type="date" class="form-control" name="searchText" value="{{$searchText}}" placeholder="Buscar">
      <span class="input-group-btn">
    </div>
    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
      <label for="">&nbsp;</label>
      <button type="submit" class="btn btn-primary">Buscar Categoria</button>
    </div>
    </span>
  </div>
</div>
{!!Form::close()!!}
