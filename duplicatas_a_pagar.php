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


function marcador_fornecedor(){
	if ($('#por_fornecedor_all').prop('checked') == true){
		$('.por_fornecedor').each(
		function(){
			$(this).prop('checked', true);
		}
		);
	}else{
		$('.por_fornecedor').each(
		function(){
			$(this).prop('checked', false);
		}
		);
	}
}

function marcador_sucursal(){
	if ($('#por_sucursal_all').prop('checked') == true){
		$('.por_sucursal').each(
		function(){
			$(this).prop('checked', true);
		}
		);
	}else{
		$('.por_sucursal').each(
		function(){
			$(this).prop('checked', false);
		}
		);
	}
}

function marcador_situacao(){
	if ($('#por_situacao_all').prop('checked') == true){
		$('.por_situacao').each(
		function(){
			$(this).prop('checked', true);
		}
		);
	}else{
		$('.por_situacao').each(
		function(){
			$(this).prop('checked', false);
		}
		);
	}
}

function marcador_fp(){
	if ($('#por_fp_all').prop('checked') == true){
		$('.por_fp').each(
		function(){
			$(this).prop('checked', true);
		}
		);
	}else{
		$('.por_fp').each(
		function(){
			$(this).prop('checked', false);
		}
		);
	}
}

function marcador_fp_boletos(){
	if ($('#por_fp_boletos').prop('checked') == true){
		$('.por_fp_boletos').each(
		function(){
			$(this).prop('checked', true);
		}
		);
	}else{
		$('.por_fp_boletos').each(
		function(){
			$(this).prop('checked', false);
		}
		);
	}
}

function marcador_fp_especie(){
	if ($('#por_fp_especie').prop('checked') == true){
		$('.por_fp_especie').each(
		function(){
			$(this).prop('checked', true);
		}
		);
	}else{
		$('.por_fp_especie').each(
		function(){
			$(this).prop('checked', false);
		}
		);
	}
}

function marcador_fp_ted(){
	if ($('#por_fp_ted').prop('checked') == true){
		$('.por_fp_ted').each(
		function(){
			$(this).prop('checked', true);
		}
		);
	}else{
		$('.por_fp_ted').each(
		function(){
			$(this).prop('checked', false);
		}
		);
	}
}

function marcador_fp_doc(){
	if ($('#por_fp_doc').prop('checked') == true){
		$('.por_fp_doc').each(
		function(){
			$(this).prop('checked', true);
		}
		);
	}else{
		$('.por_fp_doc').each(
		function(){
			$(this).prop('checked', false);
		}
		);
	}
}

function marcador_fp_transf(){
	if ($('#por_fp_transf').prop('checked') == true){
		$('.por_fp_transf').each(
		function(){
			$(this).prop('checked', true);
		}
		);
	}else{
		$('.por_fp_transf').each(
		function(){
			$(this).prop('checked', false);
		}
		);
	}
}

function marcador_fp_deposito(){
	if ($('#por_fp_deposito').prop('checked') == true){
		$('.por_fp_deposito').each(
		function(){
			$(this).prop('checked', true);
		}
		);
	}else{
		$('.por_fp_deposito').each(
		function(){
			$(this).prop('checked', false);
		}
		);
	}
}

function marcador_fp_cart_credito(){
	if ($('#por_fp_cart_credito').prop('checked') == true){
		$('.por_fp_cart_credito').each(
		function(){
			$(this).prop('checked', true);
		}
		);
	}else{
		$('.por_fp_cart_credito').each(
		function(){
			$(this).prop('checked', false);
		}
		);
	}
}

function marcador_fp_cart_debito(){
	if ($('#por_fp_cart_debito').prop('checked') == true){
		$('.por_fp_cart_debito').each(
		function(){
			$(this).prop('checked', true);
		}
		);
	}else{
		$('.por_fp_cart_debito').each(
		function(){
			$(this).prop('checked', false);
		}
		);
	}
}

function marcador_fp_outros(){
	if ($('#por_fp_outros').prop('checked') == true){
		$('.por_fp_outros').each(
		function(){
			$(this).prop('checked', true);
		}
		);
	}else{
		$('.por_fp_outros').each(
		function(){
			$(this).prop('checked', false);
		}
		);
	}
}
</script>
 <script type="text/javascript">
function troca_valor_pgo (id_dup,selecao){
	var cp_valor = '#valor_'+id_dup;
	var valor = $(cp_valor).val();
	var cp_valor_pgo = '#valor_pgo_'+id_dup;
	if (selecao == 'pago' || selecao == 'agendado'){
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




	$sql_left_completo_periodo = "SELECT `duplicatas_sem_nfe`.`idDuplicata_sem_nfe` AS `id1`, `duplicatas_sem_nfe`.`valor` AS `valor`, `duplicatas_sem_nfe`.`valor_pago` AS `valor_pago`,
 `duplicatas_sem_nfe`.`vencimento` AS `vencimento`, `duplicatas_sem_nfe`.`posicao_parcela` AS `posicao_parcela`, `duplicatas_sem_nfe`.`status` AS `status`, `duplicatas_sem_nfe`.`form_pg` AS `form_pg`,
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
   `duplicatas`.`vencimento` AS `vencimento`, `duplicatas`.`posicao_parcela` AS `posicao_parcela`, `duplicatas`.`status` AS `status`, `duplicatas`.`form_pg` AS `form_pg`,
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
		$total_pago = $total_pago + floatval($linha['valor_pago']);
		$total_absoluto = $total_absoluto + floatval($linha['valor']);
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
  										<option value="agendado" style="background-color:#80FFFF;" ';
		if ($linha['status'] == 'agendado') {
			echo 'selected';
		}
		echo ' >Agendado</option>
  										<option value="pago" style="background-color:#0000FF;" ';
		if ($linha['status'] == 'pago') {
			echo 'selected';
		}
		echo ' >Pago</option>
  										<option value="em cartorio" style="color:#FFFF00; background-color:#000000;" ';
		if ($linha['status'] == 'em cartorio') {
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

		<td>
			<select name="fp[]" id="fp'.$linha['id1'].'">

			<optgroup label="Boleto (conta débito)">
				<option value="boleto_std_130025250"';
				if ($linha['form_pg'] == 'boleto_std_130025250') {
					echo 'selected';
				}
				echo '
				>CC: STD 13002525-0 </option>

				<option value="boleto_std_130025164"';
				if ($linha['form_pg'] == 'boleto_std_130025164') {
					echo 'selected';
				}
				echo '
				>CC: STD 13002516-4 </option>

				<option value="boleto_std_130028301"';
				if ($linha['form_pg'] == 'boleto_std_130028301') {
					echo 'selected';
				}
				echo '
				>CC: STD 13002830-1 </option>

				<option value="boleto_bb_sapatino"';
				if ($linha['form_pg'] == 'boleto_bb_sapatino') {
					echo 'selected';
				}
				echo '
				>CC: BB SAPATINO </option>

				<option value="boleto_bb_sapatino"';
				if ($linha['form_pg'] == 'boleto_bb_lugbr') {
					echo 'selected';
				}
				echo '
				>CC: BB LuGBR </option>

				<option value="boleto_outros"';
				if ($linha['form_pg'] == 'boleto_outros') {
					echo 'selected';
				}
				echo '
				>OUTROS </option>

			</optgroup>

			<optgroup label="Especie">
				<option value="especie_cheque_std"';
				if ($linha['form_pg'] == 'especie_cheque_std') {
					echo 'selected';
				}
				echo '
				>Cheque  STD</option>
				<option value="especie_cheque_bb"';
				if ($linha['form_pg'] == 'especie_cheque') {
					echo 'selected';
				}
				echo '
				>Cheque  BB</option>
				<option value="especie_real"';
				if ($linha['form_pg'] == 'especie_real') {
					echo 'selected';
				}
				echo '
				>REAL (R$) </option>

				<option value="especie_dolar"';
				if ($linha['form_pg'] == 'especie_dolar') {
					echo 'selected';
				}
				echo '
				>Dolar (U$) </option>

				<option value="especie_outros"';
				if ($linha['form_pg'] == 'especie_outros') {
					echo 'selected';
				}
				echo '
				>Outro (*$) </option>

			</optgroup>

			<optgroup label="TED (conta débito)">
				<option value="ted_std_130025250"';
				if ($linha['form_pg'] == 'ted_std_130025250') {
					echo 'selected';
				}
				echo '
				>TED: STD 13002525-0 </option>

				<option value="ted_std_130025164"';
				if ($linha['form_pg'] == 'ted_std_130025164') {
					echo 'selected';
				}
				echo '
				>TED: STD 13002516-4 </option>

				<option value="ted_std_130028301"';
				if ($linha['form_pg'] == 'ted_std_130028301') {
					echo 'selected';
				}
				echo '
				>TED: STD 13002830-1 </option>

				<option value="ted_bb_sapatino"';
				if ($linha['form_pg'] == 'ted_bb_sapatino') {
					echo 'selected';
				}
				echo '
				>TED: BB SAPATINO </option>

				<option value="ted_bb_sapatino"';
				if ($linha['form_pg'] == 'ted_bb_lugbr') {
					echo 'selected';
				}
				echo '
				>TED: BB LuGBR </option>

				<option value="ted_outros"';
				if ($linha['form_pg'] == 'ted_outros') {
					echo 'selected';
				}
				echo '
				>OUTROS </option>

			</optgroup>

			<optgroup label="DOC (conta débito)">
				<option value="doc_std_130025250"';
				if ($linha['form_pg'] == 'doc_std_130025250') {
					echo 'selected';
				}
				echo '
				>DOC: STD 13002525-0 </option>

				<option value="doc_std_130025164"';
				if ($linha['form_pg'] == 'doc_std_130025164') {
					echo 'selected';
				}
				echo '
				>DOC: STD 13002516-4 </option>

				<option value="doc_std_130028301"';
				if ($linha['form_pg'] == 'doc_std_130028301') {
					echo 'selected';
				}
				echo '
				>DOC: STD 13002830-1 </option>

				<option value="doc_bb_sapatino"';
				if ($linha['form_pg'] == 'doc_bb_sapatino') {
					echo 'selected';
				}
				echo '
				>DOC: BB SAPATINO </option>

				<option value="doc_bb_sapatino"';
				if ($linha['form_pg'] == 'doc_bb_lugbr') {
					echo 'selected';
				}
				echo '
				>DOC: BB LuGBR </option>

				<option value="doc_outros"';
				if ($linha['form_pg'] == 'doc_outros') {
					echo 'selected';
				}
				echo '
				>OUTROS </option>

			</optgroup>

			<optgroup label="TRANSF. (conta débito)">
				<option value="transf_std_130025250"';
				if ($linha['form_pg'] == 'transf_std_130025250') {
					echo 'selected';
				}
				echo '
				>TRANSF.: STD 13002525-0 </option>

				<option value="transf_std_130025164"';
				if ($linha['form_pg'] == 'transf_std_130025164') {
					echo 'selected';
				}
				echo '
				>TRANSF.: STD 13002516-4 </option>

				<option value="transf_std_130028301"';
				if ($linha['form_pg'] == 'transf_std_130028301') {
					echo 'selected';
				}
				echo '
				>TRANSF.: STD 13002830-1 </option>

				<option value="transf_bb_sapatino"';
				if ($linha['form_pg'] == 'transf_bb_sapatino') {
					echo 'selected';
				}
				echo '
				>TRANSF.: BB SAPATINO </option>

				<option value="transf_bb_sapatino"';
				if ($linha['form_pg'] == 'transf_bb_lugbr') {
					echo 'selected';
				}
				echo '
				>TRANSF.: BB LuGBR </option>

				<option value="transf_outros"';
				if ($linha['form_pg'] == 'transf_outros') {
					echo 'selected';
				}
				echo '
				>OUTROS</option>

			</optgroup>
			<optgroup label="Depósito">
				<option value="deposito_boca_caixa"';
				if ($linha['form_pg'] == 'deposito_boca_caixa') {
					echo 'selected';
				}
				echo '
				>Boca de caixa</option>

				<option value="deposito_caixa_eletronico"';
				if ($linha['form_pg'] == 'deposito_caixa_eletronico') {
					echo 'selected';
				}
				echo '
				>Caixa eletrônico </option>
			</optgroup>

			<optgroup label="Cartão de crédito">
				<option value="ccredito_std_corp_130025164"';
				if ($linha['form_pg'] == 'ccredito_std_corp_130025164') {
					echo 'selected';
				}
				echo '
				>Visa STD Business (***3048)</option>

				<option value="ccredito_pag_seguro_lag"';
				if ($linha['form_pg'] == 'ccredito_pag_seguro_lag') {
					echo 'selected';
				}
				echo '
				>Master PagSeguro (***6205)</option>

				<option value="ccredito_bb_sptno_corp"';
				if ($linha['form_pg'] == 'ccredito_bb_sptno_corp') {
					echo 'selected';
				}
				echo '
				>Visa BB corporativo Sapatino</option>

				<option value="ccredito_bb_lugbr_corp"';
				if ($linha['form_pg'] == 'ccredito_bb_lugbr_corp') {
					echo 'selected';
				}
				echo '
				>Visa BB corporativo LuGBr</option>

				<option value="ccredito_outros"';
				if ($linha['form_pg'] == 'ccredito_outros') {
					echo 'selected';
				}
				echo '
				>Outros</option>

			</optgroup>

			<optgroup label="Cartão de débito">

				<option value="cdebito_mast_std_130025250"';
				if ($linha['form_pg'] == 'cdebito_mast_std_130025250') {
					echo 'selected';
				}
				echo '
				>Master STD ***2259</option>

				<option value="cdebito_mast_std_130025164"';
				if ($linha['form_pg'] == 'cdebito_mast_std_130025164') {
					echo 'selected';
				}
				echo '
				>Master STD ***7266</option>

				<option value="cdebito_mast_std_130028301"';
				if ($linha['form_pg'] == 'cdebito_mast_std_130028301') {
					echo 'selected';
				}
				echo '
				>Master STD ***0497</option>

				<option value="cdebito_outros"';
				if ($linha['form_pg'] == 'cdebito_outros') {
					echo 'selected';
				}
				echo '
				>Outros</option>
			</optgroup>

			<optgroup label="OUTROS">
				<option value="outros_vt"';
				if ($linha['form_pg'] == 'outros_vt') {
					echo 'selected';
				}
				echo '
				>Vale Transporte</option>

				<option value="outros_va"';
				if ($linha['form_pg'] == 'outros_va') {
					echo 'selected';
				}
				echo '
				>Vale Alimentação </option>

				<option value="outros_outros"';
				if ($linha['form_pg'] == 'outros_outros') {
					echo 'selected';
				}
				echo '
				>Outros </option>

			</optgroup>

			</select>
		</td>
		<td><input type="text" size="10" name="valor_pgo[]" id="valor_pgo_'.$linha['id1'].'" value="'.$linha['valor_pago'].'"/></td>

		<td><textarea name="obs[]" rows="2" style="resize: none">'.$linha['obs'].' </textarea></td>
		</tr></div>';
	}
	$total_pendente = $total_absoluto - $total_pago;
        if ($total_pendente < 0){
            $aviso = " Foi pago alem do esperado: ";
            $alem_do_esperado = abs($total_pendente);
            $total_pendente = 0;
                    
        }else {
            $aviso = ''; 
            $alem_do_esperado = '';
        }
echo '  			<tr style="background-color:#8080FF;">
	<td colspan="2"><b>TOTAL Absoluto:</td>
	<td><b>R$'.$total_absoluto.'</td>
  			<td colspan="2"><b>Total Pago:</td>
  			<td  valign="baseline" style="color:Blue;"><b>R$'.$total_pago.'</td>
  			<td ><b>Total Pendente:</td>
  			<td  valign="baseline" style="color:Red;"><b>R$'.$total_pendente.'</b></td>
                        <td colspan="2" valign="baseline" style="color:Red;"><b>'.$aviso.'R$ '.$alem_do_esperado.'</td>
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
	switch ($retorno) {
		case "sucesso":
			echo '<div class="alert alert-success" role="alert"> <b>As duplicatas foram alteradas com sucesso.</div>';
			break;
		case "fracasso":
			echo '<div class="alert alert-danger" role="alert"><b>Erro ao alterar duplicatas, contacte o administrador </b></div>';
			break;
		case "erro_data":
			echo '<div class="alert alert-danger" role="alert"><b>Erro: Data indefinida, contacte o administrador </b></div>';
			break;
		case "falta_detalhe":
			echo '<div class="alert alert-danger" role="alert"><b>Erro: Não foram definidos todos os detalhes para a busca! Preencha os campos de detalhe corretamente. </b></div>';
			break;
		case "sem_o":
			echo '<div class="alert alert-danger" role="alert"><b>Erro: variavel não definida corretamente. </b></div>';
			break;
		default:
			include_once('conectadb2.php');
			$erro = 'Erro: '. $conectabase->errno .'-'. $conectabase->error;
			echo '<div class="alert alert-danger" role="alert">'.$erro.' ao alterar as duplicatas </div>';
	} // switch
}

//echo '<div class="alert alert-success" role="alert">Bem vindo ao ERP Sapatino '.$usuario. '</div>';
//INCLUI A TOPO.PHP QUE CAPTARA A VARIAL SESSION QUE DIRA QUAL TOPO SERA ENVIADO
include('includes/topo.php');

?>

<div class="container span12 text-center col-md-12 col-md-offset-12" style="margin: 0 auto;float: none;">

	<div class="panel panel-default">
		<div class="panel-heading">Selecione o Periodo</div>

		<div class="panel-body">
			<form name="intervalo">
			<label for="inicio">Inicio: </label><input name="inicio" id="inicio" type="date" value="<?php echo $inicio; ?>" onchange="$('#inicio_detalhe').val($(this).val());" />
			<label for="fim">  Fim: </label><input name="fim" id="fim" type="date" value="<?php echo $fim; ?>" onchange="$('#fim_detalhe').val($(this).val());"/>
			<p align="center"><input type="submit" value="Buscar" name="buscar" id="buscar"/> </p>
			</form>
			<div class="row">
  				<div class="col-md-7" align="right"><input type="button" value="Mais Detalhes" onclick="$('#buscar').css('display','none');$('#mais_detalhes').css('display','block'); $('#menos_detalhes').css('display','block'); $('#por_sucursal').attr('disabled', false);$('#por_fornecedor').attr('disabled', false);$('#por_situacao').attr('disabled', false);$('#por_form_pag').attr('disabled', false);  $('#inicio_detalhe').attr('disabled', false);$('#fim_detalhe').attr('disabled', false);"/></div>
 				<div class="col-md-5" align="left"><input id="menos_detalhes" type="button" value="<<" onclick="$(this).css('display','none');$('#buscar').css('display','block');$('#buscar').css('display','block');$('#mais_detalhes').css('display','none');$('#por_sucursal').attr('disabled', true);$('#por_fornecedor').attr('disabled', true);$('#por_situacao').attr('disabled', true);$('#por_form_pag').attr('disabled', true); $('#inicio_detalhe').attr('disabled', true);$('#fim_detalhe').attr('disabled', true);" style="display:none;"/></div>
			</div>
			<form name="com_detalhes" id="com_detalhes" method="post" action="busca_detalhada_duplicatas.php?o=x">
				<input type="date" name="inicio_detalhe" id="inicio_detalhe" value="<?php echo $inicio; ?>" hidden/>
				<input type="date" name="fim_detalhe" id="fim_detalhe" value="<?php echo $fim; ?>" hidden/>
			 <P>

			<div class="row" id="mais_detalhes" style="display:none;">


				<div class="col-md-3">
				<div class="dropdown">
		  			<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    					Sucursal
   					 <span class="caret"></span>
		  			</button>
  					<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
  						<li><input id="por_sucursal_all" name="por_sucursal_all" type="checkbox" aria-label="por_sucursal_all" onclick="marcador_sucursal();"> TODAS</li>
					<?php lista_sucursal_bootstrap(); ?>
					</ul>
				</div>
				</div>

				<div class="col-md-3">
				<div class="dropdown">
		  			<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    					Fornecedor
   					 <span class="caret"></span>
		  			</button>
  					<ul id="grupo_por_fornecedor" class="dropdown-menu" aria-labelledby="dropdownMenu1">
  						<li><input id="por_fornecedor_all" name="por_fornecedor_all" type="checkbox" aria-label="por_fornecedor_all" onclick="marcador_fornecedor();"> TODOS</li>
					<?php lista_fornecedor_booststrap(); ?>
					</ul>
				</div>
				</div>

				<div class="col-md-3">
				<div class="dropdown">
  					<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    				Situação
   					 <span class="caret"></span>
				  	</button>
  					<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
  						<li><input id="por_situacao_all" name="por_situacao_all" type="checkbox" aria-label="por_situacao_all" onclick="marcador_situacao();"> TODAS</li>
    					<li><input class="por_situacao" name="por_situacao[]" value="pendente" type="checkbox" aria-label="pendente"> Pendente</li>
    					<li><input class="por_situacao" name="por_situacao[]" value="boleto recebido" type="checkbox" aria-label="boleto recebido"> Boleto Recebido</li>
    					<li><input class="por_situacao" name="por_situacao[]" value="agendado" type="checkbox" aria-label="agendado"> Agendado</li>
    					<li><input class="por_situacao" name="por_situacao[]" value="pago" type="checkbox" aria-label="pago"> Pago</li>
    					<li><input class="por_situacao" name="por_situacao[]" value="em cartorio" type="checkbox" aria-label="em cartorio"> Em cartório</li>
    					<li><input class="por_situacao" name="por_situacao[]" value="ajuizado" type="checkbox" aria-label="ajuizado"> Ajuizado</li>

				 	</ul>
				</div>
				</div>

				<div class="col-md-3">
				<div class="dropdown">
  					<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    				Forma da Pagamento
   					 <span class="caret"></span>
				  	</button>
  					<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
  						<li><input id="por_fp_all" name="por_fp_all" type="checkbox" aria-label="por_fp_all" onclick="marcador_fp();"> TODAS</li>

  						<li><h3><input class="por_fp" id="por_fp_boletos" name="por_fp_boletos" value="todos_boletos" type="checkbox" aria-label="todos_boletos" onclick="marcador_fp_boletos();" >Boletos</h3></li>

						<li><input class="por_fp por_fp_boletos" name="por_form_pag[]" value="boleto_std_130025250" type="checkbox" aria-label="boleto_std_130025250">CC: STD 13002525-0</li>
    					<li><input class="por_fp por_fp_boletos" name="por_form_pag[]" value="boleto_std_130025164" type="checkbox" aria-label="boleto_std_130025164">CC: STD 13002516-4</li>
    					<li><input class="por_fp por_fp_boletos" name="por_form_pag[]" value="boleto_std_130028301" type="checkbox" aria-label="boleto_std_130028301">CC: STD 13002830-1</li>
    					<li><input class="por_fp por_fp_boletos" name="por_form_pag[]" value="boleto_bb_sapatino" type="checkbox" aria-label="boleto_bb_sapatino">CC: BB SAPATINO</li>
    					<li><input class="por_fp por_fp_boletos" name="por_form_pag[]" value="boleto_bb_lugbr" type="checkbox" aria-label="boleto_bb_lugbr">CC: BB LuGBR</li>
    					<li><input class="por_fp por_fp_boletos" name="por_form_pag[]" value="boleto_outros" type="checkbox" aria-label="boleto_outros">OUTROS</li>


  						<li><h3><input class="por_fp" id="por_fp_especie" name="por_fp_especie" value="todas_especie" type="checkbox" aria-label="todas_especie" onclick="marcador_fp_especie();" >Espécie (todas)</h3></li>

						<li><input class="por_fp por_fp_especie" name="por_form_pag[]" value="especie_cheque_std" type="checkbox" aria-label="especie_cheque_std">Cheque  STD</li>
    					<li><input class="por_fp por_fp_especie" name="por_form_pag[]" value="especie_cheque_bb" type="checkbox" aria-label="especie_cheque_bb">Cheque  BB</li>
    					<li><input class="por_fp por_fp_especie" name="por_form_pag[]" value="especie_real" type="checkbox" aria-label="especie_real">REAL (R$)</li>
    					<li><input class="por_fp por_fp_especie" name="por_form_pag[]" value="especie_dolar" type="checkbox" aria-label="especie_dolar">Dolar (U$)</li>
    					<li><input class="por_fp por_fp_especie" name="por_form_pag[]" value="especie_outros" type="checkbox" aria-label="especie_outros">Outro (*$)</li>


    					<li><h3><input class="por_fp" id="por_fp_ted" name="por_fp_ted" value="todas_ted" type="checkbox" aria-label="todas_ted" onclick="marcador_fp_ted();" >TED</h3></li>

						<li><input class="por_fp por_fp_ted" name="por_form_pag[]" value="ted_std_130025250" type="checkbox" aria-label="ted_std_130025250">TED: STD 13002525-0</li>
    					<li><input class="por_fp por_fp_ted" name="por_form_pag[]" value="ted_std_130025164" type="checkbox" aria-label="ted_std_130025164">TED: STD 13002516-4</li>
    					<li><input class="por_fp por_fp_ted" name="por_form_pag[]" value="ted_std_130028301" type="checkbox" aria-label="ted_std_130028301">TED: STD 13002830-1</li>
    					<li><input class="por_fp por_fp_ted" name="por_form_pag[]" value="ted_bb_sapatino" type="checkbox" aria-label="ted_bb_sapatino">TED: BB SAPATINO</li>
    					<li><input class="por_fp por_fp_ted" name="por_form_pag[]" value="ted_bb_lugbr" type="checkbox" aria-label="ted_bb_lugbr">TED: BB LuGBR</li>
    					<li><input class="por_fp por_fp_ted" name="por_form_pag[]" value="ted_outros" type="checkbox" aria-label="ted_outros">TED - OUTROS</li>


    					<li><h3><input class="por_fp" id="por_fp_doc" name="por_fp_doc" value="todas_doc" type="checkbox" aria-label="todas_doc" onclick="marcador_fp_doc();" >DOC</h3></li>

						<li><input class="por_fp por_fp_doc" name="por_form_pag[]" value="doc_std_130025250" type="checkbox" aria-label="doc_std_130025250">DOC: STD 13002525-0</li>
    					<li><input class="por_fp por_fp_doc" name="por_form_pag[]" value="doc_std_130025164" type="checkbox" aria-label="doc_std_130025164">DOC: STD 13002516-4</li>
    					<li><input class="por_fp por_fp_doc" name="por_form_pag[]" value="doc_std_130028301" type="checkbox" aria-label="doc_std_130028301">DOC: STD 13002830-1</li>
    					<li><input class="por_fp por_fp_doc" name="por_form_pag[]" value="doc_bb_sapatino" type="checkbox" aria-label="doc_bb_sapatino">DOC: BB SAPATINO</li>
    					<li><input class="por_fp por_fp_doc" name="por_form_pag[]" value="doc_bb_lugbr" type="checkbox" aria-label="doc_bb_lugbr">DOC: BB LuGBR</li>
    					<li><input class="por_fp por_fp_doc" name="por_form_pag[]" value="doc_outros" type="checkbox" aria-label="doc_outros">DOC - OUTROS</li>


    					<li><h3><input class="por_fp" id="por_fp_transf" name="por_fp_transf" value="todas_transf" type="checkbox" aria-label="todas_transf" onclick="marcador_fp_transf();" >TRANSF</h3></li>

						<li><input class="por_fp por_fp_transf" name="por_form_pag[]" value="transf_std_130025250" type="checkbox" aria-label="transf_std_130025250">TRANSF.: STD 13002525-0</li>
    					<li><input class="por_fp por_fp_transf" name="por_form_pag[]" value="transf_std_130025164" type="checkbox" aria-label="transf_std_130025164">TRANSF.: STD 13002516-4</li>
    					<li><input class="por_fp por_fp_transf" name="por_form_pag[]" value="transf_std_130028301" type="checkbox" aria-label="transf_std_130028301">TRANSF.: STD 13002830-1</li>
    					<li><input class="por_fp por_fp_transf" name="por_form_pag[]" value="transf_bb_sapatino" type="checkbox" aria-label="transf_bb_sapatino">TRANSF.: BB SAPATINO</li>
    					<li><input class="por_fp por_fp_transf" name="por_form_pag[]" value="transf_bb_lugbr" type="checkbox" aria-label="transf_bb_lugbr">TRANSF.: BB LuGBR</li>
    					<li><input class="por_fp por_fp_transf" name="por_form_pag[]" value="transf_outros" type="checkbox" aria-label="transf_outros">TRANSF. - OUTROS</li>


    					<li><h3><input class="por_fp" id="por_fp_deposito" name="por_fp_deposito" value="todos_deposito" type="checkbox" aria-label="todos_deposito" onclick="marcador_fp_deposito();" >Depósito</h3></li>

						<li><input class="por_fp por_fp_deposito" name="por_form_pag[]" value="deposito_boca_caixa" type="checkbox" aria-label="deposito_boca_caixa">Boca de caixa</li>
    					<li><input class="por_fp por_fp_deposito" name="por_form_pag[]" value="deposito_caixa_eletronico" type="checkbox" aria-label="deposito_caixa_eletronico">Caixa eletrônico</li>


						<li><h3><input class="por_fp" id="por_fp_cart_credito" name="por_fp_cart_credito" value="todos_cart_credito" type="checkbox" aria-label="todos_cart_credito" onclick="marcador_fp_cart_credito();" >Cartões de Crédito</h3></li>

						<li><input class="por_fp por_fp_cart_credito" name="por_form_pag[]" value="ccredito_std_corp_130025164" type="checkbox" aria-label="ccredito_std_corp_130025164">Visa STD Business (***3048)</li>
    					<li><input class="por_fp por_fp_cart_credito" name="por_form_pag[]" value="ccredito_pag_seguro_lag" type="checkbox" aria-label="ccredito_pag_seguro_lag">Master PagSeguro (***6205)</li>
    					<li><input class="por_fp por_fp_cart_credito" name="por_form_pag[]" value="ccredito_bb_sptno_corp" type="checkbox" aria-label="ccredito_bb_sptno_corp">Visa BB corporativo Sapatino</li>
    					<li><input class="por_fp por_fp_cart_credito" name="por_form_pag[]" value="ccredito_bb_lugbr_corp" type="checkbox" aria-label="ccredito_bb_lugbr_corp">Visa BB corporativo LuGBr</li>
    					<li><input class="por_fp por_fp_cart_credito" name="por_form_pag[]" value="ccredito_outros" type="checkbox" aria-label="ccredito_outros">Outros</li>


						<li><h3><input class="por_fp" id="por_fp_cart_debito" name="por_fp_cart_debito" value="todos_cart_debito" type="checkbox" aria-label="todos_cart_debito" onclick="marcador_fp_cart_debito();" >Cartões de Débito</h3></li>

						<li><input class="por_fp por_fp_cart_debito" name="por_form_pag[]" value="cdebito_mast_std_130025250" type="checkbox" aria-label="cdebito_mast_std_130025250">Master STD ***2259</li>
    					<li><input class="por_fp por_fp_cart_debito" name="por_form_pag[]" value="cdebito_mast_std_130025164" type="checkbox" aria-label="cdebito_mast_std_130025164">Master STD ***7266</li>
    					<li><input class="por_fp por_fp_cart_debito" name="por_form_pag[]" value="cdebito_mast_std_130028301" type="checkbox" aria-label="cdebito_mast_std_130028301">Master STD ***0497o</li>
    					<li><input class="por_fp por_fp_cart_debito" name="por_form_pag[]" value="cdebito_outros" type="checkbox" aria-label="cdebito_outros">Outros</li>


						<li><h3><input class="por_fp" id="por_fp_outros" name="por_fp_outros" value="todos_outros" type="checkbox" aria-label="todos_outros" onclick="marcador_fp_outros();" >OUTROS</h3></li>

						<li><input class="por_fp por_fp_outros" name="por_form_pag[]" value="outros_vt" type="checkbox" aria-label="outros_vt">Vale Transporte</li>
    					<li><input class="por_fp por_fp_outros" name="por_form_pag[]" value="outros_va" type="checkbox" aria-label="outros_va">Vale Alimentação</li>
    					<li><input class="por_fp por_fp_outros" name="por_form_pag[]" value="outros_outros" type="checkbox" aria-label="outros_outros">Outros</li>
				 	</ul>
				</div>
				</div>
				</P>
				<p align="center"><input type="submit" value="Buscar com detalhes"/> </p>
				</div>
			</div>

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
  				<td><b>Forma Pagto</b></td>
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