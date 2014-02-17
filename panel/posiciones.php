<?php

include("../inc/conn.php");

verificar();

$tabla = $msg = "";
$c=0;

for($i=1;$i<=4;$i++)
{
	
	$sql = "SELECT p.idequipo, e.equipo, MAX( p.nrofecha ) PJ, SUM( p.PG ) PG, SUM( p.PE ) PE, SUM( p.PP ) PP, SUM( NP ) NP, SUM( GF ) GF, SUM( GC ) GC, SUM( DF ) DF, SUM( PTS ) PTS
	FROM puntajes p, equipos e
	WHERE e.idequipo = p.idequipo
	AND p.idzona = ".$i."
	GROUP BY p.idequipo
	ORDER BY PTS DESC , DF DESC";

	// print "<br>".$sql."<br>";
	
	$resultado = mysql_query($sql, $enlace);

	if($i==1)$zona="ZONA A";
	elseif($i==2)$zona="ZONA B";
	elseif($i==3)$zona="ZONA C";
	elseif($i==4)$zona="ZONA D";
	else $zona = "";
	
	$tabla.= "<div id='listado'><table border='1'><tr><th>#</th><th>".$zona."</th><th>PJ</th><th>PG</th><th>PE</th><th>PP</th><th>NP</th><th>GF</th><th>GC</th><th>DF</th><th>PTS</th></tr>";	
	$c=0;
	while ($fila = mysql_fetch_object($resultado)) 
	{
			$c++;
	    $tabla.= "<tr><td align='center'>".$c."</td><td>".$fila->equipo."</td>
	    <td align='center'>".$fila->PJ."</td>
	    <td align='center'>".$fila->PG."</td>
	    <td align='center'>".$fila->PE."</td>
	    <td align='center'>".$fila->PP."</td>
	    <td align='center'>".$fila->NP."</td>
	    <td align='center'>".$fila->GF."</td>
	    <td align='center'>".$fila->GC."</td>
	    <td align='center'>".$fila->DF."</td>
	    <td align='center'>".$fila->PTS."</td>
	    </tr>";	    				  
	}
	$tabla.= "</table></div><div class='espacio'></div>";
	
}

if(isset($_POST['publicar']))
{
	$msg = (publicar(6,$tabla))?"Contenido publicado con exito":"Error al intentar publicar";	
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Torneo de F&uacute;tbol</title>
<link href="../css/estilo.css" rel="stylesheet" type="text/css"></link>
<script type="text/javascript" src="js/lib.js"></script>
</head>
<body>		
<?php menuHeader();?>
	<div id="section">
		<div id="msg"><?php print $msg;?></div>
		<div id="listado">                           
			<h2>Tabla de Posiciones</h2>	
			<BR>
				<?php print $tabla;?>
		</div>
	</div>
	<div id="espacio"></div>
	<form name='frmPublicar' method="POST" action="posiciones.php">
		<h3><input type="submit" name="publicar" value="Publicar Posiciones"></h3>
	</form>
		
<?php footer();?>
</body>
</html>