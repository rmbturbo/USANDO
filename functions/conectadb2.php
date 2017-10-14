<?php
$hostname = 'localhost';
$username = 'romulo';
$senhadb = '88070540';
$banco = 'ativo';
$conectabase = new mysqli($hostname, $username, $senhadb, $banco);
if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());
//$conectabase = mysql_connect($hostname, $username, $senhadb) or trigger_error(mysql_error()); //conecta no banco//
//mysql_select_db($banco, $conectabase) or trigger_error(mysql_error());//seleciona o banc//


?>