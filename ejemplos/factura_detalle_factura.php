<?php
/* El objetivo del ejemplo es demostrar como por medio de un DataGrid podemos cargar informacion
   en otro DataGrid */

// Generamos la conexion a la base de datos.
$c = mysql_connect('localhost', 'root', '') or die('No fue posible conectar a la base de datos');
mysql_select_db('datagrid', $c);

// Importamos la clase que generara el Grid y provee de los metodos.
require_once '../Aco_DataGrid.php'; 

// Indicamos la consulta Sql que desemos mostrar en el Grid,
// para nuestro caso es la siguiente.
$sql_facturas = 'SELECT id,consecutivo,fecha,observacion FROM facturas';
// Si la consulta tiene varios debemos indicar el alias por ejemplo
// SELECT tabla.campo as alias

$campos = array('ID' => 'id',
				'Consecutivo' => 'consecutivo',
				'Fecha' => 'fecha',
				'Observacion' => 'observacion');


// Instancia del datagrid
$grid = new Aco_DataGrid;
// Parametros de inicio
// grid_facturas -> Indica el nombre del datagrid, con esto es posible usar multiples grids.
$grid->iniciar($sql_facturas, '', $campos, '', array(1, 6, 2), 'grid_facturas');

// Agregamos un boton al final llamado 'Detalle'
// Como el grid puede tener varias facturas, entonces por medio del metodo add_ColumnaDespuesDe podemos agregar un link por cada factura
// Los parametros son 
// El contenido del link o boton,   '<a href="index.php?factura=&&">Detalle</a>' Los && indican que por cada link o boton que agregue, tome la informacion desde el campo escogido
// El campos Escogido en este caso el 'ID'
// El siguiente parametro es despues de que campo lo queremos agregar en nuestro caso despues de la Columna 'Observacion'
// Luego indicamos el titulo de la nueva columna.
$grid->add_ColumnaDespuesDe('<a href="factura_detalle_factura.php?factura_id=&&">Detalle</a>', 'ID', 'Observacion', 'Detalle Factura');

// Renderiza el datagrid
$grid->gridMostrar();



// Procedemos a crear el grid del detalle de la factura.


if( ! isset( $_GET['factura_id'] ) ){
	exit;
}


$sql_detalle_facturas = 'SELECT id,producto,valor,factura_id FROM factura_detalles where factura_id = ' . $_GET['factura_id'];

// Si la consulta tiene varios debemos indicar el alias por ejemplo
// SELECT tabla.campo as alias

$campos_detalle_facturas = array('ID' => 'id',
								'Producto' => 'producto',
								'Valor' => 'valor',
								'Factura' => 'factura_id');

// Instancia del datagrid
$grid_detalle_facturas = new Aco_DataGrid;
$grid_detalle_facturas->iniciar($sql_detalle_facturas, '', $campos_detalle_facturas, '', array(1, 6, 2), 'grid_detalle_facturas');
$grid_detalle_facturas->gridMostrar();


?>