@extends ('layouts.admin')
@section ('contenido')
<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <h3>Nueva Venta</h3>
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

{!!Form::open(array('url'=>'ventas/venta', 'method'=>'POST', 'autocomplete'=>'off'))!!}
{!!Form::token()!!}
<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <div class="form-group">
      <label for="cliente">Cliente</label>
      <select class="form-control selectpicker" name="idcliente" id="idcliente" data-live-search="true">
        @foreach($personas as $persona)
          <option value="{{$persona->idpersona}}">{{$persona->nombre}}</option>
        @endforeach()
      </select>
    </div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <div class="form-group">
      <label>Tipo Comprobante</label>
      <select class="form-control" name="tipo_comprobante">
        <option value="remision">Remisión</option>
        <option value="factura">Factura</option>
      </select>
    </div>
  </div>
</div>
<div class="row">
  <div class="panel panel-primary">
    <div class="panel-body">
      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
          <label>Articulo</label>
          <select class="form-control selectpicker" name="pidarticulo" id="pidarticulo" data-live-search="true">
              <option selected="selected">Seleccione un producto</option>
            @foreach($articulos as $articulo)
              <option value="{{$articulo->idarticulo}}_{{$articulo->cantidad}}_{{$articulo->precio_promedio}}">{{$articulo->articulo}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
        <div class="form-group">
          <label for="cantidad">Cantidad</label>
          <input type="number" min="1" name="pcantidad" id="pcantidad" class="form-control" placeholder="Cantidad...">
        </div>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
        <div class="form-group">
          <label for="disponible">Disponible</label>
          <input disabled type="number" name="pdisponible" id="pdisponible" class="form-control" placeholder="Disponible...">
        </div>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
        <div class="form-group">
          <label for="precio_venta">Precio Venta</label>
          <input disabled type="number" name="pprecio_venta" id="pprecio_venta" class="form-control" placeholder="Precio Venta...">
        </div>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
        <div class="form-group">
          <label for="descuento">Descuento</label>
          <input type="number" min="0" name="pdescuento" id="pdescuento" class="form-control" placeholder="Descuento...">
        </div>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
        <div class="form-group">
          <br>
          <button type="button" id="btn_add" class="btn btn-primary">Agregar</button>
        </div>
      </div>
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <table id="detalles" class="table table-stripped table-bordered table-condensed table-hover">
          <thead style="background-color: #A9D0F5">
            <th>Opciones</th>
            <th>Articulo</th>
            <th>Cantidad</th>
            <th>Precio Venta</th>
            <th>Descuento</th>
            <th>Subtotal</th>
          </thead>

          <tfoot>
            <th>Total</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th><h4 id="total">$ 0.00</h4><input type="hidden" name="total_venta" id="total_venta"></th>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="opciones">
    <div class="form-group">
      <input name="_token" value="{{csrf_token()}}" type="hidden"></input>
      <button type="submit" class="btn btn-primary">Guardar</button>
      <button type="reset" class="btn btn-danger">Cancelar</button>
    </div>
  </div>
</div>
  {!!Form::close()!!}

@push('scripts')
<script>

  $(document).ready(function(){
    $('#btn_add').click(function(){
      agregar();
    });
  });

  var cont=0;
  total=0;
  subtotal=[];
  $('#guardar').hide();
  $('#pidarticulo').change(mostrarValores);

  function mostrarValores()
  {
    datosArticulo=document.getElementById('pidarticulo').value.split('_');
    console.log(datosArticulo[2]);
    precio_entero=Math.round(datosArticulo[2]);
    $('#pprecio_venta').val(precio_entero);
    $('#pdisponible').val(datosArticulo[1]);
  }

  function agregar()
  {
    datosArticulo=document.getElementById('pidarticulo').value.split('_');

    idarticulo=datosArticulo[0];
    articulo=$('#pidarticulo option:selected').text();
    cantidad=$('#pcantidad').val();
    descuento=$('#pdescuento').val();
    if(descuento=='')
    {
      descuento=0;
    }

    precio_venta=$('#pprecio_venta').val();
    precio_venta_format=new Intl.NumberFormat().format(precio_venta);
    disponible=$('#pdisponible').val();

    if (idarticulo!="" && cantidad!="" && cantidad>0 && precio_venta!="" && disponible>=cantidad)
    {
      if(disponible>=cantidad)
      {
        subtotal[cont]=(cantidad*precio_venta-descuento);
        sub_format=new Intl.NumberFormat().format(subtotal[cont]);
        total=total+subtotal[cont];
        total_format=new Intl.NumberFormat().format(total);

        var fila='<tr class="selected" id="fila'+cont+'"> <td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+');">X</button></td> <td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td> <td><input type="hidden" name="cantidad[]" value="'+cantidad+'">'+cantidad+'</td> <td><input type="hidden" name="precio_venta[]" value="'+precio_venta+'">$ '+precio_venta_format+'</td><td><input type="hidden" name="descuento[]" value="'+descuento+'">$ '+descuento+'</td> <td>$ '+sub_format+'</td></tr>';

        cont++;
        limpiar();
        $("#total").html("$ "+ total_format);
        $("#total_venta").val(total);
        evaluar();
        $('#detalles').append(fila);
      }

      else
      {
        alert("La cantidad a vender supera la cantidad disponible");
      }

    }
    else
    {
        alert("Error al ingresar el detalle de la venta, revise los datos del articulo");
    }
  }

  function limpiar()
  {
    $("#pcantidad").val("");
    $("#pdescuento").val("");
    $("#pprecio_venta").val("");
  }

  function evaluar()
  {
      if(total>0)
      {
        $("#opciones").show;
      }
      else
      {
        $("#opciones").hide;
      }
  }

  function eliminar(index)
  {
      total=total-subtotal[index];
      $('#total').html("$ "+total);
      $('#total_venta').val(total);
      $('#fila'+index).remove();
      evaluar();
  }

</script>
@endpush

@endsection
