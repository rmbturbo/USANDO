<?php

if (isset($_REQUEST['sair'])) {

	unset($_SESSION['usuarioID']);
	unset($_SESSION['usuarioNome']);
	unset($_SESSION['usuarioCargo']);
	unset($_SESSION['usuarioAcesso']);
	unset($_SESSION['usuarioERP']);
	unset($_SESSION['senhaERP']);
	//unset($_SESSION['logado']);
	session_destroy();
	header("Location: index.html");
}

?>