<?php

include("../inc/conn.php");

verificar();

$sql = "";
$msg = "";
$idarbitro = "";
$arbitro = "";
$registros = "";
$combozona = "";
$idzona = "";
$idequipo = "";
$equipo = "";
$tabla = "";

$zona1=$zona2=$zona3=$zona4=Array();

$archivopost = "equipos.php";

if(isset($_POST['grabar']))
{
	if(isset($_POST['accion']))
	{
		if($_POST['accion'] == "insertar")$sql = "insert into equipos(idequipo,idzona,equipo) values ('".$_POST['idequipo']."','".$_POST['idzona']."','".$_POST['equipo']."')";
		elseif($_POST['accion'] == "modificar")$sql = "UPDATE equipos SET idzona = '".$_POST['idzona']."', equipo = '".$_POST['equipo']."' WHERE idequipo = ".$_POST['idequipo'];		
	}
}
elseif(isset($_GET['eliminar']))$sql = "delete from equipos where idequipo = ".$_GET['id'];

if($sql!="")
{
	$resultado = mysql_query($sql);
	if (!$resultado)$msg = "Error al intentar realizar la operacion";
	else $msg = "Operacion realizada con exito";
}

$accion = "insertar";

if(isset($_GET['modificar']))
{
	$sql = "SELECT idequipo,idzona,equipo FROM equipos WHERE idequipo = ".$_GET['id'];
	$resultado = mysql_query($sql, $enlace);	
	$fila = mysql_fetch_object($resultado);
	$idequipo = $fila->idequipo;
	$idzona = 	$fila->idzona;
	$equipo = $fila->equipo;
	$accion = "modificar";			
}

$sql = "SELECT e.idequipo,e.idzona,z.idzona,z.zona,e.equipo FROM equipos e, zonas z WHERE e.idzona = z.idzona ORDER BY e.idequipo";
$resultado = mysql_query($sql, $enlace);
$count = mysql_num_rows($resultado);

if($count > 0)
{
	while ($fila = mysql_fetch_object($resultado)) 
	{										
	    $registros.= "<tr><td>".$fila->zona."</td><td>".$fila->equipo."</td>
	    <td><a href='equipos.php?modificar&id=".$fila->idequipo."'>Modificar</a></td>
	    <td><a href='equipos.php?eliminar&id=".$fila->idequipo."'>Eliminar</a></td>
	    </tr>";					  
	}	
}else $registros = "";

// Combo Zona
$sql = "SELECT idzona,zona FROM zonas ORDER BY idzona";
$resultado = mysql_query($sql, $enlace);
$combozona = "<select id='zona' name='idzona'>";
$combozona.="<option value =''></option>";
if(!isset($_GET['modificar']))
{
	while ($fila = mysql_fetch_object($resultado)) 
	{										
    	$combozona.="<option value ='".$fila->idzona."'>".$fila->zona."</option>";				  
	}
}
else 
{
	while ($fila = mysql_fetch_object($resultado)) 
	{
		if($fila->idzona == $idzona)$selected = " selected";
		else $selected = "";
    	$combozona.="<option value ='".$fila->idzona."' ".$selected.">".$fila->zona."</option>";				  
	}	
}
$combozona.= "</select>";

if(isset($_POST['publicar']))
{
	for($i=1;$i<=4;$i++)
	{
		$sql = "SELECT e.idequipo,e.idzona,z.idzona,z.zona,e.equipo FROM equipos e, zonas z WHERE e.idzona = z.idzona and e.idzona = ".$i." ORDER BY e.idzona, e.idequipo";
		$resultado = mysql_query($sql, $enlace);
		$count = mysql_num_rows($resultado);

		if($count > 0)
		{	
			$c = 0;
			while ($fila = mysql_fetch_object($resultado)) 
			{
				if($fila->idzona == 1)$zona1[$c] = $fila->equipo;
				elseif($fila->idzona == 2)$zona2[$c] = $fila->equipo;
				elseif($fila->idzona == 3)$zona3[$c] = $fila->equipo;
				elseif($fila->idzona == 4)$zona4[$c] = $fila->equipo;
				else $zona = "";
				$c++;					  
			}	
		}
		else 
		{
			$msg = "No se encontraron datos para publicar";
		}

		
		
		/*
		$tablaGeneral = "<table class='tablas' id='tabla'>
		<thead>
		
		</thead>";
		*/
	}
	
	$tabla.="<div id='listado'><table class='tablas' id='tabla'><thead><tr><th>ZONA A</th><th>ZONA B</th><th>ZONA C</th><th>ZONA D</th></tr><thead><tbody>";
	
	for($i=0;$i<count($zona1);$i++)
	{
		$tabla.="<tr><td>".@$zona1[$i]."</td><td>".@$zona2[$i]."</td><td>".@$zona3[$i]."</td><td>".@$zona4[$i]."</td></tr>";		
	}
	
	$tabla.="</tbody></table></div><div class='espacio'></div>";	
	
	
	
	$msg = (publicar(2,$tabla))?"Contenido publicado con exito":"Error al intentar publicar";			

}


mysql_free_result($resultado);
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
			<form name="abm" method="POST" action="<?php print $archivopost;?>">
				<!--<h1>Torneo de F&uacute;tbol</h1>-->
				<h2>Carga de Equipos</h2>	
				<BR>
				<div id="msg"><?php print $msg;?></div>
				<br>
				<input type="hidden" id="accion" name="accion" value="<?php print $accion;?>">			
				<input type="hidden" id="idequipo" name="idequipo" value="<?php print $idequipo;?>">
				<label for="arbitro">Equipo:</label>
				<input type="text" id="equipo" name="equipo" value="<?php print $equipo;?>">
	    		<label for="idzona">Zona:</label>
				<?php print $combozona?>
	    		<BR><BR>
	    		<h3>	    		
		    		<input type="submit" name="grabar" value="Grabar">
		    		<input type="submit" name="cancelar" value="Cancelar">                                     
				</h3>
		    </form>                                         
		</div>
		<div class="espacio"></div>
		<div id="listado">
			<table>
				<tr>
					<th colspan="10">
						Equipos cargados	
					</th>
				</tr>
				<tr>
					<th>Zona</th>
					<th>Equipo</th>
					<th></th>
					<th></th>
				</tr>
				<?php print $registros;?>					
			</table>
		</div>
	</div>
	<div id="espacio"></div>
	<form name='frmPublicar' method="POST" action="<?php print $archivopost;?>">
		<h3><input type="submit" name="publicar" value="Publicar Equipos"></h3>
	</form>	
<?php footer();?>
</body>
</html>