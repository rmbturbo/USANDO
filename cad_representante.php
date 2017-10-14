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



?>

<?php
include('includes/header.php');
include('logoff.php');
?>
 <script type="text/javascript" src="js/validadores.js"></script>

 <!-- Link para melhora do multiseletor -->
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
<form name="cad_representantes" action="modulos/fornecedor/insere_DB_repres.php" method="post">

	<div class="panel panel-default">
  		<div class="panel-heading">
  		   		 <h3 class="panel-title">Dados pessoais</h3>
 		</div>
  		<div class="panel-body" align="center">
  		<label for="apelido">Apelido</label>
   			<input type="text" size="40" maxlength="45" name="apelido" id="apelido"/>
   		<p>
   		<label for="nome">Nome:</label>
   			<input type="text" size="40" maxlength="45" name="nome" id="nome"/>
		</p>
 	 	</div>
	</div>
		<div class="panel panel-default">
  		<div class="panel-heading">
  		   		 <h3 class="panel-title">Dados de Contato</h3>
 		</div>
  		<div class="panel-body" align="center">
  		<label for="tel1">Fone 1:</label>
   			<input type="text" size="15" maxlength="45" name="tel1" id="tel1" class="telefone"/>
   		<label for="tel2">Fone 2:</label>
   			<input type="text" size="15" maxlength="45" name="tel2" id="tel2" class="telefone"/>
   		<p>
   		<label for="tel3">Fone 3:</label>
   			<input type="text" size="15" maxlength="45" name="tel3" id="tel3" class="telefone"/>
   		<label for="tel4">Fone 4:</label>
   			<input type="text" size="15" maxlength="45" name="tel4" id="tel4" class="telefone"/>
		</p>
   		<p>
   		<label for="email">E-mail:</label>
   			<input type="text" size="40" maxlength="100" name="email" id="email"/>
		</p>
		<p>
   		<label for="site">Site:</label>
   			<input type="text" size="40" maxlength="100" name="site" id="site"/>
		</p>
 	 	</div>
	</div>

	<div class="panel panel-default">
  		<div class="panel-heading">
  		   		 <h3 class="panel-title">Observações</h3>
 		</div>
  		<div class="panel-body" align="center">
   				<textarea name="obs" id="obs" spellcheck="true" rows="5" cols="60"></textarea></textarea>
 	 	</div>
	</div>

	<div class="panel panel-default">
  		<div class="panel-heading">
  		   		 <h3 class="panel-title">Marcas / Fornecedores</h3>
 		</div>
  		<div class="panel-body" align="center">
 				<script type="text/javascript">
$(document).ready(function() {
	$('#marca').multiselect();
	$('#fornecedor').multiselect();
});
				</script>
				<span id="marcas">
<label for="marca">Marca: </label>
<select name="marca[]" id="marca" class="multiselect" multiple="multiple">
<?php
require('conectadb2.php');
$sqlmarca= " SELECT * FROM `marcas` ORDER BY `nome_marca`";
//$result = mysqli_query($sqlforn) or die (mysql_error());
$querym = $conectabase->query($sqlmarca);
$totalm = mysqli_num_rows($querym);
echo '<option value="">Selecione...</option>';
while ($linham = $querym->fetch_array()) {
echo "<option value=".$linham['idMarca'].">".$linham['nome_marca']."</option>";
}
$conectabase->close();
 ?>
</select> <span> </span>

			</span>
   			<span id="fornecedores">
   			<label for="fornecedor">Fornecedor: </label>
   				<select name="fornecedor[]" id="fornecedor" class="multiselect" multiple="multiple" >
<?php
require('conectadb2.php');
$sqlforn= " SELECT * FROM `fornecedor` ORDER BY `fantasia`";
//$result = mysqli_query($sqlforn) or die (mysql_error());
$queryf = $conectabase->query($sqlforn);
$totalf = mysqli_num_rows($queryf);
echo '<option value="">Selecione...</option>';
while ($linhaf = $queryf->fetch_array()) {
echo "<option value=".$linhaf['idFornecedor'].">".$linhaf['fantasia']."</option>";
}
$conectabase->close();
 ?>
</select><br/><br/>
			</span>


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