<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title> </title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style media="screen">
      tbody
      {
          width: 800%;
          height: 100%;
          background-color: red;
      }
    </style>
  </head>
  <body>
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <h3>Reporte de Ventas: {{$fecha_reporte}}</h3>
        </div>
      </div>

    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

          <table class="table table-stripped table-bordered table-condensed table-bordered">
            <thead>
              <th>Fecha</th>
              <th>Cliente</th>
              <th>Comprobante</th>
              <th>Impuesto</th>
              <th>Total</th>
              <th>Estado</th>
            </thead>
            <tbody>
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
            </tbody>
          </table>
          </div>
        </div>
</div>
</div>

  </body>
