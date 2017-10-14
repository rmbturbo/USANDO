<?php

$id_sucursal = $_POST['sucursal'];
$chave_suja = $_POST['Chave_NF'];
$Num_NF = $_POST['Num_NF'];
$Valor_NF = $_POST['Valor_NF'];
$desconto = $_POST['desconto'];
$Total_Nf = $_POST['Total_Nf'];
$id_fornecedor = $_POST['fornecedor'];
$id_unidade_forn = $_POST['unidade_fornecedor'];
$tipo = $_POST['tipo'];
$vencimentos = $_POST['vencimento'];
$parcelas = $_POST['valor'];

$qtd_vencimentos = count($vencimentos);
$qtd_parcelas = count($parcelas);

if ($qtd_parcelas == $qtd_vencimentos) {



echo $id_sucursal;
echo '<br>';
echo $chave_suja;
echo '<br>';
echo $Num_NF;
echo '<br>';
echo $Valor_NF; //valor sem desconto
echo '<br>';
echo $desconto;
echo '<br>';
echo $Total_Nf;
echo '<br>';
echo $id_fornecedor;
echo '<br>';
echo $id_unidade_forn;
echo '<br>';
echo $tipo;
echo '<br>';
print_r ($vencimentos);
echo '<br>';
print_r ($parcelas);
echo '<br> qtd parcelas = ';
echo $qtd_parcelas;

}else{
	echo 'Truncamento/cruzamento de datas e parcelas';
}

$sql_NF = "INSERT INTO `nfs`(`chave`, `serie`, `numero`, `valor_total`, `valor_bruto`, `desconto`, `status`, `Unidade_fornecedor_idUnidade_fornecedor`, `Unidade_fornecedor_fornecedor_idFornecedor`, `Sucursal_idSucursal`)
VALUES ('$chave_limpa','$serie','$Num_NF','$Total_Nf','$Valor_NF','$desconto','recebida','$id_unidade_forn','$id_fornecedor','$id_sucursal')"

$sql_conta = "INSERT INTO `contas`(`tipo`, `qtd_parcelas`, `total`, `status`, `NFs_idNFs`, `NFs_Unidade_fornecedor_idUnidade_fornecedor`, `NFs_Unidade_fornecedor_fornecedor_idFornecedor`, `NFs_Sucursal_idSucursal`)
VALUES ('$tipo','$qtd_parcelas','pendente',[value-4],[value-5],[value-6],[value-7],[value-8],[value-9])"

?>