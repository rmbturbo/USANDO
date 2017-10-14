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

	$("#telefone").mask("(99) 9999-9999");     // Máscara para TELEFONE

	$("#cep").mask("99999-999");    // Máscara para CEP

	$(".datas").mask("99/99/99");    // Máscara para DATA

	$("#cnpj").mask("99.999.999/9999-99");    // Máscara para CNPJ

	$('#rg').mask('99.999.999-9');    // Máscara para RG

	$('#agencia').mask('9999-9');    // Máscara para AGÊNCIA BANCÁRIA

	$('#conta').mask('99.999-9');    // Máscara para CONTA BANCÁRIA

	$(".money").maskMoney({symbol:'R$ ', showSymbol:true, thousands:'.', decimal:',', symbolStay: true});

	$(".nfe").mask('**** **** **** **** **** **** **** **** **** **** ****');




});

	</script>