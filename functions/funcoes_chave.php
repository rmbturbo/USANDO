<?php
function calcula_dv($chave43) {
	$multiplicadores = array(2,3,4,5,6,7,8,9);
	$i = 42;
	$soma_ponderada = 0;
	while ($i >= 0) {
		for ($m=0; $m<count($multiplicadores) && $i>=0; $m++) {

			$soma_ponderada+= $chave43[$i] * $multiplicadores[$m];
			$i--;
		}
	}
	$resto = $soma_ponderada % 11;
	if ($resto == '0' || $resto == '1') {
		return 0;
	} else {
		return (11 - $resto);
	}
}

//$nfe = "3511030212322300017155001000115328186185490";
//$nfe.=calcula_dv($nfe);

//echo $nfe;

// essa função divide a chave em campos que a compoem e retorna o resultado em um array
function Monta_array_chave($chave){
	$UF = substr($chave,0,2 ); //0
	$Ano = substr($chave,2,2 ); //1
	$Mes = substr($chave,4,2); //2
	$CNPJ = substr($chave,6,14 ); //3
	$Modelo_NF = substr($chave,20,2 ); //4
	$Serie_NF = substr($chave,22,3); //5
	$Num_NF = substr($chave,25,10 ); //6
	$Forma_emissao = substr($chave,34,1 ); //7
	$Codigo_NF = substr($chave,35,8 ); //8
	$DV = substr($chave,43,1 ); //9

	$array_chave = array($UF,$Ano,$Mes,$CNPJ,$Modelo_NF,$Serie_NF,$Num_NF,$Forma_emissao,$Codigo_NF,$DV);
	return $array_chave;
	//acima montamos um array sem nomear indices, abaixo na parte inativa, montamos um array com indices nomeados.
/**	$array_chave = array(
	"UF_emissor"=>$UF,
	"Ano"=>$Ano,
	"Mes"=>$Mes,
	"CNPJ_emitente"=>$CNPJ,
	"Modelo_NF"=>$Modelo_NF,
	"Serie_NF"=>$Serie_NF,
	"Num_NF"=>$Num_NF,
	"Forma_emissao"=>$Forma_emissao,
	"Codigo"=>$Codigo_NF,
	"Digito_Verificador"=>$DV);
	return $array_chave;
  */
}

function codifica_UF($UF){
	if ($UF == 11) {
		$UFs = 'RO';
		return $UFs;
	} elseif ($UF == 12) {
		$UFs = 'AC';
		return $UFs;
	}elseif ($UF == 13) {
		$UFs = 'AM';
		return $UFs;
	}elseif ($UF == 14) {
		$UFs = 'RR';
		return $UFs;
	}elseif ($UF == 15) {
		$UFs = 'PA';
		return $UFs;
	}elseif ($UF == 16) {
		$UFs = 'AP';
		return $UFs;
	}elseif ($UF == 17) {
		$UFs = 'TO';
		return $UFs;
	}elseif ($UF == 21) {
		$UFs = 'MA';
		return $UFs;
	}elseif ($UF == 22) {
		$UFs = 'PI';
		return $UFs;
	}elseif ($UF == 23) {
		$UFs = 'CE';
		return $UFs;
	}elseif ($UF == 24) {
		$UFs = 'RN';
		return $UFs;
	}elseif ($UF == 25) {
		$UFs = 'PB';
		return $UFs;
	}elseif ($UF == 26) {
		$UFs = 'PE';
		return $UFs;
	}elseif ($UF == 27) {
		$UFs = 'AL';
		return $UFs;
	}elseif ($UF == 28) {
		$UFs = 'SE';
		return $UFs;
	}elseif ($UF == 29) {
		$UFs = 'BA';
		return $UFs;
	}elseif ($UF == 31) {
		$UFs = 'MG';
		return $UFs;
	}elseif ($UF == 32) {
		$UFs = 'ES';
		return $UFs;
	}elseif ($UF == 33) {
		$UFs = 'RJ';
		return $UFs;
	}elseif ($UF == 35) {
		$UFs = 'SP';
		return $UFs;
	}elseif ($UF == 41) {
		$UFs = 'PR';
		return $UFs;
	}elseif ($UF == 42) {
		$UFs = 'SC';
		return $UFs;
	}elseif ($UF == 43) {
		$UFs = 'RS';
		return $UFs;
	}elseif ($UF == 50) {
		$UFs = 'MS';
		return $UFs;
	}elseif ($UF == 51) {
		$UFs = 'MG';
		return $UFs;
	}elseif ($UF == 52) {
		$UFs = 'GO';
		return $UFs;
	}elseif ($UF == 53) {
		$UFs = 'DF';
		return $UFs;
	}else{
		$UFs = 'XX';
		return $UFs;
	}

}


?>