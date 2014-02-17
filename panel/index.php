<?php

include("../inc/conn.php");

if(isset($_GET['1']) && validar($_POST["usuario"],$_POST["clave"]))
{
	verificar();
?>	

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Torneo de F&uacute;tbol</title>
<link href="../css/estilo.css" rel="stylesheet" type="text/css"></link>
</head>
<body>		
<?php menuHeader();?>
	<div id="section"></div>
	<div id="footer"></div>
</body>
</html>

<?php	
}
else
{

?>
<html>
	<head><link href="../css/estilo.css" rel="stylesheet" type="text/css"/>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		</head>
	<body>
		<div class="espacio"></div>
		<div id="formulario">                           
			<form name="login" method="POST" action="index.php?1">                    
				<h1>Torneo de F&uacute;tbol</h1>
				<br>
				<label for="usuario">Usuario:&nbsp;</label>                                     
				<input type="text" name="usuario"/>                    
				<label for="clave">Contrase&ntilde;a:&nbsp;</label>                                        
				<input type="password" name="clave"/>   
				<button type="submit">Ingresar</button>                                                
			</form>                                         
		</div>
	</body>	
</html>
<?php }?>