@extends ('layouts.admin')
@section ('contenido')
  <div class="row">
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
      <h3>Listado De Devoluciones | <a href="devolucion/create"><button class="btn btn-success" type="button" name="button">Nuevo</button></a></h3>
      @include('ventas.devolucion.search')
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="table-responsive">
        <table class="table table-stripped table-bordered table-condensed table-bordered">
          <thead>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Comprobante</th>
            <th>Impuesto</th>
            <th>Total</th>
            <th>Estado</th>
            <th>Opciones</th>
          </thead>
          @foreach($devoluciones as $dev)
          <tr>
            <td>{{$dev->fecha_hora}}</td>
            <td>{{$dev->nombre}}</td>
            <td>{{$dev->tipo_comprobante.': '.$dev->num_comprobante}}</td>
            <td>{{$dev->impuesto}}</td>
            <? $devolucion_format=number_format($dev->total_venta) ?>
            <td>$ {{$devolucion_format}}</td>
            <td>{{$dev->estado}}</td>

            <td>
              <a href="{{URL::action('DevolucionController@show', $dev->idventa)}}"><button class="btn btn-info">Detalles</button></a>
              <a href="#" data-target="#modal-delete-{{$dev->idventa}}" data-toggle="modal"><button class="btn btn-danger">Anular</button></a>
            </td>
          </tr>
          @include('ventas.devolucion.modal')
          @endforeach
        </table>
      </div>
      {{$devoluciones->render()}}
      </div>
  </div>
@endsection
