<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<?php

include_once('../conectadb2.php');
$fornecedor = $_GET['fornecedor'];  //codigo do fornecedor passado por parametro
$sql = "SELECT * FROM unidade_fornecedor WHERE fornecedor_idFornecedor = $fornecedor ORDER BY razao";  //consulta todas as unidades de fornecedore que possuem o fornecedor_idFornecedor (fk) igual ao id do fornecedor selecionado

$res = $conectabase->query($sql);
$num = mysqli_num_rows($res);




/**
 for ($i = 0; $i < $num; $i++){
 $dados = $res->fetch_array();
 $array_unidades_forn[$dados['id']] = utf8_encode($dados['cnpj']);
 }
 **/
?>

<label>Unidade Fornecedor:</label>

  <?php
while ($linha = $res->fetch_array()) {
	echo "<option value=".$linha['idUnidade_fornecedor'].">".$linha['razao']." - ".substr($linha['cnpj'],0,2).".".substr($linha['cnpj'],2,3).".".substr($linha['cnpj'],5,3)."/".substr($linha['cnpj'],8,4)."-".substr($linha['cnpj'],12,2)."</option>";
}

/**
 foreach($array_unidades_forn as $value => $nome){
 echo "<option value='{$value}'>{$nome}</option>";
 }
 **/
?>

</html>