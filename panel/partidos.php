<?php

include("../inc/conn.php");

verificar();

$sql = "";
$msg = "";
// $idarbitro = "";
// $arbitro = "";
$registros = "";
$combozona = "";
$idzona = $zona = "";
$idequipo = "";
$equipo = "";
$idjugador = "";
$comboequipo = $jugador = $nro = $fecha = $hora = "";
$idpartido = $comboequipolocal = $comboequipovisitante = "";
$tabla = "";
$c = 0;
// $comboarbitro = $idarbitro = "";

$archivopost = "partidos.php";


if(isset($_POST['grabar']))
{
	if(isset($_POST['accion']))
	{
		if($_POST['accion'] == "insertar")$sql = "insert into partidos(idzona,nrofecha,idpartido,idarbitro,local,visitante,fecha,hora) values ('".$_POST['idzona']."','".$_POST['nrofecha']."','".$_POST['idpartido']."','','".$_POST['local']."','".$_POST['visitante']."','".$_POST['fecha']."','".$_POST['hora']."')";
		elseif($_POST['accion'] == "modificar")$sql = "UPDATE partidos SET idpartido = '".$_POST['idpartido']."',local = '".$_POST['local']."',visitante = '".$_POST['visitante']."',fecha = '".$_POST['fecha']."',hora = '".$_POST['hora']."' WHERE idpartido = ".$_POST['idpartido']." and idzona=".$_POST['idzona']." and nrofecha=".$_POST['nrofecha'];
		// idarbitro = '".$_POST['idarbitro']."',
	}
}
elseif(isset($_GET['eliminar']))$sql = "delete from partidos where idpartido = ".$_GET['idpartido']." and idzona=".$_GET['idzona']." and nrofecha=".$_GET['nrofecha'];

if($sql!="")
{
	$resultado = mysql_query($sql);
	if (!$resultado)$msg = "Error al intentar realizar la operacion";
	else $msg = "Operacion realizada con exito";
}

$accion = "insertar";

if(isset($_GET['modificar']))
{
	$sql = "SELECT p.idzona, z.zona, p.nrofecha, p.idpartido, p.local, e.equipo elocal, p.visitante, c.equipo evisitante, p.fecha , p.hora FROM arbitros a, zonas z, partidos p LEFT JOIN equipos e ON (e.idequipo = p.local), partidos h LEFT JOIN equipos c ON (c.idequipo = h.visitante) WHERE z.idzona = p.idzona and p.idpartido = ".$_GET['idpartido']." and p.idzona=".$_GET['idzona']." and p.nrofecha=".$_GET['nrofecha'];
	$resultado = mysql_query($sql, $enlace);	
	$fila = mysql_fetch_object($resultado);
	$idpartido = $fila->idpartido;
	$idzona = $fila->idzona;
	$nrofecha = $fila->nrofecha;
	$idequipolocal = $fila->local;
	$idequipovisitante = $fila->visitante;	
	// $idarbitro = $fila->idarbitro;
	$fecha = $fila->fecha;
	$hora = substr($fila->hora,0,5);
	$accion = "modificar";				
}
else 
{
	if(isset($_POST['idpartido']))$idpartido = $_POST['idpartido']; elseif(isset($_GET['idpartido']))$idpartido = $_GET['idpartido']; else $idpartido = "";
	if(isset($_POST['idzona']))$idzona = $_POST['idzona']; elseif(isset($_GET['idzona']))$idzona = $_GET['idzona']; else $idzona = "";
	if(isset($_POST['nrofecha']))$nrofecha = $_POST['nrofecha']; elseif(isset($_GET['nrofecha']))$nrofecha = $_GET['nrofecha']; else $nrofecha = "";
	if(isset($_POST['fecha']))$fecha = $_POST['fecha']; elseif(isset($_GET['fecha']))$fecha = $_GET['fecha']; else $fecha = "";
	if(isset($_POST['hora']))$hora = $_POST['hora']; elseif(isset($_GET['hora']))$hora = $_GET['hora']; else $hora = "";
	if(!isset($_POST['local']))$idequipolocal = "";	else $idequipolocal = $_POST['local'];
	if(!isset($_POST['visitante']))$idequipovisitante = "";	else $idequipovisitante = $_POST['visitante'];
	// if(!isset($_POST['idarbitro']))$idarbitro = "";	else $idarbitro = $_POST['idarbitro'];
}

if(isset($_POST['idzona']) && isset($_POST['nrofecha']))
{
	$sql = "SELECT p.nrofecha, p.idpartido, z.idzona, z.zona, p.local, p.fecha, p.hora, (SELECT equipo FROM equipos where idequipo = p.local) elocal, (SELECT equipo FROM equipos where idequipo = p.visitante) evisitante FROM partidos p, zonas z WHERE z.idzona = p.idzona and p.idzona=".$_POST['idzona']." and p.nrofecha=".$_POST['nrofecha'];
	$resultado = mysql_query($sql, $enlace);
	$count = @mysql_num_rows($resultado);
	
	if($count > 0)
	{
		while ($fila = mysql_fetch_object($resultado)) 
		{
			$zona = $fila->zona;
			$fecha = $fila->fecha;
			// $arr_fechahora = explode(" ",$fila->fechahora);				
		  $registros.= "<tbody><tr><td align='center'>".$fila->idpartido."</td><td>".$fila->elocal."</td><td align='center'>Vs.</td><td>".$fila->evisitante."</td><td>".substr($fila->hora,0,5)."</td>
		  <td><a href='".$archivopost."?modificar&idpartido=".$fila->idpartido."&idzona=".$fila->idzona."&nrofecha=".$fila->nrofecha."'>Modificar</a></td>
		  <td><a href='".$archivopost."?eliminar&idpartido=".$fila->idpartido."&idzona=".$fila->idzona."&nrofecha=".$fila->nrofecha."'>Eliminar</a></td>
		  </tr></tbody>";					  
		}	
		// <!--<td align='center'>".substr($arr_fechahora[1],0,5)."</td><td>".$fila->arbitro."</td>-->
		// $fecha = $fila->fecha;
	}else $registros = "";
}

// Combo Equipo
$sql = "SELECT idequipo,idzona,equipo FROM equipos where idzona = '".$idzona."' order by idequipo";
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

// Combo Arbitro
/*
$sql = "SELECT idarbitro, arbitro FROM arbitros ORDER BY idarbitro";
$resultado = mysql_query($sql, $enlace);
$comboarbitro = "<select id='idarbitro' name='idarbitro'>";
$comboarbitro.="<option value =''></option>";
if($idarbitro == "")
{
	while ($fila = mysql_fetch_object($resultado)) 
	{										
    	$comboarbitro.="<option value ='".$fila->idarbitro."'>".$fila->arbitro."</option>";				  
	}
}
else 
{
	while ($fila = mysql_fetch_object($resultado)) 
	{
		if($fila->idarbitro == $idarbitro)$selected = " selected";
		else $selected = "";
    	$comboarbitro.="<option value ='".$fila->idarbitro."' ".$selected.">".$fila->arbitro."</option>";				  
	}	
}

$comboarbitro.= "</select>";
*/

if(isset($_POST['publicar']))
{
	
	for($i=1;$i<=4;$i++)
	{
		// $sql = "SELECT p.nrofecha, p.idpartido, z.idzona, z.zona, p.local, p.fecha, p.hora, (SELECT equipo FROM equipos where idequipo = p.local) elocal, (SELECT equipo FROM equipos where idequipo = p.visitante) evisitante FROM partidos p, zonas z WHERE z.idzona = p.idzona and p.idzona=".$i." order by p.idzona, p.nrofecha";
		$sql = "SELECT p.nrofecha, p.idpartido, z.idzona, z.zona, p.local, p.fecha, p.hora, (SELECT equipo FROM equipos where idequipo = p.local) elocal, (SELECT equipo FROM equipos where idequipo = p.visitante) evisitante FROM partidos p, zonas z WHERE z.idzona = p.idzona and p.idzona=".$i." and p.nrofecha = 4 order by p.idzona, p.nrofecha";
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
				<tr><th>Fecha: ".$fila->nrofecha."</th></tr>
				<tr><th>Partido</th><th>Local</th><th align='center'>".$fila->fecha."</th><th>Visitante</th><th align='center'>Hora</th></tr></thead>";			
				$tabla.= "<tbody><tr><td align='center'>".$fila->idpartido."</td><td>".$fila->elocal."</td><td align='center'>Vs.</td><td>".$fila->evisitante."</td><td align='center'>".substr($fila->hora,0,5)."</td>
			    </tr></tbody>";
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

	$msg = (publicar(4,$tabla))?"Contenido publicado con exito":"Error al intentar publicar";			

}

mysql_free_result($resultado);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Torneo de F&uacute;tbol</title>
<link href="../css/estilo.css" rel="stylesheet" type="text/css"></link>
<link rel="stylesheet" href="../jquery/css/south-street/jquery-ui-1.9.0.custom.css" />
<script src="../jquery/js/jquery-1.8.2.js"></script>
<script src="../jquery/js/jquery-ui.js"></script>   
<script type="text/javascript" src="../js/lib.js"></script>
</head>
<body>		
<?php menuHeader();?>
	<div id="section">
		<div id="formulario">  
			<form name="abm" method="POST" action="<?php print $archivopost;?>">
				<input type="hidden" id="accion" name="accion" value="insertar">		
				<label for="nrofecha">Fecha:&nbsp;</label>	
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
				<label for="idzona">Zona:&nbsp;</label>	
				<?php print $combozona;?>
				<h3><input type="submit" id="editar" name="editar" value="Editar"></h3>
			</form>
		</div>
		<div class="espacio"></div>
	<?php
	if(isset($_POST['editar']) || isset($_GET['modificar']))
	{
		if($idzona == "" || $nrofecha == "")
		{
			print "Debe completar los campos";
			exit;
		}
	?>
	
	<div id="formulario">                           
		<form name="abm" method="POST" action="<?php print $archivopost;?>">
			<input type="hidden" id="accion" name="accion" value="<?php print $accion;?>">	
			<input type="hidden" id="idzona" name="idzona" value="<?php print $idzona;?>">
			<input type="hidden" id="nrofecha" name="nrofecha" value="<?php print $nrofecha;?>">
			<label for="fecha">Fecha:&nbsp;</label>
			<input type="text" id="fecha" name="fecha" value="<?php print $fecha;?>"> 
			<label for="hora">Hora:&nbsp;</label>
			<input type="text" id="hora" name="hora" value="<?php print $hora;?>">&nbsp;[mm:ss]
			<BR><BR>
			<label for="idpartido">Nro. Partido:&nbsp;</label>
			<input type="text" id="idpartido" name="idpartido" size="2" value="<?php print $idpartido;?>">
			<BR><BR>
			<label for="">Local</label><label for="">Visitante</label>
			<br>
			<?php print $comboequipolocal;?>
			&nbsp;Vs.&nbsp;			
			<?php print $comboequipovisitante;?>
			<BR><BR>  		
  			<h3>
				<input type="submit" name="grabar" value="Grabar">
	  			<input type="submit" name="cancelar" value="Cancelar">        			
			</h3>
  		</form>
			
	</div>	
	<div class="espacio"></div>
	
	<?php
	}
	if(isset($_POST['editar']) || isset($_POST['grabar'])){?>                         
			<div class="msg"><?php print $msg;?></div>
			<br>
			<h2>Lista de Partidos</h2>	
			<br>				
			<input type="hidden" id="idjugador" name="idjugador" value="<?php print $idjugador;?>">
			<div id="listado">
				<?php print $zona;?>
				<table cellpadding="0" cellspacing="0" class="tablas" id="tabla">
					<thead>
					<tr>
						<th>Partido</th>
						<th>Local</th>
						<th align='center'><?php print $fecha;?></th>
						<th>Visitante</th>
						<th align='center'>Hora</th>
						<th></th>
						<th></th> 
						<!-- <th>Arbitro</th> -->									
					</tr></thead>
					<?php print $registros;?>					
				</table>
			</div>
	<?php }?>
			<div class="espacio"></div>
			<form name='frmPublicar' method="POST" class='publicar' action="<?php print $archivopost;?>">
				<h3><input type="submit" name="publicar" value="Publicar todos los partidos"></h3>
			</form>			
	<?php footer();?>
</body>
</html>