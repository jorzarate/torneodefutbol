<?php

include("../inc/config.php");

function validar($usuario,$clave)
{
	$a = false;
	if ($usuario==USUARIO && $clave==CLAVE) 
	{
		if (!isset($_SESSION))
		{
			session_start();
			// session_register("usuario");
			$_SESSION["usuario"] = $usuario;				
		}
		$a = true;
	}
        else
        {
            print "Los datos ingresados son incorrectos";exit;
        }
        return($a);
}
function verificar()
{
	if(!isset($_SESSION))session_start();

	if(!isset($_SESSION['usuario'])) 
	{
		print "<center>Debe autenticarse para poder ingresar</center>";
		print "<br><br><br><center><a href='index.php'>Ingresar</a>";
		exit;	
	}	
}
function publicar($id,$texto)
{	
	
/*
   2: Equipos		                    
   3: Jugadores		                    
   4: Fixture
   5: Resultados
   6: Posiciones
   7: Goleadores
   8: Reglamento
*/		
	$f = "../content/".$id;
	$fp = fopen($f,"w");
	fwrite($fp, $texto.PHP_EOL);
	fclose($fp);
	return (file_exists($f) && filesize($f)>0);
}
function footer()
{
	print "<div class='espacio'></div><div id='footer'></div>";
}
function menuHeader()
{
	print "<div id='header'><nav>
		    	<b>
	      	<ul>		                    
            <li><a href='equipos.php'>Equipos</a></li>		                    
            <li><a href='jugadores.php'>Jugadores</a></li>
            <li><a href='partidos.php'>Partidos</a></li>
            <li><a href='resultados.php'>Resultados</a></li>
            <li><a href='posiciones.php'>Posiciones</a></li>
            <!-- <li><a href='reglamento.php'>Reglamento</a></li> -->
            <!-- <li><a href='descargar.php'>Descargar</a></li> -->
    	    </ul>
    	    </b>
		   </nav></div>";
}
?>
