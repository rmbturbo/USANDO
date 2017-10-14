<?php
if (!isset($_SESSION)) session_start();

if (!isset($_SESSION['usuarioID'])) {
	// Destrói a sessão por segurança
	session_destroy();
	// Redireciona o visitante de volta pro login
	//echo 'sessao nao encontrada';
	header("Location: index.php"); exit;
}

include('includes/header.php');
include('logoff.php');
include('conectadb2.php');

/** Verifica se já é uma busca **/
if (!isset($_GET['inicio']) && !isset($_GET['fim'])) {
	$inicio = date('Y-m-d', strtotime("-15 days"));
	$fim = date('Y-m-d', strtotime("+31 days"));


} else {
	$inicio = $_GET['inicio'];
	$fim = $_GET['fim'];

}
?>

 <script type="text/javascript">
function troca_valor_pgo (id_dup,selecao){
	var cp_valor = '#valor_'+id_dup;
	var valor = $(cp_valor).val();
	var cp_valor_pgo = '#valor_pgo_'+id_dup;
	if (selecao == 'pago'){
		$(cp_valor_pgo).val(valor);
	} else{
		$(cp_valor_pgo).val('0');
	}

}

</script>
<?php
function definecor($situ,$venc){
	$hoje = date('Y-m-d');
	$lastro = date('Y-m-d', strtotime("+15 days"));
	if ($venc < $hoje && $situ != 'pago') {
		$cor = 'style="background-color: #FF9797';
	}elseif ($venc < $lastro && $situ != 'pago'){
		$cor =  'style="background-color: #FEAB6D';
	}else{
		$cor =  'style="background-color: #81FE91';
	}
	echo $cor;
}

function carrega_periodo($inicio,$fim){
	include('conectadb2.php');
	//$busca_existente = 'sim';


	/**
	 * Tipos de consultas viaveis
	 *
	 $sql_leftjoin = "SELECT * FROM `duplicatas` LEFT JOIN `duplicatas.Contas_idContas` = `contas.idContas` LEFT JOIN `contas.NFs_idNFs` = `nfs.idNFs` WHERE (`vencimento` >= '$inicio' AND `vencimento` <= '$fim') ORDER BY date";
	 $sql_inner = "SELECT `duplicatas`.`idDuplicatas`,`duplicatas`.`valor`, `duplicatas`.`valor_pago`, `duplicatas`.`vencimento`, `duplicatas`.`posicao_parcela`, `duplicatas`.`status`, `contas`.`tipo`, `contas`.`qtd_parcelas`, `contas`.`total`, `contas`.`status`
	 FROM `duplicatas` INNER JOIN `contas` ON `duplicatas`.`Contas_idContas` = `contas`.`idContas`;";
	 $sql_inner_total = "SELECT `duplicatas`.*, `contas`.* FROM `duplicatas` INNER JOIN `contas` ON `duplicatas`.`Contas_idContas` = `contas`.`idContas`;"
	 $sql2 = "SELECT * FROM `duplicatas`"
	 $sql_cross_total = "SELECT `duplicatas`.*, `contas`.* FROM `duplicatas` CROSS JOIN `contas`;";
	 $sql_left_total = "SELECT `duplicatas`.*, `contas`.* FROM `duplicatas` LEFT JOIN `contas` ON `duplicatas`.`Contas_idContas` = `contas`.`idContas`;";
	 $sql_left_periodo = "SELECT `duplicatas`.*, `contas`.* FROM `duplicatas` LEFT JOIN `contas` ON `duplicatas`.`Contas_idContas` = `contas`.`idContas` WHERE `duplicatas`.`vencimento` BETWEEN '2016-08-01' AND  '2016-12-31';";
	 $sql_left_dup_cont_nf_periodo = "SELECT `duplicatas`.*, `contas`.*, `nfs`.* FROM `duplicatas` LEFT JOIN `contas` ON `duplicatas`.`Contas_idContas` = `contas`.`idContas` LEFT JOIN `nfs` ON `contas`.`NFs_idNFs` = `nfs`.`idNFs` WHERE `duplicatas`.`vencimento` BETWEEN '2016-08-01' AND  '2016-12-31';";
	 **/



	/**
	$sql_left_completo_periodo = "SELECT `duplicatas`.*,`duplicatas`.`status` AS `situacao` , `contas`.*, `nfs`.*, `sucursal`.*, `fornecedor`.* FROM `duplicatas`
	LEFT JOIN `contas` ON `duplicatas`.`Contas_idContas` = `contas`.`idContas`
	LEFT JOIN `nfs` ON `contas`.`NFs_idNFs` = `nfs`.`idNFs` LEFT JOIN `sucursal` ON `nfs`.`Sucursal_idSucursal` = `sucursal`.`idSucursal`
	LEFT JOIN `fornecedor` ON `nfs`.`Unidade_fornecedor_fornecedor_idFornecedor` = `fornecedor`.`idFornecedor`
	WHERE `duplicatas`.`vencimento` BETWEEN '$inicio' AND  '$fim' ORDER BY `vencimento`;";


	$sql_left_completo_periodo = "SELECT `duplicatas_sem_nfe`.`idDuplicata_sem_nfe` AS `id1`, `duplicatas_sem_nfe`.`valor` AS `valor`, `duplicatas_sem_nfe`.`valor_pago` AS `valor_pago`,
 `duplicatas_sem_nfe`.`vencimento` AS `vencimento`, `duplicatas_sem_nfe`.`posicao_parcela` AS `posicao_parcela`, `duplicatas_sem_nfe`.`status` AS `status`,
  `duplicatas_sem_nfe`.`obs` AS `obs`, `duplicatas_sem_nfe`.`idContas_sem_nfe` AS `idContas_sem_nfe`, `duplicatas_sem_nfe`.`idSucursal` AS `idSucursal`,
  `duplicatas_sem_nfe`.`idUnidade_fornecedor` AS `idUnidade_fornecedor`, `duplicatas_sem_nfe`.`idFornecedor` AS `idFornecedor`, 'Sem NFe' as `idNFe`  FROM `duplicatas_sem_nfe`
  UNION
  SELECT
  `duplicatas`.`idDuplicatas` AS `id1`, `duplicatas`.`valor` AS `valor`, `duplicatas`.`valor_pago` AS `valor_pago`,
   `duplicatas`.`vencimento` AS `vencimento`, `duplicatas`.`posicao_parcela` AS `posicao_parcela`, `duplicatas`.`status` AS `status`,
    `duplicatas`.`obs` AS `obs`, `duplicatas`.`Contas_idContas` AS `idContas`, `duplicatas`.`Contas_NFs_idNFs` AS `idNFe`,
    `duplicatas`.`Contas_NFs_Unidade_fornecedor_idUnidade_fornecedor` AS `idUnidade_fornecedor`,
     `duplicatas`.`Contas_NFs_Unidade_fornecedor_fornecedor_idFornecedor` AS `idFornecedor`, `duplicatas`.`Contas_NFs_Sucursal_idSucursal` AS `idSucursal`
  FROM `duplicatas` WHERE `vencimento` BETWEEN '2015-09-09' AND  '2020-09-09' ORDER BY `vencimento`;";

	**/
	$sql_left_completo_periodo = "SELECT `duplicatas_sem_nfe`.`idDuplicata_sem_nfe` AS `id1`, `duplicatas_sem_nfe`.`valor` AS `valor`, `duplicatas_sem_nfe`.`valor_pago` AS `valor_pago`,
 `duplicatas_sem_nfe`.`vencimento` AS `vencimento`, `duplicatas_sem_nfe`.`posicao_parcela` AS `posicao_parcela`, `duplicatas_sem_nfe`.`status` AS `status`,
  `duplicatas_sem_nfe`.`obs` AS `obs`, `duplicatas_sem_nfe`.`idContas_sem_nfe` AS `idContas_sem_nfe`, `duplicatas_sem_nfe`.`idSucursal` AS `idSucursal`,
  `duplicatas_sem_nfe`.`idUnidade_fornecedor` AS `idUnidade_fornecedor`, `duplicatas_sem_nfe`.`idFornecedor` AS `idFornecedor`, 'Sem NFe' as `idNFe`,`sucursal`.`sigla` AS `sigla`,`contas_sem_nfe`.`numero_doc` AS `numero`,`contas_sem_nfe`.`serie_doc` AS `serie`, `fornecedor`.`fantasia` AS `fantasia`, 'Sem Chave' as `chave`, `contas_sem_nfe`.`qtd_parcelas` AS `qtd_parcelas`
  FROM `duplicatas_sem_nfe`
  LEFT JOIN `sucursal` ON `duplicatas_sem_nfe`.`idSucursal` = `sucursal`.`idSucursal`
  LEFT JOIN `contas_sem_nfe` ON `duplicatas_sem_nfe`.`idContas_sem_nfe` = `contas_sem_nfe`.`idContas_sem_nfe`
  LEFT JOIN `fornecedor` ON `duplicatas_sem_nfe`.`idFornecedor` = `fornecedor`.`idFornecedor`
   WHERE `vencimento` BETWEEN '$inicio' AND  '$fim'
  UNION
  SELECT
  `duplicatas`.`idDuplicatas` AS `id1`, `duplicatas`.`valor` AS `valor`, `duplicatas`.`valor_pago` AS `valor_pago`,
   `duplicatas`.`vencimento` AS `vencimento`, `duplicatas`.`posicao_parcela` AS `posicao_parcela`, `duplicatas`.`status` AS `status`,
    `duplicatas`.`obs` AS `obs`, `duplicatas`.`Contas_idContas` AS `idContas`, `duplicatas`.`Contas_NFs_idNFs` AS `idNFe`,
    `duplicatas`.`Contas_NFs_Unidade_fornecedor_idUnidade_fornecedor` AS `idUnidade_fornecedor`,
     `duplicatas`.`Contas_NFs_Unidade_fornecedor_fornecedor_idFornecedor` AS `idFornecedor`, `duplicatas`.`Contas_NFs_Sucursal_idSucursal` AS `idSucursal`,`sucursal`.`sigla` AS `sigla`,`nfs`.`numero` AS `numero`,'---' AS `serie`, `fornecedor`.`fantasia` AS `fantasia`, `nfs`.`chave` as `chave`, `contas`.`qtd_parcelas` AS `qtd_parcelas`
  FROM `duplicatas`
  LEFT JOIN `sucursal` ON `duplicatas`.`Contas_NFs_Sucursal_idSucursal` = `sucursal`.`idSucursal`
  LEFT JOIN `nfs` ON `duplicatas`.`Contas_NFs_idNFs` = `nfs`.`idNFs`
  LEFT JOIN `fornecedor` ON `duplicatas`.`Contas_NFs_Unidade_fornecedor_fornecedor_idFornecedor` = `fornecedor`.`idFornecedor`
  LEFT JOIN `contas` ON `duplicatas`.`Contas_idContas` = `contas`.`idContas`
  WHERE `vencimento` BETWEEN '$inicio' AND  '$fim' ORDER BY `vencimento`;";

	$resultado = $conectabase->query($sql_left_completo_periodo);
	$qtd = mysqli_num_rows($resultado);
	$total_pago = 0;
	$total_absoluto = 0;


	while ($linha = $resultado->fetch_array()) {
		$total_pago = $total_pago + $linha['valor_pago'];
		$total_absoluto = $total_absoluto + $linha['valor'];
		//echo $linha['idDuplicatas'];
		echo '<tr id="'.$linha['id1'].'" ';
		echo definecor($linha['status'],$linha['vencimento']);
		echo '">
		<td data-nome="'.$linha['id1'].'"><input name="tabela_ou_idnfe[]" id="tabela_ou_idnfe" type="text" hidden value="'.$linha['idNFe'].'"/><input name="id_dup[]" id="id_dup" type="text" hidden value="'.$linha['id1'].'"/>'.$linha['vencimento'].' </td>
		<td>'.$linha['fantasia'].'</td>
		<td>'.$linha['numero'].'</td>
		<td><b>R$ <input name="valor[]" id="valor_'.$linha['id1'].'" type="text" value="'.$linha['valor'].'" readonly size="4" /> </b></td>
		<td>'.$linha['posicao_parcela'].' de '.$linha['qtd_parcelas'].'</td>
		<td>
			<select name="situacao[]" id="situacao_'.$linha['id1'].'"  onchange="var nome = $(this).parent().parent().find(\'td\').data(\'nome\'); troca_valor_pgo(nome,this.value);">
  										<option value="pendente" style="background-color:#FF0000;"';
		if ($linha['status'] == 'pendente') {
			echo 'selected';
		}
		echo '
				>Pendente</option>
  										<option value="boleto recebido" style="background-color:#FFFF00;" ';
		if ($linha['status'] == 'boleto recebido') {
			echo 'selected';
		}
		echo '>Boleto Recebido</option>
  										<option value="pago" style="background-color:#0000FF;" ';
		if ($linha['status'] == 'pago') {
			echo 'selected';
		}
		echo ' >Pago</option>
  										<option value="em cartório" style="color:#FFFF00; background-color:#000000;" ';
		if ($linha['status'] == 'em cartório') {
			echo 'selected';
		}
		echo '>Em cartório</option>
  										<option value="ajuizado" style="color:#FF0000; background-color:#000000;" ';
		if ($linha['status'] == 'ajuizado') {
			echo 'selected';
		}
		echo '>Ajuizado</option>
  									</select>
		</td>
		<td>'.$linha['sigla'].'</td>
		<td><input type="text" size="10" name="valor_pgo[]" id="valor_pgo_'.$linha['id1'].'" value="'.$linha['valor_pago'].'"/></td>
		<td><textarea name="obs[]" rows="2" style="resize: none">'.$linha['obs'].' </textarea></td>
		</tr></div>';
	}
	$total_pendente = $total_absoluto - $total_pago;
echo '  			<tr style="background-color:#8080FF;">
	<td colspan="2"><b>TOTAL Absoluto:</td>
	<td><b>R$'.$total_absoluto.'</td>
  			<td colspan="2"><b>Total Pago:</td>
  			<td  valign="baseline" style="color:Blue;"><b>R$'.$total_pago.'</td>
  			<td colspan="2"><b>Total Pendente:</td>
  			<td  valign="baseline" style="color:Red;"><b>R$'.$total_pendente.'</b></td>
			</tr>';
}



?>


<!-- Trava a tecla enter -->
<script type="text/javascript">
$(document).ready(function () {
	$('input').keypress(function (e) {
		var code = null;
		code = (e.keyCode ? e.keyCode : e.which);
		return (code == 13) ? false : true;
	});
});
</script>

<style>
.preenchido{color:#C0C0C0;}
.preenchido:focus{color:#C0C0C0;}
</style>
</head><body>
<?php
include('functions/functions.php');
include('functions/funcoes_chave.php');
if (isset($_GET['retorno'])) {
	$retorno = $_GET['retorno'];
	//Area dedicada aos avisos de feedback
	if($retorno =='sucesso'){
		echo '<div class="alert alert-success" role="alert"> <b>As duplicatas foram alteradas com sucesso.</div>';
	} elseif($retorno =='fracasso'){
		echo '<div class="alert alert-danger" role="alert"><b>Erro ao alterar duplicatas, contacte o administrador </b></div>';
	} else{
		include_once('conectadb2.php');
		$erro = 'Erro: '. $conectabase->errno .'-'. $conectabase->error;
		echo '<div class="alert alert-danger" role="alert">'.$erro.' ao alterar as duplicatas </div>';
	}
}

//echo '<div class="alert alert-success" role="alert">Bem vindo ao ERP Sapatino '.$usuario. '</div>';
//INCLUI A TOPO.PHP QUE CAPTARA A VARIAL SESSION QUE DIRA QUAL TOPO SERA ENVIADO
include('includes/topo.php');

?>

<div class="container span12 text-center col-md-10 col-md-offset-3" style="margin: 0 auto;float: none;">

	<div class="panel panel-default">
		<div class="panel-heading">Selecione o Periodo</div>

		<div class="panel-body">
			<form name="intervalo">
			<label for="inicio">Inicio: </label><input name="inicio" id="inicio" type="date" value="<?php echo $inicio; ?>"/>
			<label for="fim">  Fim: </label><input name="fim" id="fim" type="date" value="<?php echo $fim; ?>" />
			<p align="center"><input type="submit" value="Buscar"/></p>
			</form>
		</div>

	</div>

	<div class="panel panel-default">
		<div class="panel-heading">De <?php echo $inicio; ?> Até <?php echo $fim; ?></div>
<form name="altera_pgtos" method="post" action="atualiza_conta_a_pagar.php?inicio=<?php echo $inicio;?>&fim=<?php echo $fim; ?>">
		<div class="panel-body">
		  <!-- Table -->
  			<table class="table">
  			<tr style="background-color:#8080FF;">
  				<td><b>Vencimento</b></td>
  				<td><b>Fornecedor</b></td>
  				<td><b>NF</b></td>
  				<td><b>Valor</b></td>
  				<td><b>Parcela</b></td>
  				<td><b>Situação</b></td>
  				<td><b>Loja</b></td>
  				<td><b>Valor Pago</b></td>
  				<td>Obs.</td>
			</tr>
							<?php
								carrega_periodo($inicio,$fim );
							?>

  			</table>

				<input type="submit" value="Salvar alterações"/>

		</div>
	</form>
	</div>

</div>
</body>
</html>