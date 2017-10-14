<?php

require('../../conectadb2.php');

$apelido = $_POST['apelido'];
$nome = $_POST['nome'];
$tel1 = $_POST['tel1'];
$tel2 = $_POST['tel2'];
$tel3 = $_POST['tel3'];
$tel4 = $_POST['tel4'];
$email = $_POST['email'];
$site = $_POST['site'];
$obs = $_POST['obs'];

$fornecedores = $_POST['fornecedor'];


$marcas = $_POST['marca'];



function ultimo_rep(){
	require('../../conectadb2.php');
	$sql = "SELECT `idRepresentante` FROM `representantes` ORDER BY `idRepresentante` DESC LIMIT 1";
	$qry = $conectabase->query($sql);
	$arr_id_rep = $qry->fetch_array();
	$id_rep = $arr_id_rep['idRepresentante'];
	return $id_rep;

}

function insere_repres($apelido,$nome,$tel1,$tel2,$tel3,$tel4,$email,$site,$obs){
	require('../../conectadb2.php');
	$sql_in_rep = "INSERT INTO `representantes`(`apelido`, `nome`, `tel1`, `tel2`, `tel3`, `tel4`, `email`, `site`, `obs`)
	 VALUES ('$apelido','$nome','$tel1','$tel2','$tel3','$tel4','$email','$site','$obs')";
	$qry_in_rep = $conectabase->query($sql_in_rep);
	if ($qry_in_rep) {
		return TRUE;
	}else{
		return FALSE;
	}

}

function insere_marca_has_rep($marcas){
	require('../../conectadb2.php');
	$id_representante = ultimo_rep();
	$num_marcas = count($marcas);

	$sql_in_marca_rep = "INSERT INTO `marcas_has_representantes`(`marcas_idMarca`, `representantes_idRepresentante`) VALUES ";
	if ($num_marcas > 0) {
		$i=0;
		while($i<$num_marcas){
			$id_marca = $marcas[$i];
			$sql_in_marca_rep .= "('$id_marca', $id_representante), ";
			$i++;
		}
		$sql_in_marca_rep = substr($sql_in_marca_rep,0,-2 );
		$qry_in_marca_rep = $conectabase->query($sql_in_marca_rep);
		if ($qry_in_marca_rep) {
			return TRUE;
		} else {
			//$erro = $conectabase->errno.' - '.$conectabase->error;
			//return $erro;
			return FALSE;
		}
	} else {
		//$erro = $conectabase->errno.' - '.$conectabase->error;
		//return $erro;
		return FALSE;
	}

}

function insere_rep_has_forn($fornecedores){
	require('../../conectadb2.php');
	$id_representante = ultimo_rep();
	$num_forn = count($fornecedores);
	$sql_in_rep_h_forn = "INSERT INTO `representantes_has_fornecedor`(`representantes_idRepresentante`, `fornecedor_idFornecedor`) VALUES ";

	if($num_forn > 0){
		$i=0;
		while($i<$num_forn){
			$id_forn = $fornecedores[$i];
			$sql_in_rep_h_forn .= "('$id_representante','$id_forn'), ";
			$i++;
		}
		$sql_in_rep_h_forn = substr($sql_in_rep_h_forn,0,-2 );
		$qry_in_rep_h_forn = $conectabase->query($sql_in_rep_h_forn);
		if ($qry_in_rep_h_forn) {
			return TRUE;
		} else{
			return FALSE;
		}
	} else{
		return FALSE;
	}

}

if (insere_repres($apelido,$nome,$tel1,$tel2,$tel3,$tel4,$email,$site,$obs) === FALSE) {
	$url = '../../cad_representante.php?retorno=fracasso1&repre='.$apelido;
	//echo $url;
	header("location: $url");

} elseif(insere_marca_has_rep($marcas)=== FALSE){
	$ultimo_rep = ultimo_rep();
	$url = '../../cad_representante.php?retorno=fracasso2&repre='.$apelido;
	$sql_del_repres = "DELETE FROM `representantes` WHERE `idRepresentante` = '$ultimo_rep'";
	mysqli_query($conectabase,$sql_del_repres);
	//echo $url;
	//echo insere_marca_has_rep($marcas);
	header("location: $url");
} elseif (insere_rep_has_forn($fornecedores)=== FALSE){
	$url = '../../cad_representante.php?retorno=fracasso3&repre='.$apelido;
	//echo $url;
	header("location: $url");
} else {
	$url = '../../cad_representante.php?retorno=sucesso&repre='.$apelido;
	//echo $url;
	header("location: $url");
}



?>