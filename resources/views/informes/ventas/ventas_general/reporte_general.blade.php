<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" type="text/css" href="css/reporte.css">
    <title>Ventas Generales</title>
  </head>
  <body>
          <h3>Reporte de Ventas: </h3>
          <table id="customers">
            <?
            $cont=1;
            $gran_total=0;
            ?>
              <tr>
              <th>No.</th>
              <th>Fecha</th>
              <th>Cliente</th>
              <th>Comprobante</th>
              <th>Impuesto</th>
              <th>Total</th>
            </tr>
            <tbody>
            @foreach($ventas as $ven)
            <tr>
              <td>{{$cont}} </td>
              <td>{{$ven->fecha_hora}}</td>
              <td>{{$ven->nombre}}</td>
              <td>{{$ven->tipo_comprobante.': '.$ven->serie_comprobante.'-'.$ven->num_comprobante}}</td>
              <td>{{$ven->impuesto}}</td>
              <td>{{$ven->total_venta}}</td>
            </tr>
            <?
            $gran_total=$gran_total+$ven->total_venta;
            $cont++ ;
            ?>
            @endforeach
            <?
             $gran_total= number_format($gran_total);
            ?>
            </tbody>
          </table>
          <br>
          <div class="row">
              <div class="col-12">
              <h2>Total ventas $ {{$gran_total}}</h2>
              </div>
          </div>
  </body>
