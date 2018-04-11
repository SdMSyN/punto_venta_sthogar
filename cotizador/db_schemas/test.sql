/*Para obtener el usuario en base a la busqueda en la modal */
select * from clientes where concat_ws(' ',nombre,ap,am) like '%Cliente1 hernandez corona%';

