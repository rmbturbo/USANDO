<?php include("includes/header.php") ?>
<?php
ob_start();
session_start();
if (isset($_SESSION['usuarioERP']) && isset($_SESSION['senhaERP'])) {

	header("location:home.php");exit;

}

include('conectadb.php');
//include('functions/login.php');
if (isset($_POST['logar'])) {
	$usuario = trim(strip_tags($_POST['usuario']));
	$senha = trim(strip_tags($_POST['senha']));

	$select = "SELECT * FROM usuario WHERE usuario =:usuario AND senha=:senha LIMIT 1";

	try{

		$result = $conexao->prepare($select);
		$result->bindParam(':usuario', $usuario, PDO::PARAM_STR);
		$result->bindParam(':senha', $senha, PDO::PARAM_STR);
		$result->execute();
		$contar = $result->rowCount();
		$dados = $result->fetch(PDO::FETCH_ASSOC);
		if ($contar == 1) {
			//$usuario = $_POST['usuario'];
			//$senha = $_POST['senha'];
			$_SESSION['usuarioERP'] =$usuario;
			$_SESSION['senhaERP'] = $senha;
			$_SESSION['usuarioAcesso'] = $dados['grau_acesso'];
			$_SESSION['usuarioID'] = $dados['idusuario'];
			$_SESSION['usuarioNome'] = $dados['nome'];
			$_SESSION['usuarioCargo'] = $dados['cargo'];
			echo 'Logado com sucesso';
			echo $_SESSION['usuarioAcesso'];
			echo $_SESSION['usuarioID'];
			echo $_SESSION['usuarioNome'];
			echo $_SESSION['usuarioERP'];
			header("Refresh: 3, home.php");
		}else{
			echo '<div class="alert alert-danger" role="alert">Usuario ou senha inválidos!!!</div>';
		}

	}catch(PDOException $e){
		echo $e;
	}
}

?>
	<title>ERP - SAPATINO</title>
</head>
<body>
<table width="600" align="center">
	<tr>
		<td width="600" align="center">
		<form action="#" method="post">
    <fieldset>
    <legend>Dados de Login</legend>
        <label for="usuario">Usuário</label>
        <input type="text" name="usuario" id="usuario" maxlength="15" />
        <label for="senha">Senha</label>
        <input type="password" name="senha" id="senha" maxlength="15"/>

        <input align="right" name="logar" type="submit" value="Entrar" />
    </fieldset>
    </form>
		</td>
	</tr>
</table>

</body>
</html>