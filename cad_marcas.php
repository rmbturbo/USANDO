
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


include('includes/header.php');
include('logoff.php'); ?>
 <script type="text/javascript" src="js/validadores.js"></script>
<script type="text/javascript" src="bootstrap/dist_multisel/dist/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="bootstrap/dist_multisel/dist/css/bootstrap-multiselect.css" type="text/css">

</head>

<body>


<!-- Entrada do Topo da pagina -->
<?php
include('includes/topo.php');
include('functions/functions.php');
?>
<!-- Tratamento dos ALERTAS -->
<?php
if (isset($_GET['retorno']) && isset($_GET['marca'])) {
	$retorno = $_GET['retorno'];
	$marca = $_GET['marca'];
	if($retorno == 	'sucesso'){
		echo '<div class="alert alert-success" role="alert">A marca '.$marca.' foi cadastrada com sucesso </div>';
	} elseif($retorno =='excesso'){
		echo '<div class="alert alert-warning" role="alert"> A marca '.$marca.' já está cadastrada, para altera-la vá no menu Produtos -> Alterar cadastro de Marcas </div>';
	} elseif($retorno == 'fracasso'){
		echo '<div class="alert alert-danger" role="alert"> Erro ao relacionar marca com fornecedores, contacte o administrador do sistema. </div>';
	} elseif($retorno == 'fracasso2'){
			echo '<div class="alert alert-danger" role="alert"> Erro no servidor ao inserir a marca '.$marca.', contacte o administrador do sistema. </div>';
		//	echo 'erro';
	}
}


?>

<div class="container span7 text-center col-md-5 col-md-offset-3" style="margin: 0 auto;float: none;">
<form name="cad_marcas" action="modulos/produtos/Insere_DB_marcas.php" method="post">

	<div class="panel panel-default">
  		<div class="panel-heading">
  		   		 <h3 class="panel-title">Nome da marca</h3>
 		</div>
  		<div class="panel-body" align="center">
   			<input type="text" size="40" maxlength="45" name="marca" id="marca"/>
 	 	</div>
	</div>

	<div class="panel panel-default">
  		<div class="panel-heading">
   		 <h3 class="panel-title">Fornecedores</h3>
 		</div>
  		<div class="panel-body" align="center">
			<p>
			<div id="fornecedores">
   			 	<div>
				<select name="fornecedor[]" id="fornecedor" multiple="multiple"><?php lista_forn() ?> </select><br/><br/>
				<script type="text/javascript">
				$(document).ready(function() {
					$('#fornecedor').multiselect();
				});
				</script>
				</div>
			</div>
   			</p>
 	 	</div>
	</div>
	<div class="panel panel-default">
  		<div class="panel-body" align="center">
			<p>
			<div id="input">
   			 	<div>
				<input type="submit" value="Salvar"/>
				</div>
			</div>
   			</p>
 	 	</div>
	</div>

</form>
</div>
