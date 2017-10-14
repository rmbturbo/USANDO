<?php

$or = $_GET['or'];
//$or=2;

//require('../..conectadb2.php');
//include('../../functions/functions.php');

function insere_unidade_forn(){
	require('../../conectadb2.php');
	include('../../functions/functions.php');
	/** captura e trata as variaveis **/
	$razao = strtoupper($_POST['razao']);
	$cnpj = limpa_input_cnpj($_POST['cnpj']);
	$insc_est = $_POST['insc_est'];

	$logradouro = strtoupper($_POST['logradouro']);
	$numero = $_POST['numero'];
	$complemento = $_POST['complemento'];
	$CEP = limpa_input_cep($_POST['CEP']);
	$UF = strtoupper($_POST['UF']);
	$cidade = strtoupper($_POST['cidade']);
	$bairro = strtoupper($_POST['bairro']);

	$email = strtoupper($_POST['email']);
	$tel1 = $_POST['tel1'];
	$tel2 = $_POST['tel2'];
	$fax = $_POST['fax'];

	$obs = $_POST['obs'];

	$status = 'A';

	$fornecedor_id = $_POST['fornecedor'];
	/**   **/

	/** Busca o nome do fornecedor **/
	$sql_pega_nome = "SELECT * FROM `fornecedor` WHERE `idFornecedor` = $fornecedor_id";
	$query_pega_nome = $conectabase->query($sql_pega_nome);
	$resultado = $query_pega_nome->fetch_array();
	$nome = $resultado['fantasia'];
	/** **/

	/** vamos verificar aqui se o fornecedor já não esta cadastrado **/
	$sql_consulta_existencia = "SELECT * FROM `unidade_fornecedor` WHERE `cnpj` = '$cnpj'";
	$query0 = $conectabase->query($sql_consulta_existencia);
	$qtd0 = mysqli_num_rows($query0);
	if ($qtd0 > 0) {
		// ele ja existe
		$url_ex = '../../insere_fornecedor.php?retorno=excesso&forn='.$cnpj.'&nome='.$nome;
		return header("location: $url_ex");
	} else {
		//ele nao existe - vamos cadastra-lo
		$sql_insert_forn = "INSERT INTO `unidade_fornecedor`(`razao`, `cnpj`, `insc_est`, `obs`, `nome_logradouro`, `numero`,
 		`complemento`, `CEP`, `UF`, `cidade`, `email`, `tel1`, `tel2`, `fax`, `status`, `fornecedor_idFornecedor`, `bairro`)
 		 VALUES ('$razao','$cnpj','$insc_est','$obs','$logradouro','$numero','$complemento','$CEP','$UF','$cidade','$email','$tel1','$tel2','$fax','$status','$fornecedor_id','$bairro');";
		$inserir_unit_forn = $conectabase->query($sql_insert_forn);
		if ($inserir_unit_forn) {
			//echo 'Fornecedor cadastrado com sucesso';
			$url_s = '../../insere_fornecedor.php?retorno=sucesso&forn='.$cnpj.'&nome='.$nome;
			return	header("location: $url_s");
		}else{
			// echo "Erro ao inserir Fornecedor";
			//$erro = 'Erro: ('. $conectabase->errno .') '. $conectabase->error);
			$url_er = '../../insere_fornecedor.php?retorno=serverER&forn='.$cnpj.'&nome='.$nome;
			return	header("location: $url_er");
		}
	}


}


function insere_fornecedor(){
	require('../../conectadb2.php');
	include('../../functions/functions.php');
	$fantasia = $_POST['fantasia'];
	//$fantasia = 'xox';
	$fantasia = strtoupper($fantasia);
	$sqlConsulta = "SELECT * FROM fornecedor WHERE fantasia = '$fantasia'";
	$query = $conectabase->query($sqlConsulta);
	$qtd = mysqli_num_rows($query);
	if($qtd > 0){
		$url_ex = '../../insere_nome_fornecedor.php?retorno=excesso&nome='.$fantasia;
		return header("location: $url_ex");
	}else{
		// faz inserção
		$sql = "INSERT INTO `fornecedor` (`fantasia`) VALUES ('$fantasia') ";
		$query2 = $conectabase->query($sql);
		if ($query2) {
			$url_s = '../../insere_nome_fornecedor.php?retorno=sucesso&nome='.$fantasia;
			return	header("location: $url_s");
		} else{
			$url_er = '../../insere_nome_fornecedor.php?retorno=serverER&nome='.$fantasia;
			return	header("location: $url_er");
		}
	}
}

function insere_fornecedorPOP(){
	require('../../conectadb2.php');
	include('../../functions/functions.php');
	$fantasia = $_POST['fantasia'];
	//$fantasia = 'xox';
	$fantasia = strtoupper($fantasia);
	$sqlConsulta = "SELECT * FROM fornecedor WHERE fantasia = '$fantasia'";
	$query = $conectabase->query($sqlConsulta);
	$qtd = mysqli_num_rows($query);
	if($qtd > 0){
		echo 'Esse nome de Fornecedor já está cadastrado';
		echo '<button onclick="window.close()">Continuar...</button>';
	}else{
		// faz inserção
		$sql = "INSERT INTO `fornecedor` (`fantasia`) VALUES ('$fantasia') ";
		$query2 = $conectabase->query($sql);
		if ($query2) {
			echo 'Nome do fornecedor inserido.';
			echo '<button onclick="window.close()">Continuar...</button>';
		} else{
			die('Erro: ('. $conectabase->errno .') '. $conectabase->error);
		}
	}
}



if ($or==1) {
	insere_unidade_forn();
} elseif ($or==2){
	insere_fornecedorPOP();
}elseif ($or==3){
	insere_fornecedor();
}else{
	echo 'OOOPS????? Q Q taix aqui loco?';
}



?>

