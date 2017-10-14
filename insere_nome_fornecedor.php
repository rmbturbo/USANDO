
<?php


	if (!isset($_SESSION)) session_start();

	if (!isset($_SESSION['usuarioID'])) {
		// Destrói a sessão por segurança
		session_destroy();
		// Redireciona o visitante de volta pro login
		header("Location: index.php"); exit;
	}

	$acesso = $_SESSION['usuarioAcesso'];
$usuario = $_SESSION['usuarioERP'];

if (isset($_GET['retorno']) && isset($_GET['nome'])) {
	$retorno = $_GET['retorno'];
	$nome = $_GET['nome'];
	if($retorno == 	'sucesso'){
		echo '<div class="alert alert-success" role="alert">O nome '.$nome.' foi cadastrado como novo Fornecedor com sucesso </div>';
	} elseif($retorno =='excesso'){
		echo '<div class="alert alert-danger" role="alert">O nome '.$nome.' já está cadastrada como Fornecedor, para altera-lá vá no menu Fornecedor -> Alterar cadastro </div>';
	} elseif($retorno == 'serverER'){
		include_once('conectadb2.php');
		$erro = 'Erro: '. $conectabase->errno .'-'. $conectabase->error;
		echo '<div class="alert alert-danger" role="alert">'.$erro.' ao cadastrar o nome de fornecedor '.$nome.' </div>';
		//	echo 'erro';
	}
}

include('includes/header.php');
include('includes/topo.php');

?>

 <script src='http://code.jquery.com/jquery-1.7.2.min.js'></script>
 <body>

 <div class="container span7 text-center col-md-5 col-md-offset-3" style="margin: 0 auto;float: none;">
 	<form name="new_fornecedor" method="post" action="modulos/fornecedor/Insere_DB_fornecedor.php?or=3">

		<div class="panel panel-default">
  			<div class="panel-heading">
   				<h3 class="panel-title">Nome Fantasia</h3>
 			</div>
 		 	<div class="panel-body" align="center">
 		 		<input type="text" name="fantasia" id="fantasia" onblur="if (this.value==null || this.value == '' ) {
 		 			alert('Digite um nome válido');
 		 		}"/>
 		 	</div>
 		 </div>
 		 <div class="panel panel-default">
  			<div class="panel-body">
    			<input type="submit" value="Enviar" />
  			</div>
		</div>

 	</form>
 </div>

 </body>
 </html>

?>