@extends ('layouts.admin')
@section ('contenido')
  <div class="row">
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
      <h3>Listado de ventas| <a href="{{URL::action('VentasGeneralController@reporteGeneral', ['download'=>'pdf'])}}"><button class="btn btn-success" type="button" name="button">Descargar</button></a></h3>
      @include('informes.ventas.ventas_general.search')
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
          </thead>
          @foreach($ventas as $ven)
          <tr>
            <td>{{$ven->fecha_hora}}</td>
            <td>{{$ven->nombre}}</td>
            <td>{{$ven->tipo_comprobante.': '.$ven->serie_comprobante.'-'.$ven->num_comprobante}}</td>
            <td>{{$ven->impuesto}}</td>
            <td>{{$ven->total_venta}}</td>
            <td>{{$ven->estado}}</td>
          </tr>
          @include('ventas.venta.modal')
          @endforeach
        </table>
      </div>
      {{$ventas->render()}}
      </div>
  </div>
@endsection
