<?php
$venc = '2016-09-01';
$situ = 'pendente';

function definecor($situ,$venc){
	$hoje = date('Y-m-d');
	if ($venc < $hoje && $situ != 'pago') {
		$cor = 'style="background-color: #FF9797';
	}else{
		$cor =  'style="background-color: #81FE91';
	}
	echo $cor;
	echo '<br>';
	echo $venc;
	echo '<br>';
	echo $hoje;
}


?>
 <script src='http://code.jquery.com/jquery-2.1.3.min.js'></script>
 <script type="text/javascript">
function troca_valor_pgo (id_dup,selecao){
	var cp_valor = '#valor_'+id_dup;
	var valor = $(cp_valor).val();
	var cp_valor_pgo = '#valor_pgo_'+id_dup;
	if (selecao == 'pago'){
		$(cp_valor_pgo).val(valor);
	}

}

function troca_valor_pgo2 (id_dup,selecao){
	var cp_valor = '#valor_'+id_dup;
	var valor = $(cp_valor).val();
	var cp_valor_pgo = '#valor_pgo_'+id_dup;
	$(cp_valor_pgo).val(valor);
}

 </script>
 <table>
 <tr>

 <td data-nome="13"><input name="id_dup" id="id_dup" type="text" value="lskdfçskdj"/></td>
 <td>
 <input type="text" name="meuinput_13" id="meuimput_13" onclick="var nome = $(this).parent().parent().find('td').data('nome');
alert(nome);"  />
 </td>
 <td><input type="text" name="val_pgo_13" id="val_pgo_13"/></td>
 </tr>
  <tr>

 <td data-nome="14"><input name="id_dupli" id="id_dupli" type="text" value="lskd"/></td>
 <td><input type="text" name="valor_14" id="valor_14" value="500"/></td>
 <td><input type="text" name="valor_pgo_14" id="valor_pgo_14" value="4455"/></td>

 <td>
 <select onchange="var nome = $(this).parent().parent().find('td').data('nome'); troca_valor_pgo(nome,this.value);">
 	<option value="pendente" selected>Pendente</option>
 	<option value="pago">Pago</option>
 	<option value="boleto">boleto</option>
 </select>

 </td>
 </tr>
 </table>
