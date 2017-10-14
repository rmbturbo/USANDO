<?php

function geraTimestamp($data) {
	$partes = explode('-', $data);
	return mktime(0, 0, 0, $partes[1], $partes[2], $partes[0]);//se trocar o formato da data tem que troca aqui o a ordem do array partes

}

function converte_periodo_em_dias($inicio,$fim){
	// Usa a função criada e pega o timestamp das duas datas:
	$time_inicial = geraTimestamp($inicio);
	$time_final = geraTimestamp($fim);
	// Calcula a diferença de segundos entre as duas datas:
	$diferenca = $time_final - $time_inicial; // 19522800 segundos
	// Calcula a diferença de dias
	$dias = (int)floor( $diferenca / (60 * 60 * 24)); // 225 dias
	return $dias;
}

function calcula_qtd_ciclos($qtd_dias,$periodicidade){
	switch ($periodicidade) {
		case "mensal":
			$qtd_ciclos = $qtd_dias / 30;
			$qtd_ciclos = $qtd_ciclos + 1;
			return $qtd_ciclos;
			break;
		case "anual":
			$qtd_ciclos = $qtd_dias / 365;
			$qtd_ciclos = $qtd_ciclos + 1;
			return $qtd_ciclos;
			break;
		case "semanal":
			$qtd_ciclos = $qtd_dias / 7;
			$qtd_ciclos = $qtd_ciclos + 1;
			return $qtd_ciclos;
			break;
		case "quinzenal":
			$qtd_ciclos = $qtd_dias / 15;
			$qtd_ciclos = $qtd_ciclos + 1;
			return $qtd_ciclos;
			break;
		case "bimestral":
			$qtd_ciclos = $qtd_dias / 60;
			$qtd_ciclos = $qtd_ciclos + 1;
			return $qtd_ciclos;
			break;
		case "trimestral":
			$qtd_ciclos = $qtd_dias / 90;
			$qtd_ciclos = $qtd_ciclos + 1;
			return $qtd_ciclos;
			break;
		case "semestral":
			$qtd_ciclos = $qtd_dias / 180;
			$qtd_ciclos = $qtd_ciclos + 1;
			return $qtd_ciclos;
			break;
		case "bianual":
			$qtd_ciclos = $qtd_dias / 730;
			$qtd_ciclos = $qtd_ciclos + 1;
			return $qtd_ciclos;
			break;
		default:
			$qtd_ciclos = $qtd_dias / $periodicidade;
			$qtd_ciclos = $qtd_ciclos + 1;
			return $qtd_ciclos;
			break;
	} // switch
}

function e_bissexto($ano){
	if (($ano%4)==0) {
		return true;
	} else {
		return false;
	}
}

function cria_vencimentos_periodicos($inicio,$fim,$periodicidade){

	switch ($periodicidade) {
		case "mensal":
			$dias_intervalo = converte_periodo_em_dias($inicio,$fim);
			$num_ciclos = calcula_qtd_ciclos($dias_intervalo,$periodicidade);
			$vencimentos['0'] = $inicio;
			if($inicio != null){
				$inicio = explode( "-",$inicio);
				$dia = $inicio[2];
				$mes = $inicio[1];
				$ano = $inicio[0];
			}
			for($x = 1; $x < $num_ciclos; $x++){
				$mes++;
				if ($mes > 12) {
					$mes = 1;
					$ano++;
					$vencimentos[$x] = $ano."-".$mes."-".$dia; //$dia."/".$mes."/".$ano;
				} elseif ($mes == 2 && $dia > 28){
					if (e_bissexto($ano) ==true) {
						$dia_fev = 29;
					} else{
						$dia_fev = 28;
					}
					$vencimentos[$x] =  $ano."-".$mes."-".$dia_fev;
				} elseif (($mes == 4 || $mes == 6 || $mes == 9 || $mes == 11) && $dia > 30){
					$dia_mes30 = 30;
					$vencimentos[$x] =  $ano."-".$mes."-".$dia_mes30;
				} else{
					$vencimentos[$x] =  $ano."-".$mes."-".$dia;
				}

			}
			return $vencimentos;
			break;
		case "anual":
			$dias_intervalo = converte_periodo_em_dias($inicio,$fim);
			$num_ciclos = calcula_qtd_ciclos($dias_intervalo,$periodicidade);
			$vencimentos['0'] = $inicio;
			if($inicio != null){
				$inicio = explode( "-",$inicio);
				$dia = $inicio[2];
				$mes = $inicio[1];
				$ano = $inicio[0];
			}
			for($x = 1; $x < $num_ciclos; $x++){
				$ano++;
				if ($mes==2 && $dia==29) {
					if (e_bissexto($ano)==true) {
						$dia_bis = 29;
					} else{
						$dia_bis = 28;
					}
					$vencimentos[$x] =  $ano."-".$mes."-".$dia_bis;
				}else{
					$vencimentos[$x] =  $ano."-".$mes."-".$dia;
				}

			}
			return $vencimentos;
			break;
		case "bianual":
			$dias_intervalo = converte_periodo_em_dias($inicio,$fim);
			$num_ciclos = calcula_qtd_ciclos($dias_intervalo,$periodicidade);
			$vencimentos['0'] = $inicio;
			if($inicio != null){
				$inicio = explode( "-",$inicio);
				$dia = $inicio[2];
				$mes = $inicio[1];
				$ano = $inicio[0];
			}
			for($x = 1; $x < $num_ciclos; $x++){
				$ano++;
				$ano++;
				if ($mes==2 && $dia==29) {
					if (e_bissexto($ano)==true) {
						$dia_bis = 29;
					} else{
						$dia_bis = 28;
					}
					$vencimentos[$x] =  $ano."-".$mes."-".$dia_bis;
				}else{
					$vencimentos[$x] =  $ano."-".$mes."-".$dia;
				}

			}
			return $vencimentos;
			break;
		case "semanal":
			$dias_intervalo = converte_periodo_em_dias($inicio,$fim);
			$num_ciclos = calcula_qtd_ciclos($dias_intervalo,$periodicidade);
			$vencimentos['0'] = $inicio;
			$vencimento_x = $inicio;
			for ($x=1;$x<$num_ciclos;$x++){
				$vencimento_x = date('Y-m-d', strtotime("+7 days",strtotime($vencimento_x)));
				$vencimentos[$x] = $vencimento_x;
			}
			return $vencimentos;
			break;
		case "quinzenal":
			$dias_intervalo = converte_periodo_em_dias($inicio,$fim);
			$num_ciclos = calcula_qtd_ciclos($dias_intervalo,$periodicidade);
			$vencimentos['0'] = $inicio;
			$vencimento_x = $inicio;
			for ($x=1;$x<$num_ciclos;$x++){
				$vencimento_x = date('Y-m-d', strtotime("+15 days",strtotime($vencimento_x)));
				$vencimentos[$x] = $vencimento_x;
			}
			return $vencimentos;
			break;
		case "bimestral":
			$dias_intervalo = converte_periodo_em_dias($inicio,$fim);
			$num_ciclos = calcula_qtd_ciclos($dias_intervalo,$periodicidade);
			$vencimentos['0'] = $inicio;
			$vencimento_x = $inicio;
			for ($x=1;$x<$num_ciclos;$x++){
				$vencimento_x = date('Y-m-d', strtotime("+60 days",strtotime($vencimento_x)));
				$vencimentos[$x] = $vencimento_x;
			}
			return $vencimentos;
			break;
		case "trimestral":
			$dias_intervalo = converte_periodo_em_dias($inicio,$fim);
			$num_ciclos = calcula_qtd_ciclos($dias_intervalo,$periodicidade);
			$vencimentos['0'] = $inicio;
			$vencimento_x = $inicio;
			for ($x=1;$x<$num_ciclos;$x++){
				$vencimento_x = date('Y-m-d', strtotime("+90 days",strtotime($vencimento_x)));
				$vencimentos[$x] = $vencimento_x;
			}
			return $vencimentos;
			break;
		case "semestral":
			$dias_intervalo = converte_periodo_em_dias($inicio,$fim);
			$num_ciclos = calcula_qtd_ciclos($dias_intervalo,$periodicidade);
			$vencimentos['0'] = $inicio;
			$vencimento_x = $inicio;
			for ($x=1;$x<$num_ciclos;$x++){
				$vencimento_x = date('Y-m-d', strtotime("+180 days",strtotime($vencimento_x)));
				$vencimentos[$x] = $vencimento_x;
			}
			return $vencimentos;
			break;
		default:
			$dias_intervalo = converte_periodo_em_dias($inicio,$fim);
			$num_ciclos = calcula_qtd_ciclos($dias_intervalo,$periodicidade);
			$vencimentos['0'] = $inicio;
			$vencimento_x = $inicio;
			$inicio = explode( "-",$inicio);
			$dia = $inicio[2];
			$mes = $inicio[1];
			$ano = $inicio[0];
			for ($x=1;$x<$num_ciclos;$x++){
				//	$vencimento_x = mktime(0,0,0,$mes+$periodicidade,$dia,$ano);
				$vencimento_x = date('Y-m-d', strtotime("+".$periodicidade."days",strtotime($vencimento_x)));
				$vencimentos[$x] = $vencimento_x;
			}
			return $vencimentos;
			break;
	}
}

?>