<html>
	<head><link href="css/estilo.css" rel="stylesheet" type="text/css"/></head>
	<body>
		<div id="formulario">                           
			<form name="abm" method="POST" action="index.php?1&2">
				<h1>Torneo de F&uacute;tbol</h1>
				<h2>Carga de Arbitros</h2>	
				<BR>
				<input type="hidden" id="idarbitro" name="idarbitro" value="<?php print $idarbitro;?>">
				<label for="arbitro">Arbitro:</label>
				<input type="text" id="arbitro" name="arbitro" value="<?php print $arbitro;?>">
				<label for="lote">Lote:</label>
				<input type="text" name="lote" readonly value="~lote">
				<label for="frente">Frente:</label>
				<input type="text" name="frente" readonly value="~frente">
				<label for="fondo">Fondo:</label>
				<input type="text" name="fondo" readonly value="~fondo">
				<label for="sup_lote">Superficie:</label>
				<input type="text" name="sup_lote" readonly value="~sup_lote">
				<label for="destino">Destino:</label>
				<input type="text" name="destino" readonly value="Unifamiliar">
				<label for="estado">Estado:</label>
				<select name = "estado" >~estado</select>
	    		<BR><BR>
	    		<input type="submit" name="grabar" value="Grabar">
	    		<input type="submit" name="cancelar" value="Cancelar">                                     
			</form>                                         
		</div>
	</body>	
</html>