/*Modificación de tabla para campo franquicia 1=si, 0=no */
ALTER TABLE `clientes` ADD `franq` INT NOT NULL AFTER `actualizado`;

/*Modificación tabla ventas_info */
ALTER TABLE `ventas_info` ADD `descuento` INT NOT NULL AFTER `cambio`, 
ADD `total_desc` FLOAT NOT NULL AFTER `descuento`, ADD `cant_desc` FLOAT NOT NULL AFTER `total_desc`, 
ADD `cambio_desc` FLOAT NOT NULL AFTER `cant_desc`;