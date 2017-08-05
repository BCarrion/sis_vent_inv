<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" type="text/css" href="css/reporte.css">
    <title>Reporte de Inventario</title>
  </head>
  <body>
  <h3>Inventario De Articulos</h3>

      <table id="customers">
      <tr>
          <th>Id</th>
          <th>Articulo</th>
          <th>Código</th>
          <th>Categoría</th>
          <th>Disponible</th>
          <th>Estado</th>
      </tr>
        <tbody>
        @foreach($articulos as $art)
        <tr>
          <td>{{$art->idarticulo}}</td>
          <td>{{$art->nombre}}</td>
          <td>{{$art->codigo}}</td>
          <td>{{$art->categoria}}</td>
          <td>{{$art->cantidad}}</td>
          <td>{{$art->estado}}</td>
        </tr>
        @endforeach
        </tbody>
      </table>
</body>
</html>
