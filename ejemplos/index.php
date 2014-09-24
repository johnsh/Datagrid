<?php
// Generamos la conexion a la base de datos.
$c = mysql_connect('localhost', 'root', '') or die('No fue posible conectar a la base de datos');
mysql_select_db('datagrid', $c);

// Importamos la clase que generara el Grid y provee de los metodos.
require_once '../Aco_DataGrid.php'; 

// Indicamos la consulta Sql que desemos mostrar en el Grid,
// para nuestro caso es la siguiente.
$sql = 'SELECT id,consecutivo,fecha,observacion FROM facturas';
// Si la consulta tiene varios debemos indicar el alias por ejemplo
// SELECT tabla.campo as alias

$campos = array('ID' => 'id',
				'Consecutivo' => 'consecutivo',
				'Fecha' => 'fecha',
				'Observacion' => 'observacion');


$grid = new Aco_DataGrid;
$grid->iniciar($sql, '', $campos, '', array(1, 6, 2));
$grid->gridMostrar();


?>