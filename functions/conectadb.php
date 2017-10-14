<?php

try{
	$conexao = new PDO('mysql:host=localhost;dbname=erp_2_0','romulo','88070540');
	$conexao ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
	echo'ERRO: '.$e->getMessage();
}

/**
 * SEM PDO
$hostname = 'localhost';
$username = 'romulo';
$senhadb = '88070540';
$banco = 'erp_2_0';
$conectabase = new mysqli($hostname, $username, $senhadb, $banco);
if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());
 * **/
?>