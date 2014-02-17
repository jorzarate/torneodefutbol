<?php

include("../inc/conn.php");

verificar();

$sql = $msg = $idjugador = $idarbitro = $arbitro = $registros = $combozona = $idzona = $idequipo = $equipo = $goles = $comboequipo = $jugador = $nro = $tabla = "";
$equipo_ant = "";
$tablajugadores = "";

$archivopost = "jugadores.php";

if(isset($_POST['grabar']))
{
	if(isset($_POST['accion']))
	{
		if($_POST['accion'] == "insertar")$sql = "insert into jugadores(idequipo,jugador,nro,goles) values ('".$_POST['idequipo']."','".$_POST['jugador']."','".$_POST['nro']."','".$_POST['goles']."')";
		elseif($_POST['accion'] == "modificar")$sql = "UPDATE jugadores SET idequipo = '".$_POST['idequipo']."', jugador = '".$_POST['jugador']."', goles = '".$_POST['goles']."' WHERE idjugador = ".$_POST['idjugador'];		
	}
}
elseif(isset($_GET['eliminar']))$sql = "delete from jugadores where idjugador = ".$_GET['id'];

if($sql!="")
{
	$resultado = mysql_query($sql);
	if (!$resultado)$msg = "Error al intentar realizar la operacion";
	else $msg = "Operacion realizada con exito";
}

$accion = "insertar";

if(isset($_GET['modificar']))
{
	$sql = "SELECT idjugador,idequipo,jugador,nro,goles FROM jugadores WHERE idjugador = ".$_GET['id'];
	$resultado = mysql_query($sql, $enlace);	
	$fila = mysql_fetch_object($resultado);
	$idjugador = $fila->idjugador;
	$idequipo = $fila->idequipo;
	$jugador = $fila->jugador;
	$nro = $fila->nro;
	$goles = $fila->goles;
	$accion = "modificar";			
}

$sql = "SELECT j.idjugador,e.idequipo,e.equipo,j.jugador,j.nro,j.goles FROM jugadores j, equipos e WHERE e.idequipo = j.idequipo ORDER BY j.goles desc, e.idequipo, j.nro";
$resultado = mysql_query($sql, $enlace);
$count = mysql_num_rows($resultado);

$tabla.= "<div id='listado'><table class='tablas' id='tabla'><thead><tr>";

if(!isset($_POST['publicar']))$tabla.= "<th>Equipo</th><th>Jugador</th>";
else $tabla.= "<th>#</th><th>Jugador</th>";

if(!isset($_POST['publicar']))$tabla.= "<th>Numero</th>";
$tabla.= "<th>Goles</th>";
if(!isset($_POST['publicar']))$tabla.= "<th></th><th></th>";
$tabla.= "</tr></thead>";

if($count > 0)
{
	$c=0;
	while ($fila = mysql_fetch_object($resultado)) 
	{								
		$c++;				
	    $tabla.= "<tbody><tr>";
	    if(isset($_POST['publicar']))
	    {
	    	$tabla.= "<td align='center'>".$c."</td><td>".$fila->jugador." (".$fila->equipo.")</td>";
	    }
	    else $tabla.= "<td>".$fila->equipo."</td><td>".$fila->jugador."</td>";
	    if(!isset($_POST['publicar']))$tabla.= "<td align='center'>".$fila->nro."</td>";
	    $tabla.= "<td align='center'>".$fila->goles."</td>";
	    if(!isset($_POST['publicar']))$tabla.= "<td><a href='".$archivopost."?modificar&id=".$fila->idjugador."'>Modificar</a></td><td><a href='".$archivopost."?eliminar&id=".$fila->idjugador."'>Eliminar</a></td>";
	    $tabla.= "</tr></tbody>";					  
	}	
}

$tabla.="</table></div><div class='espacio'></div>";

// Combo Equipo
$sql = "SELECT idequipo,idzona,equipo FROM equipos order by idequipo";
$resultado = mysql_query($sql, $enlace);
$comboequipo = "<select id='idequipo' name='idequipo'>";
$comboequipo.="<option value =''></option>";
if(!isset($_GET['modificar']))
{
	while ($fila = mysql_fetch_object($resultado)) 
	{										
    	$comboequipo.="<option value ='".$fila->idequipo."'>".$fila->equipo."</option>";				  
	}
}
else 
{
	while ($fila = mysql_fetch_object($resultado)) 
	{
		if($fila->idequipo == $idequipo)$selected = " selected";
		else $selected = "";
    	$comboequipo.="<option value ='".$fila->idequipo."' ".$selected.">".$fila->equipo."</option>";				  
	}	
}
$comboequipo.= "</select>";


if(isset($_POST['publicar']) && isset($_POST['id']) && $_POST['id'] == 3)
{

	// Jugadores por equipo
	$sql = "SELECT j.idjugador,e.idequipo,e.equipo,j.jugador,j.nro,j.goles FROM jugadores j, equipos e WHERE e.idequipo = j.idequipo ORDER BY e.equipo";
	$resultado = mysql_query($sql, $enlace);
	$count = mysql_num_rows($resultado);
	if($count > 0)
	{
		while ($fila = mysql_fetch_object($resultado)) 
		{								
			if($equipo_ant != $fila->idequipo)$tablajugadores.= "<div id='listado'><table><thead><div class='espacio'></div><tr><th colspan='3'>$fila->equipo</th></tr><tr><th>#</th><th>Jugador</th><th>Goles</th></thead>";
			$tablajugadores.= "<tbody><tr><td align='center'>".$fila->nro."</td><td>".$fila->jugador."</td><td align='center'>".$fila->goles."</td></tr></tbody>";
			$equipo_ant = $fila->idequipo;
		}	
	}
	$tablajugadores.= "</table></div>";
		
	$msg = (publicar($_POST['id'],$tablajugadores))?"Contenido publicado con exito":"Error al intentar publicar";
}
elseif(isset($_POST['publicar']) && isset($_POST['id']) && $_POST['id'] == 7)$msg = (publicar($_POST['id'],$tabla))?"Contenido publicado con exito":"Error al intentar publicar";
else $msg = "";

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
				<h2>Carga de Jugadores</h2>	
				<BR>
				<div id="msg"><?php print $msg;?></div>
				<br>
				<input type="hidden" id="accion" name="accion" value="<?php print $accion;?>">			
				<input type="hidden" id="idjugador" name="idjugador" value="<?php print $idjugador;?>">
				<label for="idequipo">Equipo:</label>
				<?php print $comboequipo;?>
				<label for="idzona">Jugador:</label>
				<input type="text" id="jugador" name="jugador" value="<?php print $jugador;?>">
				<label for="nro">Nro.:<br>[Nro. 0: Entrenador]</label>
				<input type="text" id="nro" name="nro" value="<?php print $nro;?>">	    					
	    		<br><br>
				<label for="goles">Goles:</label>
				<input type="text" size='2' id="goles" name="goles" value="<?php print $goles;?>">	    					    		
				<BR><BR>
				<h3>	    		
		    		<input type="submit" name="grabar" value="Grabar">
		    		<input type="submit" name="cancelar" value="Cancelar">                                     
				</h3>
		   </form>                                         
		</div>
		<div class="espacio"></div>
		<div id="listado"><?php print $tabla;?></div>
	</div>
	<div class="espacio"></div>
	<form name='frmPublicar' method="POST" action="<?php print $archivopost;?>">
		<input type='hidden' name='id' value='7'>
		<h3><input type="submit" name="publicar" value="Publicar Goleadores"></h3>
	</form>	
	<div class="espacio"></div>
	<form name='frmPublicar' method="POST" action="<?php print $archivopost;?>">
		<input type='hidden' name='id' value='3'>
		<h3><input type="submit" name="publicar" value="Publicar Jugadores"></h3>
	</form>	
<?php footer();?>
</body>
</html>