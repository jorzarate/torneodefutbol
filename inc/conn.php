<?php

require_once("fnc.php");
require_once("config.php");

$enlace =  mysql_connect(HOST, USERDB, PASSDB);
if (!$enlace) {
    die('No pudo conectarse: ' . mysql_error());
}


if (!mysql_select_db(DB, $enlace)) {
    echo 'No pudo seleccionar la base de datos';
    exit;
}

?>