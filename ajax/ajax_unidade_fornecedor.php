<?php
include('../functions/functions.php');
include_once('../conectadb2.php');
//$cnpj = "74261884001146";
$cnpj = $_GET['cnpj'];

$arr_unit_forn = busca_dados_unit_forn_by_cnpj($cnpj);

if(busca_dados_unit_forn_by_cnpj($cnpj)==FALSE){
	?>
<option value="" selected>CNPJ não cadastrado</option>
	<?php
	//return false;
}else{
?>
<option value="<?php echo $arr_unit_forn['idUnidade_fornecedor'];?>" selected><?php echo $arr_unit_forn['razao'];?> - <?php echo substr($arr_unit_forn['cnpj'],0,2); ?>.<?php echo substr($arr_unit_forn['cnpj'],2,3); ?>.<?php echo substr($arr_unit_forn['cnpj'],5,3); ?>/<?php echo substr($arr_unit_forn['cnpj'],8,4); ?>-<?php echo substr($arr_unit_forn['cnpj'],12,2); ?></option>
<?php
}
?>