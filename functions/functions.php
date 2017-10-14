<?php
function testa_se_tem_doc($tipo_doc,$numero_documento,$id_fornecedor){
	require('conectadb2.php');
	switch ($tipo_doc) {
		case "nfe":
			return TRUE;
			//echo 'é uma nfe';
			break;
		default:
			$sql_teste = "SELECT * FROM `contas_sem_nfe` WHERE `numero_doc` = '$numero_documento' AND `idFornecedor` = '$id_fornecedor' LIMIT 1;";
			$resultado_teste = $conectabase->query($sql_teste);
			$qtd = mysqli_num_rows($resultado_teste);
			if ($qtd > 0) {
				return FALSE;
			}else{
				return TRUE;
			}
		}
}

function converte_numero_decimais($get_valor) {
	$source = array('.', ',');
	$replace = array('', '.');
	$valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
	return $valor; //retorna o valor formatado para gravar no banco
}

function ajusta_data_to_mysql($data){
	$dia = substr($data,0,2);
	$mes = substr($data,3,2 );
	$ano = substr($data,6,2 );

	$data_mysql = '20'.$ano.'-'.$mes.'-'.$dia;
	return $data_mysql;

}

function limpa_input_chave($chave){
	if(!(is_nan($chave))) {
	return $chave;
	}else{

	$c1=substr($chave,0,4);
	$c2=substr($chave,5,4);
	$c3=substr($chave,10,4);
	$c4=substr($chave,15,4);
	$c5=substr($chave,20,4);
	$c6=substr($chave,25,4);
	$c7=substr($chave,30,4);
	$c8=substr($chave,35,4);
	$c9=substr($chave,40,4);
	$c10=substr($chave,45,4);
	$c11=substr($chave,50,4);
	$chave_ok = "{$c1}{$c2}{$c3}{$c4}{$c5}{$c6}{$c7}{$c8}{$c9}{$c10}{$c11}";

	return $chave_ok;
	}
	}

function lista_sucursal(){


	require('conectadb2.php');
	$sqls= " SELECT * FROM `sucursal` ORDER BY `sigla`";
	//$result = mysqli_query($sqlforn) or die (mysql_error());
	$querys = $conectabase->query($sqls);
	$totals = mysqli_num_rows($querys);

	while ($linhas = $querys->fetch_array()) {
		echo "<option value=".$linhas['idSucursal'].">".$linhas['sigla']." - ".$linhas['cnpj'] ."</option>";
	//	$conectabase->close();
	}
}

function lista_sucursal_bootstrap(){


	require('conectadb2.php');
	$sqls= " SELECT * FROM `sucursal` ORDER BY `sigla`";
	//$result = mysqli_query($sqlforn) or die (mysql_error());
	$querys = $conectabase->query($sqls);
	$totals = mysqli_num_rows($querys);

	while ($linhas = $querys->fetch_array()) {

    	echo '<li><input class="por_sucursal" name="por_sucursal[]" value="'.$linhas['idSucursal'].'" type="checkbox" aria-label="por_situacao"> '.$linhas['sigla'].'</li>';
	//	$conectabase->close();
	}
}

function lista_marcas(){

	require('conectadb2.php');
	$sqlmarca= " SELECT * FROM `marcas` ORDER BY `nome_marca`";
	//$result = mysqli_query($sqlforn) or die (mysql_error());
	$querym = $conectabase->query($sqlmarca);
	$totalm = mysqli_num_rows($querym);
	echo '<option value="">Selecione...</option>';
	while ($linham = $querym->fetch_array()) {
		echo "<option value=".$linham['idMarca'].">".$linham['nome_marca']."</option>";
		//$conectabase->close();

	}
}


function lista_fornecedor(){
	require('conectadb2.php');
	$sqlforn= " SELECT * FROM `fornecedor` ORDER BY `fantasia`";
	//$result = mysqli_query($sqlforn) or die (mysql_error());
	$queryf = $conectabase->query($sqlforn);
	$totalf = mysqli_num_rows($queryf);
	echo '<option value="">Selecione...</option>';
	while ($linhaf = $queryf->fetch_array()) {
		echo "<option value=".$linhaf['idFornecedor'].">".$linhaf['fantasia']."</option>";
		//$conectabase->close();

	}
}

function lista_fornecedor_booststrap(){
	require('conectadb2.php');
	$sqlforn= " SELECT * FROM `fornecedor` ORDER BY `fantasia`";
	//$result = mysqli_query($sqlforn) or die (mysql_error());
	$queryf = $conectabase->query($sqlforn);
	$totalf = mysqli_num_rows($queryf);
	while ($linhaf = $queryf->fetch_array()) {
			echo '<li><input  class="por_fornecedor" name="por_fornecedor[]" value="'.$linhaf['idFornecedor'].'" type="checkbox" aria-label="por_fornecedor"> '.$linhaf['fantasia'].'</li>';
		//$conectabase->close();

	}
}


function lista_forn(){

	require_once('conectadb2.php');
	$sqlforn= " SELECT * FROM `fornecedor` ORDER BY `fantasia`";
	//$result = mysqli_query($sqlforn) or die (mysql_error());
	$queryf = $conectabase->query($sqlforn);
	$totalf = mysqli_num_rows($queryf);
		echo '<option value="">Selecione...</option>';
	while ($linhaf = $queryf->fetch_array()) {
		echo "<option value=".$linhaf['idFornecedor'].">".$linhaf['fantasia']."</option>";
		//$conectabase->close();

	}
}



/** onde eu chamei essa tralha, pq é iqual a de cima????
function lista_fornecedor(){
	require_once('conectadb2.php');
	$sqlforn= " SELECT * FROM `fornecedor` ORDER BY `fantasia`";
	//$result = mysqli_query($sqlforn) or die (mysql_error());
	$query = $conectabase->query($sqlforn);
	$total = mysqli_num_rows($query);

	for ($i = 0; $i < $total; $i++) {
		$dados = $query->fetch_array();
		$arrayForn[$dados['forn']] = $dados['fantasia'];
		foreach ($arrayForn as $value => $name) {
			echo "<option value='{$value}'>{$name}</option>";

	}
/**
	while ($linha = $query->fetch_array()) {
		echo "<option value=".$linha['fantasia'].">".$linha['fantasia']."</option>";
	}

}
}
**/

function lista_unidade_forn($fornecedor_id){
	require_once('conectadb2.php');
	$sqlforn= " SELECT * FROM `fornecedor` ORDER BY `fantasia`";
	$sql_uni_forn=" SELECT * FROM `unidade_fornecedor` ORDER BY `fornecedor_id`";
	//$result = mysqli_query($sqlforn) or die (mysql_error());

	$query1 = $conectabase->query($sqlforn);
	$query2 = $conectabase->query($sql_uni_forn);
	$li_uni_forn = $query2->fetch_array();

	$total = mysqli_num_rows($query1);
	$li_forn = $query1->fetch_array();

	while ($linha = $query1->fetch_array()) {
		echo "<option value=\"".$linha['fantasia']."\"'>".$linha['fantasia']."</option>";
	}

	while ($li_forn['id'] == $li_uni_forn['fornecedor_id']) {

	}
}

function busca_dados_unit_forn_by_cnpj($cnpj){
	//$cnpj = "90312133000439";
	include('../conectadb2.php');
	$sql = "SELECT * FROM unidade_fornecedor WHERE cnpj = $cnpj";
	$res = $conectabase->query($sql);
	$num = mysqli_num_rows($res);
	$unidade_fornecedor = $res->fetch_array();
	if ($num == 1) {
		return $unidade_fornecedor;
	} else {
		//echo '<a href="cadastra_unidade_fornecedor" >Cadastre</a> a unidade do fornecedor'
		return FALSE;
	}
}
//$cnpj = "74261884001146";
//busca_dados_forn_by_cnpj($cnpj);

/** Retorna os dados do fornecedor em caso de sucesso ou FALSE em caso de fracasso **/
function busca_dados_forn_by_cnpj($cnpj){

	include('../conectadb2.php');
	if (busca_dados_unit_forn_by_cnpj($cnpj)==false) {

		return FALSE;
		// echo 'não há fornecedor cadastrado com esse cnpj'

	} else {
		$fornecedor_id = busca_dados_unit_forn_by_cnpj($cnpj)['fornecedor_idFornecedor'];

		$sql2 = "SELECT * FROM fornecedor WHERE idFornecedor = $fornecedor_id";
		$res2 = $conectabase->query($sql2);
		$num2 = mysqli_num_rows($res2);
		$fornecedor = $res2->fetch_array();
		if ($num2 == 1) {

			return $fornecedor;

		} else{
			return false;
			//echo "mais de um cadastro de fornecedor ligado neste cnpj. avise o Romulo";
		}
	}
}

function limpa_input_cnpj($cnpj_suja){
	$cnpj = substr($cnpj_suja,0,2).substr($cnpj_suja,3,3 ).substr($cnpj_suja,7,3).substr($cnpj_suja,11,4).substr($cnpj_suja,16,2 );
	return $cnpj;
}


function limpa_input_cep($cep_sujo){
	$cep = substr($cep_sujo,0,5).substr($cep_sujo,6,3);
	return $cep;
}


?>