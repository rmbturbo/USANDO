<?php
include('../functions/functions.php');
include('../conectadb2.php');
$cnpj = $_GET['cnpj'];
//$cnpj ="79523098000111";


$arr_forn = busca_dados_forn_by_cnpj($cnpj);
if (busca_dados_forn_by_cnpj($cnpj)==FALSE) {
	include_once('../functions/functions.php');
	lista_forn();
}else{
?>
<option value="<?php echo $arr_forn['idFornecedor'];?>" selected><?php echo $arr_forn['fantasia'];?></option>
<?php
}
?>
