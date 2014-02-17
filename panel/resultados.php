<?php

include("../inc/conn.php");

verificar();

$sql = "";
$msg = "";
if(!isset($nrofecha))$nrofecha = "";
$registros = "";
$combozona = "";
$idzona = $zona = "";
$idequipo = "";
$equipo = "";
$comboequipo = $jugador = $nro = $fecha = $hora = "";
$idpartido = $comboequipolocal = $comboequipovisitante = "";
$tabla = "";

$archivopost = "resultados.php";

if($sql!="")
{
	$resultado = mysql_query($sql);
	if (!$resultado)$msg = "Error al intentar realizar la operacion";
	else $msg = "Operacion realizada con exito";
}

if(isset($_POST['idzona']) && isset($_POST['nrofecha']))
{
	$sql = "SELECT p.nrofecha, p.idpartido, z.idzona, z.zona, p.local, p.visitante, p.glocal, p.gvisitante, p.fecha, p.hora, (SELECT equipo FROM equipos where idequipo = p.local) elocal, (SELECT equipo FROM equipos where idequipo = p.visitante) evisitante FROM partidos p, zonas z WHERE z.idzona = p.idzona and p.idzona=".$_POST['idzona']." and p.nrofecha=".$_POST['nrofecha']." ORDER BY p.idzona, p.nrofecha, p.idpartido";	
	$resultado = mysql_query($sql, $enlace);
	$count = @mysql_num_rows($resultado);
	
	if($count > 0)
	{
		while ($fila = mysql_fetch_object($resultado)) 
		{
			$zona = $fila->zona;
			$fecha = $fila->fecha;
			// $arr_fechahora = explode(" ",$fila->fechahora);				
		    $registros.= "<tr><td align='center'>".$fila->idpartido."</td><td>".$fila->elocal."</td><td><input type='text' size='1' id='glocal_".$fila->local."' name='glocal_".$fila->local."' value='".$fila->glocal."'></td><td align='center'> - </td><td><input type='text' size='1' id='gvisitante_".$fila->visitante."' name='gvisitante_".$fila->visitante."' value='".$fila->gvisitante."'></td><td> ".$fila->evisitante."</td>
		    <td align='center'>".substr($fila->hora,0,5)."</td><td><a href='#' onclick=grabarResultado('".$fila->idzona."','".$fila->nrofecha."','".$fila->idpartido."','".$fila->local."','".$fila->visitante."');>Grabar</a></td><td><span id='estado_".$fila->local."'></span></td>
		    </tr>";	    				  
		}
		$fecha = $fila->fecha;
	}else $registros = "";
	$idzona = $_POST['idzona'];
}

// Combo Equipo
$sql = "SELECT idequipo,idzona,equipo FROM equipos order by idequipo";
// Local
$resultado = mysql_query($sql, $enlace);
$comboequipolocal = "<select id='local' name='local'>";
$comboequipolocal.="<option value =''></option>";
if(!isset($_GET['modificar']))
{
	while ($fila = mysql_fetch_object($resultado)) 
	{										
    	$comboequipolocal.="<option value ='".$fila->idequipo."'>".$fila->equipo."</option>";				  
	}
}
else 
{
	while ($fila = mysql_fetch_object($resultado)) 
	{
		if($fila->idequipo == $idequipolocal)$selected = " selected";
		else $selected = "";
    	$comboequipolocal.="<option value ='".$fila->idequipo."' ".$selected.">".$fila->equipo."</option>";				  
	}	
}
$comboequipolocal.= "</select>";

// Visitante
$resultado = mysql_query($sql, $enlace);
$comboequipovisitante = "<select id='visitante' name='visitante'>";
$comboequipovisitante.="<option value =''></option>";
if(!isset($_GET['modificar']))
{
	while ($fila = mysql_fetch_object($resultado)) 
	{										
    	$comboequipovisitante.="<option value ='".$fila->idequipo."'>".$fila->equipo."</option>";				  
	}
}
else 
{
	while ($fila = mysql_fetch_object($resultado)) 
	{
		if($fila->idequipo == $idequipovisitante)$selected = " selected";
		else $selected = "";
    	$comboequipovisitante.="<option value ='".$fila->idequipo."' ".$selected.">".$fila->equipo."</option>";				  
	}	
}
$comboequipovisitante.= "</select>";

// Combo Zona
$sql = "SELECT idzona,zona FROM zonas ORDER BY idzona";
$resultado = mysql_query($sql, $enlace);
$combozona = "<select id='idzona' name='idzona'>";
$combozona.="<option value =''></option>";
if(@$_POST['accion'] != "modificar" && !isset($_POST['idzona']) && !isset($_GET['idzona']))
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
		$sql = "SELECT p.nrofecha, p.idpartido, z.idzona, z.zona, p.local, glocal, gvisitante, p.fecha, p.hora, (SELECT equipo FROM equipos where idequipo = p.local) elocal, (SELECT equipo FROM equipos where idequipo = p.visitante) evisitante FROM partidos p, zonas z WHERE z.idzona = p.idzona and p.idzona=".$i." and p.nrofecha <> 4 order by p.idzona asc, p.nrofecha desc, p.idpartido asc";
		$resultado = mysql_query($sql, $enlace);
		$count = @mysql_num_rows($resultado);

		if($count > 0)
		{
			
			if($i==1)$zona="ZONA A";
			elseif($i==2)$zona="ZONA B";
			elseif($i==3)$zona="ZONA C";
			elseif($i==4)$zona="ZONA D";
			else $zona = "";
									
			$c = 0;
			$fecha_ant = "";			
			while ($fila = mysql_fetch_object($resultado)) 
			{
				if($idzona != $fila->idzona)$tabla.= "<div class='espacio'>".$zona."</div>";
				
				if($fecha_ant != $fila->nrofecha)$c=0;
								
				// $arr_fechahora = explode(" ",$fila->fechahora);
				if($c==0)$tabla.= "<div id='listado'><table class='tablas' id='tabla'><thead>
				<h3>Fecha Nro. ".$fila->nrofecha."</h3>
				<tr><th>Partido</th><th width='240px'>Local</th><th></th><th align='center'>".$fila->fecha."</th><th></th><th width='240px'>Visitante</th><th align='center'>Hora</th></tr></thead>";			
				$tabla.= "<tr><td align='center'>".$fila->idpartido."</td><td width='200px'>".$fila->elocal."</td><td  width='30px' align='center'>".$fila->glocal."</td><td align='center'> - </td><td width='30px' align='center'>".$fila->gvisitante."</td><td> ".$fila->evisitante."</td>
				<td align='center'>".substr($fila->hora,0,5)."</td>";
				/*
				$tabla.= "<tbody><tr><td align='center'>".$fila->idpartido."</td><td>".$fila->elocal."</td><td align='center'><td align='center'>Vs.</td><td>".$fila->evisitante."</td><td align='center'>".$arr_fechahora[1]."</td>
			    </tr></tbody>";
			    */
				$idzona = $fila->idzona;
				$fecha_ant = $fila->nrofecha;
				$c++;					  
			}	
			$tabla.= "</table></div><div class='espacio'></div>";			
		}
		else 
		{
			$msg = "No se encontraron datos para publicar";
		}
	
	}

	$msg = (publicar(5,$tabla))?"Contenido publicado con exito":"Error al intentar publicar";			

}


mysql_free_result($resultado);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Torneo de F&uacute;tbol</title>
<link href="../css/estilo.css" rel="stylesheet" type="text/css"></link>
<script type="text/javascript" src="../js/lib.js"></script>
</head>
<body>		
<?php menuHeader();?>
	<div id="section">
		<div id="formulario">  
			<form name="abm" method="POST" action="<?php print $archivopost;?>">
				<input type="hidden" id="accion" name="accion" value="insertar">		
				<label for="nrofecha">Fecha:</label>	
				<select id='nrofecha' name='nrofecha'>
					<option value=''></option>
					<option value='1' <?php if($nrofecha == 1)print " selected";?>>1</option>
					<option value='2' <?php if($nrofecha == 2)print " selected";?>>2</option>
					<option value='3' <?php if($nrofecha == 3)print " selected";?>>3</option>
					<option value='4' <?php if($nrofecha == 4)print " selected";?>>4</option>
					<option value='5' <?php if($nrofecha == 5)print " selected";?>>5</option>
					<option value='6' <?php if($nrofecha == 6)print " selected";?>>6</option>
					<option value='7' <?php if($nrofecha == 7)print " selected";?>>7</option>
				</select>
				<label for="idzona">Zona:</label>	
				<?php print $combozona;?>
				<h3><input type="submit" id="editar" name="editar" value="Editar"></h3>
			</form>
		</div>
		<div class="espacio"></div>
		<div class="msg"><?php print $msg;?></div>
	<?php
	if(isset($_POST['editar']) || isset($_GET['modificar']))
	{
		if($idzona == "" || $nrofecha == "")
		{
			print "Debe completar los campos";
			exit;
		}
	}	
	if(isset($_POST['editar']) || isset($_POST['grabar'])){?>
		<BR>
		<h2>Lista de Resultados</h2>	
		<BR>
		[Escribir NP para los equipos No Presentados]
		<br><br>
		<input type="hidden" id="idjugador" name="idjugador" value="<?php print $idjugador;?>">
		<div id="listado">
			<table>
				<tr>
					<th colspan="9">
						<?php print $zona;?>	
					</th>
				</tr>
				<tr>
					<th>Partido</th>
					<th>Local</th>
					<th></th>
					<th align='center'><?php print $fecha;?></th>
					<th></th>
					<th>Visitante</th>
					<th align='center'>Hora</th>
					<th></th>
					<th></th>
				</tr>
				<?php print $registros;?>					
			</table>
		</div>					
	<?php }?>
			<br><br><br>
			<div id="espacio"></div>		
			<form name='frmPublicar' method="POST" action="<?php print $archivopost;?>">
				<h3><input type="submit" name="publicar" value="Publicar todos los resultados"></h3>
			</form>	
	<?php footer();?>
</body>
</html>