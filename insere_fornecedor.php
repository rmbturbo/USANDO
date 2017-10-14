<?php


if (!isset($_SESSION)) session_start();

if (!isset($_SESSION['usuarioID'])) {
	// Destrói a sessão por segurança
	session_destroy();
	// Redireciona o visitante de volta pro login
	header("Location: index.php"); exit;
}

$acesso = $_SESSION['usuarioAcesso'];
$usuario = $_SESSION['usuarioERP'];

include('includes/header.php');
include('logoff.php');

if(isset($_GET['cnpj'])) $cnpj=$_GET['cnpj'];
//$cnpj = '79523098000111';


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

<!-- Segue script que chama o ajax, enviando o id relacionado ao nome fantasia do fornecedor -->
<script type="text/javascript">
$(document).ready(function(){
	$('#fornecedor').change(function(){
		$('#unidade_fornecedor').load('ajax/ajax_busca_unidade_forn.php?fornecedor='+$('#fornecedor').val());
	});
});
</script>

 <script src='http://code.jquery.com/jquery-1.7.2.min.js'></script>


 <script type="text/javascript" src="js/validadores.js"></script>
	</head>
<!-- Link e preparação das mascaras-->
 <script type="text/javascript" src="js/jquery.maskedinput.min.js"></script>
<script type="text/javascript" src="js/jquery.maskMoney.min.js"></script>
<script type="text/javascript">
$(function(){

	$(".datas:last").live('click', function(){
		$(this).mask("99/99/99");
	})});

$(function(){

	$(".money:last").live('click', function(){
		$(this).maskMoney({symbol:'R$ ', showSymbol:true, thousands:'.', decimal:',', symbolStay: true});
	})});

jQuery(document).ready(function($) {

	$(".telefone").mask("(99) 9999-9999");     // Máscara para TELEFONE

	$(".cep").mask("99999-999");    // Máscara para CEP

	$(".datas").mask("99/99/99");    // Máscara para DATA

	$("#cnpj").mask("99.999.999/9999-99");    // Máscara para CNPJ

	$('#rg').mask('99.999.999-9');    // Máscara para RG

	$('#agencia').mask('9999-9');    // Máscara para AGÊNCIA BANCÁRIA

	$('#conta').mask('99.999-9');    // Máscara para CONTA BANCÁRIA

	$(".money").maskMoney({symbol:'R$ ', showSymbol:true, thousands:'.', decimal:',', symbolStay: true});

	$(".nfe").mask('**** **** **** **** **** **** **** **** **** **** ****');




});

</script>

<!-- Entrada do Topo da pagina -->
<?php
//echo '<div class="alert alert-success" role="alert">Bem vindo ao ERP Sapatino '.$usuario. '</div>';
//INCLUI A TOPO.PHP QUE CAPTARA A VARIAL SESSION QUE DIRA QUAL TOPO SERA ENVIADO



if (isset($_GET['retorno']) && isset($_GET['forn'])) {
	$retorno = $_GET['retorno'];
	$fornecedor = $_GET['forn'];
	$nomef = $_GET['nome'];
	if($retorno == 	'sucesso'){
		echo '<div class="alert alert-success" role="alert">Unidade de CNPJ '.substr($fornecedor,0,2).'.'.substr($fornecedor,2,3).'.'.substr($fornecedor,5,3).'/'.substr($fornecedor,8,4).'-'.substr($fornecedor,12,2).' do fornecedor '.$nomef.' foi cadastrado com sucesso </div>';
	} elseif($retorno =='excesso'){
		echo '<div class="alert alert-warning" role="alert"> A unidade '.substr($fornecedor,0,2).'.'.substr($fornecedor,2,3).'.'.substr($fornecedor,5,3).'/'.substr($fornecedor,8,4).'-'.substr($fornecedor,12,2).' do fornecedor '.$nomef.' já está cadastrada, para altera-lá vá no menu Fornecedor -> Alterar cadastro </div>';
	} elseif($retorno == 'serverER'){
		echo '<div class="alert alert-danger" role="alert"> Erro no servidor ao cadastrar a unidade '.substr($fornecedor,0,2).'.'.substr($fornecedor,2,3).'.'.substr($fornecedor,5,3).'/'.substr($fornecedor,8,4).'-'.substr($fornecedor,12,2).' do fornecedor '.$nomef.', contacte o administrador do sistema. </div>';
		//	echo 'erro';
	}
}

include('includes/topo.php');
include('functions/functions.php');
?>


<div class="container span7 text-center col-md-5 col-md-offset-3" style="margin: 0 auto;float: none;">

	<form name="new_unidade_fornecedor" method="post" action="modulos/fornecedor/insere_DB_fornecedor.php?or=1">

	<div class="panel panel-default">
  		<div class="panel-heading">
   		 <h3 class="panel-title">Dados básicos</h3>
 		 </div>
  		<div class="panel-body" align="left">
  		<label for="fornecedor">Forcenecedor: </label>
   			<select id="fornecedor" name="fornecedor" onfocus="ajax_plus()" >
    	    	<option value="">Selecione...</option>
       			 <?php lista_forn(); ?>
			</select>
			<button type="button" class="btn btn-default" aria-label="Left Align" onclick="window.open('Popup_insere_nome_fornecedor.php',200,100)">
  				<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
			</button>
		<p>
		<label for="razao">Razão: </label>
			<input type="text" size="40" name="razao" id="razao"/>
		</p>
		<p>
		<label for="cnpj">CNPJ: </label>
			<input type="text" size="40" maxlength="18" name="cnpj" id="cnpj" value="<?php if (isset($cnpj)) {echo $cnpj;}?>"/>
		</p>
		<p>
		<label for="insc_est">Inscrição estadual: </label>
			<input type="text" size="27" name="insc_est" id="insc_est"/>
		</p>

 	 </div>
</div>

<div class="panel panel-default">
  		<div class="panel-heading">
   		 <h3 class="panel-title">Dados básicos</h3>
 		 </div>
 	 <div class="panel-body" align="left">
		<p>
		<label for="logradouro">Logradouro: </label>
			<input type="text" size="40" name="logradouro" id="logradouro"/>
		</p>
		<p>
		<label for="numero">N°: </label>
			<input type="text" size="5" name="numero" id="numero"/>
		<label for="complemento"> Complemento: </label>
			<input type="text" size="20" name="complemento" id="complemento"/>
		</p>
		<p>
		<label for="bairro">Bairro:</label>
			<input type="text" size="20" name="bairro" id="bairro"/>
		<label for="cidade">Cidade:</label>
			<input type="text" size="20" name="cidade" id="cidade"/>
		</p>
		<p>
		<label for="UF">UF:</label>
			<input type="text" maxlength="2" name="UF" id="UF"/>

		<label for="CEP">CEP:</label>
			<input type="text" maxlength="9" name="CEP" id="CEP"  class="cep"/>
		</p>

 	 </div>
</div>


<div class="panel panel-default">
  		<div class="panel-heading">
   		 <h3 class="panel-title">Contatos</h3>
 		 </div>
 	 <div class="panel-body" align="left">
		<p>
		<label for="email">Email: </label>
			<input type="text" size="40" name="email" id="email"/>
		</p>
		<p>
		<label for="tel1">Tel. 01: </label>
			<input type="text" name="tel1" id="tel1" class="telefone" size="13"/>
		<label for="tel2"> Tel. 02: </label>
			<input type="text" name="tel2" id="tel2" class="telefone" size="13"/><br/>
		<label for="fax"> Fax: </label>
			<input type="text" name="fax" id="fax" class="telefone" size="13"/>
		</p>

 	 </div>
</div>

<div class="panel panel-default">
  		<div class="panel-heading">
   		 <h3 class="panel-title">Observações</h3>
 		 </div>
 	 <div class="panel-body" align="left">
		<p>
			<textarea name="obs" id="obs" spellcheck="true" rows="5" cols="60"></textarea></textarea>
		</p>

 	 </div>
</div>


<div class="panel panel-default">
  <div class="panel-body">
    <input type="submit" value="Enviar" />
  </div>
</div>

	</form>
</div>
	</body>
</html>