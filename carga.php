<?php
	header("Content-Type: text/html; charset=iso-8859-1");
	$arch = "content/".$_GET['pagina'];
	if (file_exists($arch)) 
	{
		$f=fopen($arch,"r");
		if($f)
		{
			$bloque=fread($f,filesize($arch));
			fclose($f);
		}
		else print "Error en el sitio web";			
		print $bloque;
	}else print "Error al cargar la pagina";
?>