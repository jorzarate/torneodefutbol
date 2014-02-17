<?php

include("conn.php");

for($i=1;$i<=4;$i++)
{
	if($i==1)$zona="ZONA A";
	elseif($i==2)$zona="ZONA B";
	elseif($i==3)$zona="ZONA C";
	elseif($i==4)$zona="ZONA D";
	else $zona = "";

	$sql = "SELECT e.idequipo,e.idzona,z.idzona,z.zona,e.equipo FROM equipos e, zonas z WHERE e.idzona = z.idzona and e.idzona = '".$i."' ORDER BY e.idequipo";
	$resultado = mysql_query($sql, $enlace);
	$count = mysql_num_rows($resultado);

	while ($fila = mysql_fetch_object($resultado)) 
	{										
	    $registros.= "<tr><td>".$fila->zona."</td><td>".$fila->equipo."</td>
	    <td><a href='equipos.php?modificar&id=".$fila->idequipo."'>Modificar</a></td>
	    <td><a href='equipos.php?eliminar&id=".$fila->idequipo."'>Eliminar</a></td>
	    </tr>";					  
	}

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

mysql_free_result($resultado);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Torneo de F&uacute;tbol</title>
<link href="css/estilo.css" rel="stylesheet" type="text/css"></link>
</head>
<body>		
<?php menuHeader();?>
	<div id="section">
		<div id="formulario">                           
			<form name="abm" method="POST" action="<?php print $archivopost;?>">
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
	    		<input type="submit" name="grabar" value="Grabar">
	    		<input type="submit" name="cancelar" value="Cancelar">                                     
			</form>                                         
		</div>
		<div id="listado">
			<table>
				<tr>
					<th colspan="10">
						Equipos 
					</th>
				</tr>
				<tr>
					<th>Zona</th>
					<th>Equipo</th>
				</tr>
				<?php print $registros;?>					
			</table>
		</div>
	</div>
<?php footer();?>
</body>
</html>