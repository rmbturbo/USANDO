
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

<!-- Segue script que chama o ajax, enviando o id relacionado ao nome fantasia do fornecedor -->
<script type="text/javascript">
$(document).ready(function(){
	$('#fornecedor').change(function(){
		$('#unidade_fornecedor').load('ajax/ajax_busca_unidade_forn.php?fornecedor='+$('#fornecedor').val());
	});
});
</script>

<!-- Segue script que trata da criação dinamica dos campos do faturamento -->
<script type="text/javascript">
$(document).ready(function() {
	var campos_max          = 30;   //max de 30 campos
	var x = 1; // campos iniciais
	$('#add_field').click (function(e) {
		e.preventDefault();     //prevenir novos clicks
		if (x < campos_max) {
			$('#parcelas').append('<div>\
			Vencimento '+(x+1)+': <input type="DATE" name="vencimento[]" class="datas" size="8" onblur="if ( valida_data(this,this.value) != true) {this.focus()}" >\
			 <input type="text" name="valor[]" class="dinheiro" size="9">\
			<a href="#" class="remover_campo"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></a><br><br>\
			</div>');
			x++;
		}
	});

	// Remover o div anterior
	$('#parcelas').on("click",".remover_campo",function(e) {
		e.preventDefault();
		$(this).parent('div').remove();
		x--;
	});
});
</script>

 <script type="text/javascript" src="js/validadores.js"></script>
 <!-- mascara para a classe dinheiro de http://www.fabiobmed.com.br/criando-mascaras-para-moedas-com-jquery/ -->
  <script src="js/jquery.maskMoney.js"></script>

   <script type="text/javascript">
$(function mascara(){
	$(".dinheiro").maskMoney({thousands:'.', decimal:',', symbolStay: true})
})
</script>








<script type="text/javascript">

/** function calcular(){
	//parseFloat(comVirgula.replace(',','.'))
	var n1 = parseFloat(document.getElementById('Valor_NF').value.replace(',','.'));
	var n2 = parseFloat(document.getElementById('desconto').value.replace(',','.'));
	var soma = parseFloat(eval(n1 - n2));
	var soma = parseFloat(soma.replace('.',','));
	document.getElementById('Total_Nf').value = soma;

}
 descontinuado, trunca com mascaras**/
</script>
	</head>

	<body onload="ajax_plus(); document.getElementById('sucursal').focus();">

<!-- Entrada do Topo da pagina -->
<?php
include('functions/functions.php');
include('functions/funcoes_chave.php');
if (isset($_GET['retorno'])) {
	$retorno = $_GET['retorno'];
	switch ($retorno) {
		case 'sucesso':
			$tipo_doc = $_GET['tp_doc'];
			$num_doc = $_GET['num_doc'];
			$tp_conta = $_GET['tp_conta'];
			echo '<div class="alert alert-success" role="alert"> As duplicatas da/o '.$tipo_doc.' número <b>'.$num_doc.'</b>, foram cadastrado com sucesso como uma nova conta <b>'.$tp_conta.'</b></div>';
			break;
		case 'fracasso':
			$tabela = $_GET['tb'];
			$tp_conta = $_GET['tp_conta'];
			$tipo_doc = $_GET['tp_doc'];
			$num_erro = $_GET['num_erro'];
			$num_erro_db = $_GET['num_errdb'];
			$num_doc = $_GET['num_doc'];
			echo '<div class="alert alert-danger" role="alert">Erro número '.$num_erro.' Ao inserir a/o '.$tipo_doc.' número '.$num_doc.'na tabela '.$tabela.' Erro DB:<b>'.$num_erro_db.'</b>  </div>';
			break;
		default:
			echo '<div class="alert alert-danger" role="alert"><h2>Retorno desconhecido. Contacte o administrador.</h2></div>';
	} // switch
	//$chave = $_GET['chave'];
	//$setor = $_GET['setor'];
//Area dedicada aos avisos de feedback
	//$num_nf = Monta_array_chave($chave)[6];
	//$serie_nf = Monta_array_chave($chave)[5];
}
/**	if($retorno == 	'sucesso'){
		echo '<div class="alert alert-success" role="alert"> As duplicatas da NFe número <b>'.$chave.'</b>, série '.$serie_nf.' foram cadastrado com sucesso </div>';
	} elseif($retorno =='fracasso' && $setor == 'chave'){
		echo '<div class="alert alert-danger" role="alert">A chave '.$chave.' Não é válida</div>';
	} elseif($retorno == 'fracasso' && ($setor == 'nf')){
		include_once('conectadb2.php');
		$erro = 'Erro: '. $conectabase->errno .'-'. $conectabase->error;
		echo '<div class="alert alert-danger" role="alert">'.$erro.' ao cadastrar os pagamentos da Nf número '.$num_nf.' Provavelmente esta NFe já foi cadastrada</div>';
		//	echo 'erro';
	} else{
		include_once('conectadb2.php');
		$erro = 'Erro: '. $conectabase->errno .'-'. $conectabase->error;
		echo '<div class="alert alert-danger" role="alert">'.$erro.' ao cadastrar os pagamentos da conta número '.$num_nf.' </div>';
	}
}
**/



//echo '<div class="alert alert-success" role="alert">Bem vindo ao ERP Sapatino '.$usuario. '</div>';
//INCLUI A TOPO.PHP QUE CAPTARA A VARIAL SESSION QUE DIRA QUAL TOPO SERA ENVIADO
include('includes/topo.php');

 ?>

<!-- Entrada dados da NF -->
<div class="container span7 text-center col-md-5 col-md-offset-3" style="margin: 0 auto;float: none;">


<form name="contas_a_pagar" method="post" action="modulos/financeiro/Insere_DB_fin_cf.php">

<div class="panel panel-default">
  <div class="panel-heading">Modo de despesa</div>
  <div class="panel-body">
  <p>
	<b>Variavel: </b><input type="radio" name="forma_conta" id="forma_conta" value="variavel" checked onclick="$('#faturamento').css('display','block');$('#periodico').css('display','none');"/><b>    fixa: </b><input type="radio" name="forma_conta" id="forma_conta" value="fixa" onclick="$('#faturamento').css('display','none');$('#periodico').css('display','block');"/>
  </p>
    <p>
	<b>NFe: </b><input type="radio" name="tipo_doc" id="tipo_doc" value="nfe" checked onclick="$('#nfe').css('display','block'); $('#nf_manual').css('display','none');  $('#outros_docs').css('display','none');"/>
	<b>    NF Manual: </b><input type="radio" name="tipo_doc" id="tipo_doc" value="nfm" onclick="$('#nfe').css('display','none'); $('#nf_manual').css('display','block');  $('#outros_docs').css('display','none');" />
	<b>    Outro documento: </b><input type="radio" name="tipo_doc" id="tipo_doc" value="doc" onclick="$('#nfe').css('display','none'); $('#nf_manual').css('display','none');  $('#outros_docs').css('display','block');"/>
  </p>
<label for="tipo_conta">Tipo da despesa</label>
<select id="tipo" name="tipo_conta">
		<optgroup label="Vendavel">
		<option value="vendavel_mercadoria">Mercadoria</option>
		<option value="vendavel_royalties">Royalties de mercadoria</option>
		<option value="vendavel_bonus-brinde">Bonus/Brinde</option>
		<option value="vendavel_outros">Outros</option>
		</optgroup>
		<optgroup label="Consumo">
		<option value="consumo_insumos">Insumos</option>
		<option value="consumo_alimentacao">Alimentação</option>
		<option value="consumo_transporte">Transporte</option>
		<option value="consumo_outros">Outros</option>
		</optgroup>
		<optgroup label="Contas">
		<option value="conta_aluguel">Aluguel</option>
		<option value="conta_agua">Agua</option>
		<option value="conta_luz">Luz</option>
		<option value="conta_telefonia-internet">Telefonia/Internet</option>
		<option value="conta_outros">Outros</option>
		</optgroup>
		<optgroup label="Investimentos">
		<option value="investimento_publicidade">Publicidade</option>
		<option value="investimento_infraestrutura">Infraestrutura</option>
		<option value="investimento_imovel">Aquisicao de Imóveis</option>
		<option value="investimento_veiculo">Aquisicao de Veiculos</option>
		<option value="investimento_outros">Outros</option>
		</optgroup>
		<optgroup label="Financeiro">
		<option value="financeiro_encargo">Encargos</option>
		<option value="financeiro_multa">Multas</option>
		<option value="financeiro_juros">Juros</option>
		<option value="financeiro_taxas-admin">Taxas administrativas</option>
		<option value="financeiro_outros">Outros</option>
		</optgroup>
		<optgroup label="Tributos">
		<option value="tributos_simples">Simples</option>
		<option value="tributos_fgts">FGTS</option>
		<option value="tributos_enc-sociais">Outros encargos sociais</option>
		<option value="tributos_estaduais">Estaduais</option>
		<option value="tributos_municipais">Tributos e taxas municipais</option>
		<option value="tributos_outros">Outros</option>
		</optgroup>
		<optgroup label="Administrativo">
		<option value="administrativo_contabil">Contabil</option>
		<option value="administrativo_manutencao">Serviços de manutenção</option>
		<option value="administrativo_equipamentos">Aquisição de equipamentos</option>
		<option value="administrativo_softwares">Softwares e Sistemas</option>
		<option value="administrativo_outros">Outros</option>
		</optgroup>
	</select>
	</div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">Loja de entrada</div>
  <div class="panel-body">
  <!--<input type="text" name="tipo_conta" value="fornecedor" hidden/> -->
   <select name="sucursal" id="sucursal">
<option value="">Selecione uma Sucursal...</option>
<?php lista_sucursal(); ?>
</select><br/><br/>
  </div>
</div>

<div class="panel panel-default" id="nfe">
  <div class="panel-heading">
    <h3 class="panel-title">Dados da NFe</h3>
  </div>
  <div class="panel-body" >
    Chave da NFe:<br/><input type="text" name="Chave_NFe" id="Chave_NFe" size="58" maxlength="54" class="nfe" onfocus="this.selectionStart = 0; this.selectionEnd = 0; " onclick="this.selectionStart = 0; this.selectionEnd = 0; " ondblclick="this.selectionStart = 0; this.selectionEnd = 0; " onblur="preenche_financeiro_by_chave(this.value);"/> <br/><br/>
Número da NFe:  <input type="text" name="Num_NFe" id="Num_NFe" size="8" maxlength="9"/> Série: <input type="text" size="3" maxlength="3" name="Serie_NFe" id="Serie_NFe"/> <br/><br/>
Valor Total bruto: <input type="text" name="Valor_NFe" id="Valor_NFe" class="dinheiro" size="10" maxlength="10"/> <br/><br/>
Total de Desconto: <input type="text" name="desconto_nfe" id="desconto_nfe" class="dinheiro" size="10" maxlength="10" /> <br/><br/>


  </div>
</div>

<div class="panel panel-default" id="nf_manual" style="display:none;">
  <div class="panel-heading">
    <h3 class="panel-title">Dados da NF</h3>
  </div>
  <div class="panel-body" >
Número da NF:  <input type="text" name="Num_NFm" id="Num_NFm" size="8" maxlength="9"/> Série: <input type="text" size="3" maxlength="3" name="Serie_NFm" id="Serie_NFm"/> <br/><br/>
Valor Total bruto: <input type="text" name="Valor_NFm" id="Valor_NFm" class="dinheiro" size="10" maxlength="10"/> <br/><br/>
Total de Desconto: <input type="text" name="desconto_nfm" id="desconto_nfm" class="dinheiro" size="10" maxlength="10" /> <br/><br/>


  </div>
</div>

<div class="panel panel-default" id="outros_docs" style="display:none;">
  <div class="panel-heading">
    <h3 class="panel-title">Dados do Documento</h3>
  </div>
  <div class="panel-body" >
codigo identificador:  <input type="text" name="Num_DOC" id="Num_DOC" size="8" maxlength="9" /> Série (se houver): <input type="text" size="3" maxlength="3" name="Serie_DOC" id="Serie_DOC"/> <br/><br/>
Valor Total bruto: <input type="text" name="Valor_DOC" id="Valor_DOC" class="dinheiro" size="10" maxlength="10" /> <br/><br/>
Total de Desconto: <input type="text" name="desconto_doc" id="desconto_doc" class="dinheiro" size="10" maxlength="10" /> <br/><br/>
OBS: <input type="text" name="Obs_DOC" id="Obs_DOC"/>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Dados do fornecedor</h3>
  </div>
  <div class="panel-body" >
  <label for="fornecedor">Fornecedor: </label>
   	<select id="fornecedor" name="fornecedor">
    	    <option value="" selected>Selecione...</option>
       			 <?php// lista_forn(); ?>
	</select>
<br/>
	<label for="unidade_fornecedor">Unidade: </label>
	<select id="unidade_fornecedor" name="unidade_fornecedor">
		<option value="">Selecione o Fornecedor</option>
	</select>
	<button type="button" class="btn btn-default" aria-label="Left Align" onclick="var cnpjok = Desmembra_chave(Chave_NFe.value)[3];
window.open('insere_fornecedor.php?cnpj='+cnpjok);//assim ao chegar no formulario de insercao do fornecedor, ja tera o cnpj">
  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
</button><br/>
  </div>
</div>

<div class="panel panel-default" id="faturamento">
  <div class="panel-heading">
    <h3 class="panel-title">Faturamento</h3>
  </div>
  <div class="panel-body" ><p>
  <label for="fp_nfe">Forma Pgto.: </label>
			<select name="fp_nfe" id="fp_nfe">

			<optgroup label="Boleto (conta débito)">
				<option value="boleto_std_130025250">CC: STD 13002525-0 </option>
				<option value="boleto_std_130025164">CC: STD 13002516-4 </option>
				<option value="boleto_std_130028301">CC: STD 13002830-1 </option>
				<option value="boleto_bb_sapatino">CC: BB SAPATINO </option>
				<option value="boleto_bb_sapatino">CC: BB LuGBR </option>
				<option value="boleto_outros">OUTROS </option>
			</optgroup>

			<optgroup label="Especie">
				<option value="especie_cheque_std">Cheque  STD</option>
				<option value="especie_cheque_bb">Cheque  BB</option>
				<option value="especie_real">REAL (R$) </option>
				<option value="especie_dolar">Dolar (U$) </option>
				<option value="especie_outros">Outro (*$) </option>
			</optgroup>

			<optgroup label="TED (conta débito)">
				<option value="ted_std_130025250">TED: STD 13002525-0 </option>
				<option value="ted_std_130025164">TED: STD 13002516-4 </option>
				<option value="ted_std_130028301">TED: STD 13002830-1 </option>
				<option value="ted_bb_sapatino">TED: BB SAPATINO </option>
				<option value="ted_bb_sapatino">TED: BB LuGBR </option>
				<option value="ted_outros">OUTROS </option>
			</optgroup>

			<optgroup label="DOC (conta débito)">
				<option value="doc_std_130025250">DOC: STD 13002525-0 </option>
				<option value="doc_std_130025164">DOC: STD 13002516-4 </option>
				<option value="doc_std_130028301">DOC: STD 13002830-1 </option>
				<option value="doc_bb_sapatino">DOC: BB SAPATINO </option>
				<option value="doc_bb_sapatino">DOC: BB LuGBR </option>
				<option value="doc_outros">OUTROS </option>
			</optgroup>

			<optgroup label="TRANSF. (conta débito)">
				<option value="transf_std_130025250">TRANSF.: STD 13002525-0 </option>
				<option value="transf_std_130025164">TRANSF.: STD 13002516-4 </option>
				<option value="transf_std_130028301">TRANSF.: STD 13002830-1 </option>
				<option value="transf_bb_sapatino">TRANSF.: BB SAPATINO </option>
				<option value="transf_bb_sapatino">TRANSF.: BB LuGBR </option>
				<option value="transf_outros">OUTROS</option>
			</optgroup>

			<optgroup label="Depósito">
				<option value="deposito_boca_caixa">Boca de caixa</option>
				<option value="deposito_caixa_eletronico">Caixa eletrônico </option>
			</optgroup>

			<optgroup label="Cartão de crédito">
				<option value="ccredito_std_corp_130025164">Visa STD Business (***3048)</option>
				<option value="ccredito_pag_seguro_lag">Master PagSeguro (***6205)</option>
				<option value="ccredito_bb_sptno_corp">Visa BB corporativo Sapatino</option>
				<option value="ccredito_bb_lugbr_corp">Visa BB corporativo LuGBr</option>
				<option value="ccredito_outros">Outros</option>
			</optgroup>

			<optgroup label="Cartão de débito">

				<option value="cdebito_mast_std_130025250">Master STD ***2259</option>
				<option value="cdebito_mast_std_130025164">Master STD ***7266</option>
				<option value="cdebito_mast_std_130028301">Master STD ***0497</option>
				<option value="cdebito_outros">Outros</option>
			</optgroup>

			<optgroup label="OUTROS">
				<option value="outros_vt">Vale Transporte</option>
				<option value="outros_va">Vale Alimentação </option>
				<option value="outros_outros">Outros </option>
			</optgroup>

			</select></p>
<input type="button" id="add_field" value="adicionar parcela">
<br/>
<br>
<div id="parcelas">

    <div>Vencimento 1: <input type="DATE" name="vencimento[]" class="datas" size="8" onblur="if ( valida_data(this,this.value) != true) {this.focus()}">  <input type="text" name="valor[]" class="dinheiro" size="9" ><br/><br/>
    <!-- Segue Script que trata de mascaras -->

	</div>
</div>

</div>
</div>

<div class="panel panel-default" id="periodico" style="display:none;">
  <div class="panel-heading">
    <h3 class="panel-title">Periodicidade</h3>
  </div>
  <div class="panel-body" >
  <p>
   <label for="fp">Forma Pgto.: </label>
  			<select name="fp" id="fp">

			<optgroup label="Boleto (conta débito)">
				<option value="boleto_std_130025250">CC: STD 13002525-0 </option>
				<option value="boleto_std_130025164">CC: STD 13002516-4 </option>
				<option value="boleto_std_130028301">CC: STD 13002830-1 </option>
				<option value="boleto_bb_sapatino">CC: BB SAPATINO </option>
				<option value="boleto_bb_sapatino">CC: BB LuGBR </option>
				<option value="boleto_outros">OUTROS </option>
			</optgroup>

			<optgroup label="Especie">
				<option value="especie_cheque_std">Cheque  STD</option>
				<option value="especie_cheque_bb">Cheque  BB</option>
				<option value="especie_real">REAL (R$) </option>
				<option value="especie_dolar">Dolar (U$) </option>
				<option value="especie_outros">Outro (*$) </option>
			</optgroup>

			<optgroup label="TED (conta débito)">
				<option value="ted_std_130025250">TED: STD 13002525-0 </option>
				<option value="ted_std_130025164">TED: STD 13002516-4 </option>
				<option value="ted_std_130028301">TED: STD 13002830-1 </option>
				<option value="ted_bb_sapatino">TED: BB SAPATINO </option>
				<option value="ted_bb_sapatino">TED: BB LuGBR </option>
				<option value="ted_outros">OUTROS </option>
			</optgroup>

			<optgroup label="DOC (conta débito)">
				<option value="doc_std_130025250">DOC: STD 13002525-0 </option>
				<option value="doc_std_130025164">DOC: STD 13002516-4 </option>
				<option value="doc_std_130028301">DOC: STD 13002830-1 </option>
				<option value="doc_bb_sapatino">DOC: BB SAPATINO </option>
				<option value="doc_bb_sapatino">DOC: BB LuGBR </option>
				<option value="doc_outros">OUTROS </option>
			</optgroup>

			<optgroup label="TRANSF. (conta débito)">
				<option value="transf_std_130025250">TRANSF.: STD 13002525-0 </option>
				<option value="transf_std_130025164">TRANSF.: STD 13002516-4 </option>
				<option value="transf_std_130028301">TRANSF.: STD 13002830-1 </option>
				<option value="transf_bb_sapatino">TRANSF.: BB SAPATINO </option>
				<option value="transf_bb_sapatino">TRANSF.: BB LuGBR </option>
				<option value="transf_outros">OUTROS</option>
			</optgroup>

			<optgroup label="Depósito">
				<option value="deposito_boca_caixa">Boca de caixa</option>
				<option value="deposito_caixa_eletronico">Caixa eletrônico </option>
			</optgroup>

			<optgroup label="Cartão de crédito">
				<option value="ccredito_std_corp_130025164">Visa STD Business (***3048)</option>
				<option value="ccredito_pag_seguro_lag">Master PagSeguro (***6205)</option>
				<option value="ccredito_bb_sptno_corp">Visa BB corporativo Sapatino</option>
				<option value="ccredito_bb_lugbr_corp">Visa BB corporativo LuGBr</option>
				<option value="ccredito_outros">Outros</option>
			</optgroup>

			<optgroup label="Cartão de débito">

				<option value="cdebito_mast_std_130025250">Master STD ***2259</option>
				<option value="cdebito_mast_std_130025164">Master STD ***7266</option>
				<option value="cdebito_mast_std_130028301">Master STD ***0497</option>
				<option value="cdebito_outros">Outros</option>
			</optgroup>

			<optgroup label="OUTROS">
				<option value="outros_vt">Vale Transporte</option>
				<option value="outros_va">Vale Alimentação </option>
				<option value="outros_outros">Outros </option>
			</optgroup>

			</select></p>
	<label for="inicio">Inicio: </label>
	<input type="date" class="datas" size="8" name="inicio" id="inicio"/>

	<label for="fim">Fim: </label>
	<input type="date" class="datas" size="8" name="fim" id="fim"/>

	<p align="center">
	<label for="periodicidade">Periodicidade: </label>
	<select name="periodicidade" id="periodicidade" onchange="if (this.value == 'outros' ) {$('#periodicidade_outros').css('display','block');}else{$('#periodicidade_outros').css('display','none');};">
		<option value="mensal">Mensal</option>
		<option value="anual">Anual</option>
		<option value="semanal">Semanal</option>
		<option value="quinzenal">Quinzenal</option>
		<option value="bimestral">Bimestral</option>
		<option value="trimestral">Trimestral</option>
		<option value="semestral">Semestral</option>
		<option value="bianual">Bianual</option>
		<option value="outros" >Outros</option>
	</select>
	<input name="periodicidade_outros" id="periodicidade_outros" type="number" size="4" placeholder="em dias" style="display:none;"/>
	</p>
	<p>
	<label for="parcela_estimada">Valor estimado</label>
	<input type="text" name="parcela_estimada" class="dinheiro" size="9"  id="parcela_estimada"/>
	</p>
</div>

</div>

<div class="panel panel-default">
  <div class="panel-body">
    <input type="submit" value="Enviar" />
  </div>
</div>

</div>



<!-- Finalização -->


	</body>
</html>