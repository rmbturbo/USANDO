<?php
require('../../conectadb2.php');
//$marca = 'BOTTERO';
$marca = $_POST['marca'];
$marca = strtoupper($marca);
//$fornecedores = array(1);
$fornecedores = $_POST['fornecedor'];

function pega_id_marca($nome_marca){
	require('../../conectadb2.php');
	$sql_id_marca = "SELECT `idMarca` FROM `marcas` WHERE `nome_marca` = '$nome_marca'";
	$qry_id_marca = $conectabase->query($sql_id_marca);
	$arr_id_marca = $qry_id_marca->fetch_array();
	$id_marca = $arr_id_marca['idMarca'];
	return $id_marca;
}



function verifica_repetido($nome_marca){
	require('../../conectadb2.php');
	$sql_nome_marca = "SELECT `idMarca` FROM `marcas` WHERE `nome_marca` = '$nome_marca'";
	$qry_nome_marca = $conectabase->query($sql_nome_marca);
	if(mysqli_num_rows($qry_nome_marca) > 0){
		return TRUE;
	} else{
		return FALSE;
	}
}



function insere_marca($marca){
	require('../../conectadb2.php');
	$sql_insere_marca = "INSERT INTO `marcas`(`nome_marca`) VALUES ('$marca')";
	$qry_insere_marca = $conectabase->query($sql_insere_marca);
	if($qry_insere_marca){
		return TRUE;
	} else{
		return FALSE;
	}
}


function insere_marca_has_fornecedor($marca,$fornecedores){
	require('../../conectadb2.php');
	$id_marca = pega_id_marca($marca);

	$sql_in_marca_forn = "INSERT INTO `marcas_has_fornecedor`(`Marcas_idMarca`, `fornecedor_idFornecedor`) VALUES ";

	$qtd_forn = count($fornecedores);
	if ($qtd_forn > 0) {
		$i=0;

		while ($i < $qtd_forn) {

			$forn = $fornecedores[$i];
			$sql_in_marca_forn .= "('$id_marca','$forn'), ";
			$i++;
		}
		$sql_in_marca_forn = substr($sql_in_marca_forn,0,-2 );
		$qry_in_marca_forn = $conectabase->query($sql_in_marca_forn);
		if($qry_in_marca_forn){
			return TRUE;
		}else{
			return FALSE;
		}
	} else {
		return FALSE;
	}


}


if (verifica_repetido($marca) === TRUE) {
	$url = '../../cad_marcas.php?retorno=excesso&marca='.$marca;
	//echo $url;
	header("location: $url");
	//echo $marca;
	//print_r(array_values ($fornecedores));
} elseif (insere_marca($marca) === FALSE){
	$url = '../../cad_marcas.php?retorno=fracasso&marca='.$marca;
	//echo $url;
	//echo $marca;
	//print_r(array_values ($fornecedores));
	header("location: $url");
} elseif (insere_marca_has_fornecedor($marca,$fornecedores) === FALSE){
	$sql_del_marca = "DELETE FROM `marcas` WHERE `nome_marca` = '$marca'";
	mysqli_query($conectabase,$sql_del_marca);
	$url = '../../cad_marcas.php?retorno=fracasso2&marca='.$marca;
	//echo $url;
	//echo $marca;
	//print_r(array_values ($fornecedores));
	header("location: $url");
} else{
	$url = '../../cad_marcas.php?retorno=sucesso&marca='.$marca;
	//echo $url;
	//echo $marca;
	//print_r(array_values ($fornecedores));
	header("location: $url");
}
?>