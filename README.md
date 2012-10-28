Datagrid
========

<strong>¿QUE ES UN DATAGRID ?</strong>

Un data grid, que viene a significar en castellano rejilla de datos, es una interfaz de usuario bastante típica, que sirve para visualizar información en una tabla. La información suele ser un conjunto de registros, y se suelen mostrar cada uno de ellos en una fila. Además, los data grid suelen tener integradas funcionalidades para la ordenación de los datos y opciones para su edición o borrado entre muchas mas.

<strong>MODO DE USO</strong>

Primero debemos incluir el archivo donde se encuentra la <strong>clase</strong><br />
{{{
<?php
require_once 'Aco_DataGrid.php'; 
?>
}}}
<br />Ahora seleccionamos la base de datos.

{{{
<?php
// Conexion
$c = mysql_connect('localhost', 'root','');
mysql_select_db('ejemplo', $conexion);
?>
}}}
<br />

Listo, ya tenemos lo basico, ahora si empezemos a usar la *clase* <br />

Ahora hacemos la consulta, y la guardamos en una variable, en este ejemplo yo usare una tabla llamada *productos*

{{{
<?php
$sql = 'select codigo, nombre, pcompra, pventa from productos';
?>
}}}

*NOTE* que cuando tenemos una consulta del tipo SELECT *tabla.campo* debemos indicar el  *alias*

{{{
<?php 
// Ejemplo: Cuando usamos una consulta del tipo tabla.campo
$sql = 'SELECT productos.codigo as codigo ...';
?>
}}}

El siguiente paso seria crear un *array asociativo* donde indicariamos cuales son los campos que el *grid* debe mostrar.

{{{
<?php
// array('nombre_de_la_columna' => 'nombre_campo_bd')

$campos = array('Codigo del producto' => 'codigo',
                'Nombre producto' => 'nombre',
                'Precio de compra' => 'pcompra',
                'Precui de venta' => 'pventa');
?>
}}}

A la izquierda tenemos  *Codigo del producto* que indica el nombre de la columna, y su valor seria el campo *codigo* de la *base de datos*, y de esa manera lo hacemos para el resto de *columnas y campos*.

*NOTE* que si tenemos consultas del tipo *tabla.campo* debemos declarar alias *( as )*, esos *"alias"* son los que usamos en el array *$campos*


===LISTO!!===

Ahora tenemos

{{{
<?php
// Consulta
$sql = 'select codigo, nombre, pcompra, pventa from productos';

// Array que indica nombre de la columna y el dato que se debe mostrar en esa columna
$campos = array('Codigo del producto' => 'codigo',
                'Nombre producto' => 'nombre',
                'Precio de compra' => 'pcompra',
                'Precui de venta' => 'pventa');
?>
}}}

Ahora creamos el objeto de la clase  *Aco_DataGrid* y llamamos al metodo *iniciar*, el cual recibe los siguientes parametros <br /><br />

 La consulta *sql*, ( la tenemos en la variable *$sql* ) <br />
 La conexion con la base de datos, ( si ya esta abierta pasamos como parametro *''* ) <br />
 El siguiente parametro es el nombre de la clase *CSS* ( <table class="ejemplo" ) <br /><br />

Por ultimo llamamos al metodo *gridMostrar* el cual nos mostraria la tabla con la informacion que nosotros quereremos.
{{{
<?php
$grid = new Aco_DataGrid;
$grid->iniciar( $sql, '', $campos, 'productosCSS' );
$grid->gridMostrar();
?>
}}}


==== RESUMEN ==== 

Con menos de *10* lineas de codigo logramos mostrar de forma facil informacion de nuestra base de datos en una tabla. <br /><br />

Si queremos mostrar *mas de un dataGrid en la misma pagina*, creamos *otro objeto* apartir de la clase y le pasamos sus respectivos *parametros.*
{{{
<?php
// Incluimos la clase
require_once 'Aco_DataGrid.php';

// Conectamos a la base de datos
$conexion = mysql_connect('localhost', 'root','');
mysql_select_db('ejemplo', $conexion);

// Consulta
$sql = 'select codigo, nombre, pcompra, pventa from productos';

// Campos seleccionados
$campos = array('Codigo del producto' => 'codigo',
                'Nombre producto' => 'nombre',
                'Precio de compra' => 'pcompra',
                'Precui de venta' => 'pventa');
	
// Objeto de la clase
$grid = new Aco_DataGrid;

// 
$grid->iniciar($sql, '', $campos, 'productosCSS');

// Mostrarmos el grid
$grid->gridMostrar();
?>
}}}

====Resultado====

||Codigo del producto||Nombre del producto||Precio de compra||Precio de venta||
||2252|| Aceite||2500||200||
||2333|| Otro||2500||200||
||2333|| Otro||2500||200||
||2266|| Otro||2500||200||

Podemos observar que el nombre de la columna *Codigo del producto* depende de los valores que hayamos indicado en el *array $campos*, asi mismo para el resto de *columnas*. <br /><br />

= ALGO MAS AVANZADO =


Ahora vamos a realizar algo mas avanzado. <br /> <br />


== PAGINADO ==

Muchas veces tenemos gran cantidad de *registros* en nuestra base de datos y se veria muy mal mostrar todos estos registros de una sola vez, para solucionar esto le vamos a pasar el *metodo iniciar * unos cuantos parametros más.

{{{
<?php
$paginar_resultados = array( 0, 2, 5 );
$grid->iniciar($sql, '', $campos, 'productosCSS', 'nombreGrid', $paginar_resultados);
?>
}}}

===Explicacion===

El array *$paginar_resultados* le pasamos tres valores. <br /><br />
El *0* indica la posicion del paginado.<br />
0 -> Abajo<br />
1 -> Arriba <br />
2 -> Arriba y abajo<br />

El *10* Indica la cantidad de resultados por pagina.<br />
El *5* Indica la cantidad de paginas que veremos en el paginador <br />

De esta forma tendriamos configurador totalmente configurable para nuestro dataGrid<br />

*NOTE* que cuando tenemos mas de un *dataGrid* en nuestra pagina debemos indicar un nombre distinto para cada uno. <br /><br />

Nos daría como resultado algo similar a los siguiente.

||Codigo del producto||Nombre del producto||Precio de compra||Precio de venta||
||2252|| Aceite||2500||200||
||2333|| Otro||2500||200||

*Pagina 1 de 9 1  2  3  4  Siguiente *

== AÑADIR INFORMACION EXTRA A UNA COLUMNA ==

Por lo regular cuando mostramos informacion en una tabla, queremos que los resultados de una *columna en especifico* salga por ejemplo con *enlaces*, que lleven a una pagina distinta. <br />

Tomando el ejemplo de la *tabla* que tenemos en estos momentos, imaginemos que queremos que los datos de la columna *Codigo del producto* tuvieran enlaces.

Cuando *no usamos un dataGrid* lo tenemos que hacer de la siguiente manera.

{{{
<?php
$sql = mysql_query("select codigo, nombre, pcompra, pventa from productos");

echo '<table>';
echo '<tr><td>Ejemplo</td></tr>';
while( $fila = mysql_fetch_array( $sql ) ) {
echo '<tr>';
     echo '<td><a href="index.php?id='. $fila['codigo'] .'">'. $fila['nombre'] .'</a></td>';
echo '</tr>';
}
echo '</table>';
?>
}}}

De esta forma conseguiriamos que los datos de la  columna *Ejemplo* salieran con enlaces pero se puede notar que tiene sierta complejidad hacer esto,  ahora vamos a ver como lo podriamos hacer usando el *dataGrid* <br />

Para eso existe el metodo add_InfoAcampo;

{{{
<?php
// add_InfoAcampo($contenido = '', $camposEscogido = '', $valoresDe = '')

$campos_seleccionados = array('Codigo del producto' => '1', 'Nombre producto' => '2')

$grid->add_InfoAcampo('<a href="index.php?id={1}">{2}</a>', 'Nombre producto', $campos_seleccionados );
?>
}}}

== Explicacion ===

El primer parametro es el *contenido* que aparecera en la columna, podemos ver que usamos llaves  *{}* , estas llaves tambien tienen numeros, seran reemplazadas por el valor que indicamos en el array *$campos_seleccionados.*

El *segundo parametro* indica la columna a la cual le queremos aplicar el cambio, en este caso lo hacemos a *Nombre producto*.

Por *ultimo* indicamos de donde debe *arrastrar la informacion*. que seria el array *$campos_seleccionados*

Daria como resultado algo como esto, logicamente quedaria en la tabla.

{{{
Codigo P     nombre P
2252 <a href="index.php?id=2252">Aceite</a>
2333 <a href="index.php?id=2333">Otro</a>
2333 <a href="index.php?id=2333">Otro</a>
2266 <a href="index.php?id=2266">Otro</a>
}}}
Las llaves *{}* seran reemplazadas dependiendo del tercer parametro.

===Listo!!===

Al usar este *metodo* pudimos entender la *idea general del funcionamiento de la clase*, aqui en adelante el funcionamiento de los siguientes metodos es *mas o menos igual* al que acabamos de *ver*.

= Añadir columnas antes y despues de... =

Por lo regular necesitamos colocar *una columna* antes de *otra columna*, por ejemplo poner una columna llamada *editar* antes de *Codigo del producto*

{{{
// add_ColumnaAntesDe( $contenido, $campoEscogido, $antesDe, $titulo )

$grid->add_ColumnaAntesDe('hola')

}}}

===Estoy trabajando para completar el tutorial.===