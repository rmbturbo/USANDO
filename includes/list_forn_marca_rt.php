<?php
require('conectadb2.php');

function lista_marcas_rt(){
	require('conectadb2.php');
	$sqlmarca= " SELECT * FROM `marcas` ORDER BY `nome_marca`";
	//$result = mysqli_query($sqlforn) or die (mysql_error());
	$querym = $conectabase->query($sqlmarca);
	$totalm = mysqli_num_rows($querym);
	$txt1 = '<option value="">Selecione...</option>';
	while ($linham = $querym->fetch_array()) {
		$txt1.= "<option value=".$linham['idMarca'].">".$linham['nome_marca']."</option>";
		//$conectabase->close();

	}
	return $txt1;
}

function lista_forn_rt(){
	require('conectadb2.php');
	$sqlforn= " SELECT * FROM `fornecedor` ORDER BY `fantasia`";
	//$result = mysqli_query($sqlforn) or die (mysql_error());
	$queryf = $conectabase->query($sqlforn);
	$totalf = mysqli_num_rows($queryf);
	$txt1= '<option value="">Selecione...</option>';
	while ($linhaf = $queryf->fetch_array()) {
		$txt1 .= "<option value=".$linhaf['idFornecedor'].">".$linhaf['fantasia']."</option>";
		//$conectabase->close();

	}
	return $txt1;
}


function lista_forn_e_marcas(){


	//$texto1 = lista_marcas();
	//$texto2 = lista_forn();

	$texto1 = '<span id="marcas">
<label for="marca[]">Marca: </label>
<select name="marca[]" id="marca" class="multiselect" multiple="multiple">';
	$testo2 = ' </select> <span> </span>

			</span>
   			<span id="fornecedores">
   			<label for="fornecedor[]">Fornecedor: </label>
   				<select name="fornecedor[]" id="fornecedor" class="multiselect" multiple="multiple" >';
	$texto3 = '</select><br/><br/>
			</span>';
	echo $texto1.lista_marcas_rt().$testo2.lista_forn_rt().$texto3;
}

lista_forn_e_marcas();
?>