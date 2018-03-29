ALTER TABLE `productos` ADD `precio_cotizador` FLOAT(8,2) NOT NULL AFTER `precio`;

ALTER TABLE `productos` ADD `pdf` VARCHAR(100) NOT NULL AFTER `img`;

/*26/10/2017*/
ALTER TABLE `usuarios` ADD `rfc` VARCHAR(13) NOT NULL AFTER `perfil_id`;

/*03/11/2017*/
ALTER TABLE `cotizador` DROP `ap`, DROP `am`, DROP `calle`, DROP `numero`, DROP `colonia`, DROP `municipio`, DROP `estado`, DROP `celular`;
ALTER TABLE `cotizador` CHANGE `nombre` `nombre` VARCHAR(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE `cotizador` ADD `direccion` VARCHAR(200) NULL AFTER `nombre`;
ALTER TABLE `cotizador` DROP `correo`, DROP `rfc`;