#ingreso compras

DELIMITER //
CREATE TRIGGER tr_updStockIngreso AFTER INSERT ON detalle_ingreso
FOR EACH ROW BEGIN
UPDATE articulo SET cantidad = cantidad + NEW.cantidad
WHERE articulo.idarticulo = NEW.idarticulo;
END
//
DELIMITER ;

#ingreso ventas

DELIMITER //
CREATE TRIGGER tr_updStockVenta AFTER INSERT ON detalle_venta
FOR EACH ROW BEGIN
UPDATE articulo SET cantidad = cantidad - NEW.cantidad
WHERE articulo.idarticulo = NEW.idarticulo;
END
//
DELIMITER ;
