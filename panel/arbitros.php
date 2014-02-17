<?php

include("../inc/conn.php");

verificar();

$sql = "";
$msg = "";
$idarbitro = "";
$arbitro = "";
$registros = "";

if(isset($_POST['grabar']))
{
	if(isset($_POST['accion']))
	{
		if($_POST['accion'] == "insertar")$sql = "insert into arbitros(arbitro) values ('".$_POST['arbitro']."')";
		elseif($_POST['accion'] == "modificar")$sql = "UPDATE arbitros SET arbitro = '".$_POST['arbitro']."' WHERE idarbitro = ".$_POST['idarbitro'];		
	}
}
elseif(isset($_GET['eliminar']))$sql = "delete from arbitros where idarbitro = ".$_GET['id'];

if($sql!="")
{
	$resultado = mysql_query($sql);
	if (!$resultado)$msg = "Error al intentar realizar la operacion";
	else $msg = "Operacion realizada con exito";
}

$accion = "insertar";

if(isset($_GET['modificar']))
{
	$sql = "SELECT idarbitro,arbitro FROM arbitros WHERE idarbitro = ".$_GET['id'];
	$resultado = mysql_query($sql, $enlace);	
	$fila = mysql_fetch_object($resultado);
	$idarbitro = $fila->idarbitro;
	$arbitro = 	$fila->arbitro;
	$accion = "modificar";			
}

$sql = "SELECT idarbitro,arbitro FROM arbitros ORDER BY idarbitro";
$resultado = mysql_query($sql, $enlace);
$count = mysql_num_rows($resultado);

if($count > 0)
{
	while ($fila = mysql_fetch_object($resultado)) 
	{										
	    $registros.= "<tr><td>".$fila->idarbitro."</td><td>".$fila->arbitro."</td>
	    <td><a href='arbitros.php?modificar&id=".$fila->idarbitro."'>Modificar</a></td>
	    <td><a href='arbitros.php?eliminar&id=".$fila->idarbitro."'>Eliminar</a></td>
	    </tr>";					  
	}
	mysql_free_result($resultado);
}else $registros = "";
		

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Torneo de F&uacute;tbol</title>
<link href="../css/estilo.css" rel="stylesheet" type="text/css"></link>
</head>
<body>		
<?php menuHeader();?>
	<div id="section">
		<div id="formulario">                           
			<form name="abm" method="POST" action="arbitros.php">
				<!--<h1>Torneo de F&uacute;tbol</h1>-->
				<h2>Carga de Arbitros</h2>	
				<BR>
				<div id="msg"><?php print $msg;?></div>
				<br>
				<input type="hidden" id="accion" name="accion" value="<?php print $accion;?>">			
				<input type="hidden" id="idarbitro" name="idarbitro" value="<?php print $idarbitro;?>">
				<label for="arbitro">Arbitro:</label>
				<input type="text" id="arbitro" name="arbitro" value="<?php print $arbitro;?>">
	    		<BR><BR>
	    		<input type="submit" name="grabar" value="Grabar">
	    		<input type="submit" name="cancelar" value="Cancelar">                                     
			</form>                                         
		</div>
		<div id="listado">
			<table>
				<tr>
					<th colspan="10">
						Arbitros cargados	
					</th>
				</tr>
				<tr>
					<th>ID</th>	
					<th>Nombre Completo</th>
				</tr>
				<?php print $registros;?>					
			</table>
		</div>
	</div>
<?php footer();?>
</body>
</html>