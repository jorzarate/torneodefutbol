<?php
// print_r($_GET);
include("../inc/conn.php");

verificar();

$GF = $GC = "";

$sql = "UPDATE partidos SET glocal = '".$_GET['glocal']."',gvisitante = '".$_GET['gvisitante']."' WHERE idpartido = ".$_GET['idpartido']." and idzona=".$_GET['idzona']." and nrofecha=".$_GET['nrofecha'];

$resultado = mysql_query($sql);
if (!$resultado)$msg = "<font color='red'><br>error al grabar</font>";
else
{
	$msg = "<font color='green'>grabado</font>";

	// Local
	$idequipo = $_GET['idlocal'];
		
	if($_GET['glocal'] == "NP")
	{
		$NP = 1;
		$GF = 0;
		$GC = 2;
		$PG = 0;
		$PE = 0;
		$PP = 1;
		$PTS = 0;		
	}
	else 
	{
		$NP = 0;
		$GF = $_GET['glocal'];
		$GC = $_GET['gvisitante'];
	
		if($_GET['gvisitante'] == "NP")
		{
			$NP = 0;
			$GF = 2;
			$GC = 0;
			$PG = 1;
			$PE = 0;
			$PP = 0;
			$PTS = 3;				
		}
		elseif ($_GET['glocal'] > $_GET['gvisitante'])
		{
			$PG = 1;
			$PE = 0;
			$PP = 0;
			$PTS = 3;		
		}
		elseif($_GET['glocal'] == $_GET['gvisitante'])
		{
			$PG = 0;
			$PE = 1;
			$PP = 0;
			$PTS = 2;		
		}
		else 
		{
			$PG = 0;
			$PE = 0;
			$PP = 1;		
			$PTS = 1;
		}	
	}
		
	$DF = $GF - $GC;
		
	$sql = "insert into puntajes(idzona,idequipo,nrofecha,PG,PE,PP,NP,GF,GC,DF,PTS) values('".$_GET['idzona']."','".$idequipo."','".$_GET['nrofecha']."','".$PG."','".$PE."','".$PP."','".$NP."','".$GF."','".$GC."','".$DF."','".$PTS."')";
	$resultado = mysql_query($sql);
	if(mysql_errno() == 1062)
	{
		$sql = "UPDATE puntajes SET PG = '".$PG."',PE = '".$PE."',PP = '".$PP."',NP = '".$NP."',GF = '".$GF."',GC = '".$GC."',DF = '".$DF."',PTS = '".$PTS."' WHERE idzona = ".$_GET['idzona']." and idequipo=".$idequipo." and nrofecha=".$_GET['nrofecha'];
		$resultado = mysql_query($sql);
		if (!$resultado)$msg.= "&nbsp;&nbsp;&nbsp;<font color='red'><br><br>error al grabar el puntaje local</font>";		
	}
	
	// Visitante
	$idequipo = $_GET['idvisitante'];
	
	if($_GET['gvisitante'] == "NP")
	{
		$NP = 1;
		$GF = 0;
		$GC = 2;
		$PG = 0;
		$PE = 0;
		$PP = 1;
		$PTS = 0;		
	}
	else 
	{
		$NP = 0;
		$GF = $_GET['gvisitante'];
		$GC = $_GET['glocal'];

		if($_GET['glocal'] == "NP")
		{
			$NP = 0;
			$GF = 2;
			$GC = 0;
			$PG = 1;
			$PE = 0;
			$PP = 0;
			$PTS = 3;				
		}		
		elseif ($_GET['gvisitante'] > $_GET['glocal'])
		{
			$PG = 1;
			$PE = 0;
			$PP = 0;
			$PTS = 3;		
		}
		elseif($_GET['glocal'] == $_GET['gvisitante'])
		{
			$PG = 0;
			$PE = 1;
			$PP = 0;
			$PTS = 2;		
		}
		else 
		{
			$PG = 0;
			$PE = 0;
			$PP = 1;		
			$PTS = 1;
		}	
	}
	
	$DF = $GF - $GC;	
	
	$sql = "insert into puntajes(idzona,idequipo,nrofecha,PG,PE,PP,NP,GF,GC,DF,PTS) values('".$_GET['idzona']."','".$idequipo."','".$_GET['nrofecha']."','".$PG."','".$PE."','".$PP."','".$NP."','".$GF."','".$GC."','".$DF."','".$PTS."')";
	$resultado = mysql_query($sql);
	if(mysql_errno() == 1062)
	{
		$sql = "UPDATE puntajes SET PG = '".$PG."',PE = '".$PE."',PP = '".$PP."',NP = '".$NP."',GF = '".$GF."',GC = '".$GC."',DF = '".$DF."',PTS = '".$PTS."' WHERE idzona = ".$_GET['idzona']." and idequipo=".$idequipo." and nrofecha=".$_GET['nrofecha'];
		$resultado = mysql_query($sql);
		if (!$resultado)$msg.= "&nbsp;&nbsp;&nbsp;<font color='red'><br>error al grabar el puntaje visitante</font>";		
	}
}

print $msg;

mysql_close($enlace);

?>