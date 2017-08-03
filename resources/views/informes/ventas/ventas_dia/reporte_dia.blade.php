<head>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
</head>
<div class="row">
  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
    <h3>Reporte de Ventas: {{$fecha_reporte}}</h3>
  </div>
</div>
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="table-responsive">
      <table class="table table-stripped table-bordered table-condensed table-bordered">
        <thead style="background-color: #A9D0F5">
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
        @endforeach
      </table>
    </div>
    </div>
</div>
