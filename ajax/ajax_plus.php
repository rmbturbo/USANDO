<?php
include('../conectadb2.php');
//$cnpj = $_GET['cnpj'];
//$cnpj ="79523098000111";
$f = $_GET['f'];
if ($f=01) {
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
?>
