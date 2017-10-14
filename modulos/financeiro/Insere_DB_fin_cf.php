<?php
require('../../conectadb2.php');
include('../../functions/functions.php');



//tratando o valores monetarios para gravar no banco
function converte_numero($get_valor) {
	$source = array('.', ',');
	$replace = array('', '.');
	$valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
	return $valor; //retorna o valor formatado para gravar no banco
}

/** determia qual o valor será usado como valor total de acordo com o tipo de documento **/
function determina_valor_total($tipo_doc,$valor_NFe,$valor_NFm,$valor_DOC){
	switch($tipo_doc) {
		case "nfe":
			$valor_usado = $valor_NFe;
			break;
		case "nfm":
			$valor_usado = $valor_NFm;
			break;
		case "doc":
			$valor_usado = $valor_DOC;
			break;
	}
	return $valor_usado;
}

/** determia qual a fornte da forma de pagamento será usada de acordo com o tipo de documento **/
function determina_fp($tipo_doc,$forma_pag,$forma_pag_nfe){
	switch($tipo_doc) {
		case "nfe":
			$fp = $forma_pag_nfe;
			break;
		case "nfm":
			$fp = $forma_pag;
			break;
		case "doc":
			$fp = $forma_pag;
			break;
	}
	return $fp;
}

/** determia qual o valor será usado como desconto de acordo com o tipo de documento **/
function determina_desconto($tipo_doc,$desconto_nfe,$desconto_nfm,$desconto_doc){
	switch($tipo_doc) {
		case "nfe":
			$desconto_usado = $desconto_nfe;
			break;
		case "nfm":
			$desconto_usado = $desconto_nfm;
			break;
		case "doc":
			$desconto_usado = $desconto_doc;
			break;
	}
	return $desconto_usado;
}

function determina_documento($tipo_doc,$num_NFe,$num_NFm,$num_DOC){
	switch($tipo_doc) {
		case "nfe":
			$documento_usado = $num_NFe;
			break;
		case "nfm":
			$documento_usado = $num_NFm;
			break;
		case "doc":
			$documento_usado = $num_DOC;
			break;
	}
	return $documento_usado;
}

function determina_serie($tipo_doc,$Serie_NFe,$Serie_NFm,$Serie_DOC){
	switch($tipo_doc) {
		case "nfe":
			$serie_usada = $Serie_NFe;
			break;
		case "nfm":
			$serie_usada = $Serie_NFm;
			break;
		case "doc":
			$serie_usada = $Serie_DOC;
			break;
	}
	return $serie_usada;
}

/** Ajusta a periodicidade de custos fixos, para quando o usuario seleciona outros periodos não estipulados anteriormente **/
function ajusta_periodicidade($periodicidade_pre,$periodicidade_outros){
		if ($periodicidade_pre == 'outros') {
			return $periodicidade_outros;
		} else{
			return $periodicidade_pre;
		}
}

/** Verifica se as variaveis de id foram preenchidas **/
function verifica_ids($id_sucursal,$id_fornecedor,$id_unidade_fornecedor){

	if ($id_sucursal == "" || $id_fornecedor == "" || $id_unidade_fornecedor =="") {
		return false;
	} else {
		return TRUE;
	}
}

/** pega a id primaria da tabela nfs a que se refere a chave que foi armazenada para poder replica-la na tabela contas e duplicatas **/
function pega_id_nf_chave($chave){
	require('../../conectadb2.php');
	$sql2 = "SELECT * FROM `nfs` WHERE `chave`='$chave'";
	$query = $conectabase->query($sql2);
	$arr_idNf = $query->fetch_array();
	$idNf = $arr_idNf['idNFs'];
	return $idNf;
}

/** busca a ultima id inserida na tabela contas ou contas_sem_nfe (se for nfe é na tabela contas se for nfm ou doc é na contas_sem_nfe) **/
function ultima_id_contas($tipo_doc){
	require('../../conectadb2.php');

	switch ($tipo_doc) {
		case "nfe":
			$sql = "SELECT `idContas` FROM `contas` ORDER BY `idContas` DESC LIMIT 1";
			$query = $conectabase->query($sql);
			$arr_idContas = $query->fetch_array();
			$idContas = $arr_idContas['idContas'];
			break;
		case "nfm":
			$sql = "SELECT `idContas_sem_nfe` FROM `contas_sem_nfe` ORDER BY `idContas_sem_nfe` DESC LIMIT 1";
			$query = $conectabase->query($sql);
			$arr_idContas_sem_nfe = $query->fetch_array();
			$idContas = $arr_idContas_sem_nfe['idContas_sem_nfe'];
			break;
		case "doc":
			$sql = "SELECT `idContas_sem_nfe` FROM `contas_sem_nfe` ORDER BY `idContas_sem_nfe` DESC LIMIT 1";
			$query = $conectabase->query($sql);
			$arr_idContas_sem_nfe = $query->fetch_array();
			$idContas = $arr_idContas_sem_nfe['idContas_sem_nfe'];
			break;
		default:
			return FALSE;
	} // switch($tipo_doc)

	return $idContas;

}

/** popula a tabela nfs com a NFe que foi cadastrada **/
// usada apenas quando o documento é uma NFe (nota fiscal eletrônica), pois essa tabela exige chave que é um index unique
function insere_NFe($id_sucursal,$id_fornecedor,$id_unidade_fornecedor,$chave,$num_NF,$valor_total,$valor_liquido,$desconto){
	if (verifica_ids($id_sucursal,$id_fornecedor,$id_unidade_fornecedor)==TRUE) {
		require('../../conectadb2.php');
		$sql_insert_NFs = "INSERT INTO `nfs` (`chave`,`status`, `numero`, `valor_total`,`desconto`,`valor_liquido`,
		 `Unidade_fornecedor_idUnidade_fornecedor`, `Sucursal_idSucursal`, `Unidade_fornecedor_fornecedor_idFornecedor`)
		 VALUES ('$chave','entregue','$num_NF','$valor_total','$desconto','$valor_liquido','$id_unidade_fornecedor','$id_sucursal', '$id_fornecedor');";
		$inserir_NFs = $conectabase->query($sql_insert_NFs);
	} if ($inserir_NFs) {
		return TRUE;
	} else{
		$num_erro = $conectabase->errno;
		$erro = array ('tabela' => 'nfs','tp_conta' => '0','tipo_doc' => 'nfe','numero' => '01','numero_banco'=> $num_erro);
		//$erro = 'Erro: ('. $conectabase->errno .') '. $conectabase->error;
		return $erro;
	}
}

/** Popula a tabela contas com uma conta nova para a NFe cadastrada **/
// serve apenas para contas de NFes [Nota fiscal eletronica], pois está diretamente ligada a tabela nfs que exige chave
function insere_conta_fixa($tipo_doc,$tipo,$forma_conta,$numero_documento,$serie_documento,$periodicidade,$inicio,$fim,
$id_sucursal,$id_fornecedor,$id_unidade_fornecedor,$valor_total=null,$valor_liquido=null,$desconto=null){
	require('../../conectadb2.php');
	require_once('../../functions/tempo.php');

	if (verifica_ids($id_sucursal,$id_fornecedor,$id_unidade_fornecedor)==TRUE) {
	//	$idNf = pega_id_nf_chave($chave);
	switch ($tipo_doc) {
		case "nfm":
			$intervalo = converte_periodo_em_dias($inicio,$fim);
			$qtd_ciclos = calcula_qtd_ciclos($intervalo,$periodicidade);

			$sql_insert_conta = "INSERT INTO `contas_sem_nfe`(`tipo_doc`, `numero_doc`, `serie_doc`, `valor_bruto`, `valor_liquido`, `valor_desconto`, `status`, `tipo_despesa`, `qtd_parcelas`, `forma_conta`, `idUnidadeFornecedor`, `idFornecedor`, `idSucursal`,`inicio`,`fim`)
		VALUES ('Nota Fiscal Manual','$numero_documento','$serie_documento','$valor_total','$valor_liquido','$desconto','ativo','$tipo','$qtd_ciclos','fixa','$id_unidade_fornecedor','$id_fornecedor','$id_sucursal','$inicio','$fim');";
				$inserir_conta = $conectabase->query($sql_insert_conta);
			if ($inserir_conta) {
				return TRUE;
			} else{
				$num_erro = $conectabase->errno;
				$erro = array ('tabela' => 'contas_sem_nfe','tp_conta' => 'fixa','tipo_doc' => 'nfm','numero' => '01','numero_banco'=> $num_erro);
				//$erro = 'Erro: ('. $conectabase->errno .') '. $conectabase->error;
				return $erro;
			}
			break;
		case "doc":
			$intervalo = converte_periodo_em_dias($inicio,$fim);
			$qtd_ciclos = calcula_qtd_ciclos($intervalo,$periodicidade);

			$sql_insert_conta = "INSERT INTO `contas_sem_nfe`(`tipo_doc`, `numero_doc`, `serie_doc`, `valor_bruto`, `valor_liquido`, `valor_desconto`, `status`, `tipo_despesa`, `qtd_parcelas`, `forma_conta`, `idUnidadeFornecedor`, `idFornecedor`, `idSucursal`,`inicio`,`fim`)
		VALUES ('Outro Documento','$numero_documento','$serie_documento','$valor_total','$valor_liquido','$desconto','ativo','$tipo','$qtd_ciclos','fixa','$id_unidade_fornecedor','$id_fornecedor','$id_sucursal','$inicio','$fim');";
				$inserir_conta = $conectabase->query($sql_insert_conta);
			if ($inserir_conta) {
				return TRUE;
			} else{
				//$erro = 'Erro: ('. $conectabase->errno .') '. $conectabase->error;
				$num_erro = $conectabase->errno;
				$erro = array ('tabela' => 'contas_sem_nfe','tp_conta' => 'fixa','tipo_doc' => 'doc','numero' => '01','numero_banco'=> $num_erro);
				return $erro;
			}
		 	break;
		case "nfe":
			if (insere_NFe($id_sucursal,$id_fornecedor,$id_unidade_fornecedor,$chave,$numero_documento,$valor_total,$valor_liquido,$desconto) !== TRUE) {
				$erro = insere_NFe($id_sucursal,$id_fornecedor,$id_unidade_fornecedor,$chave,$numero_documento,$valor_total,$valor_liquido,$desconto);
				return $erro;
			}else{
				$idNf = pega_id_nf_chave($chave);
				$intervalo = converte_periodo_em_dias($inicio,$fim);
				$qtd_ciclos = calcula_qtd_ciclos($intervalo,$periodicidade);

				$sql_insert_contas_a_pagar = "INSERT INTO `contas` (`tipo`, `qtd_parcelas`, `total`, `status`, `NFs_idNFs`,
		 		`NFs_Unidade_fornecedor_idUnidade_fornecedor`, `NFs_Unidade_fornecedor_fornecedor_idFornecedor`, `NFs_Sucursal_idSucursal`)
	 			VALUES ('$tipo','$qtd_ciclos','$valor_liquido','pendente','$idNf','$id_unidade_fornecedor','$id_fornecedor','$id_sucursal');";
				$inserir_contas_a_pagar = $conectabase->query($sql_insert_contas_a_pagar);
				if ($inserir_contas_a_pagar) {
				return TRUE;
				} else{
					$num_erro = $conectabase->errno;
					$erro = array ('tabela' => 'contas','tp_conta' => 'fixa','tipo_doc' => 'nfe','numero' => '01','numero_banco'=> $num_erro);
					$sql_del_nf = "DELETE FROM `nfs` WHERE `chave` = '$chave';";
					mysqli_query($conectabase,$sql_del_nf);
					//$url_conta = '../../insere_contas_fornecedores.php?retorno=fracasso&setor=conta&chave='.$chave;
					//header("location:$url_conta");
					//$erro = 'Erro: ('. $conectabase->errno .') '. $conectabase->error;
					return $erro;
				}
			}
			break;
		default:
			$erro = array ('tabela' => '0','tp_conta' => 'fixa','tipo_doc' => '0','numero' => '03','numero_banco'=> '0');
			//$erro = "Tipo de documento inválido ou não estipulado";
			return $erro;
	} // switch
		} else{
			$erro = array ('tabela' => '0','tp_conta' => 'fixa','tipo_doc' => '0','numero' => '02','numero_banco'=> '0');
			//$erro = 'Sucursal e/ou fornecedor não estipulado';
			return $erro;
		}
}

//$num_documento pode ser de NF manual ou outro doc qualquer, o mesmo pa série
function insere_conta_variavel($tipo_doc,$obs_doc,$forma_conta,$numero_documento,$serie_documento,$id_sucursal,$id_fornecedor,
$id_unidade_fornecedor,$tipo,$valor_total,$valor_liquido,$desconto,$Num_de_parcelas,$chave=null){
	require('../../conectadb2.php');

	if (verifica_ids($id_sucursal,$id_fornecedor,$id_unidade_fornecedor)==TRUE) {
		switch ($tipo_doc) {
			case "nfm":
				$sql_insert_conta = "INSERT INTO `contas_sem_nfe`(`tipo_doc`, `numero_doc`, `serie_doc`, `valor_bruto`, `valor_liquido`, `valor_desconto`, `status`, `tipo_despesa`, `qtd_parcelas`, `forma_conta`, `idUnidadeFornecedor`, `idFornecedor`, `idSucursal`)
		VALUES ('Nota Fiscal Manual','$numero_documento','$serie_documento','$valor_total','$valor_liquido','$desconto','ativo','$tipo','$Num_de_parcelas','variavel','$id_unidade_fornecedor','$id_fornecedor','$id_sucursal');";
					$inserir_conta = $conectabase->query($sql_insert_conta);
				if ($inserir_conta) {
					return TRUE;
				} else{
					//$erro = 'Erro: ('. $conectabase->errno .') '. $conectabase->error;
					$num_erro = $conectabase->errno;
					$erro = array ('tabela' => 'contas_sem_nfe','tp_conta' => 'variavel','tipo_doc' => 'nfm','numero' => '01','numero_banco'=> $num_erro);
					return $erro;
				}
				break;
			case "doc":
				$sql_insert_conta = "INSERT INTO `contas_sem_nfe`(`tipo_doc`,`obs`,`numero_doc`, `serie_doc`, `valor_bruto`, `valor_liquido`, `valor_desconto`, `status`, `tipo_despesa`, `qtd_parcelas`, `forma_conta`, `idUnidadeFornecedor`, `idFornecedor`, `idSucursal`)
		VALUES ('Outros documentos','$obs_doc','$numero_documento','$serie_documento','$valor_total','$valor_liquido','$desconto','ativo','$tipo','$Num_de_parcelas','variavel','$id_unidade_fornecedor','$id_fornecedor','$id_sucursal');";
					$inserir_conta = $conectabase->query($sql_insert_conta);
				if ($inserir_conta) {
					return TRUE;
				} else{
					//$erro = 'Erro: ('. $conectabase->errno .') '. $conectabase->error;
					$num_erro = $conectabase->errno;
					$erro = array ('tabela' => 'contas_sem_nfe','tp_conta' => 'variavel','tipo_doc' => 'doc','numero' => '01','numero_banco'=> $num_erro);
					return $erro;
				}
				break;
			case "nfe":
				if (insere_NFe($id_sucursal,$id_fornecedor,$id_unidade_fornecedor,$chave,$numero_documento,$valor_total,$valor_liquido,$desconto) !== TRUE) {

					$erro = insere_NFe($id_sucursal,$id_fornecedor,$id_unidade_fornecedor,$chave,$numero_documento,$valor_total,$valor_liquido,$desconto);
					return $erro;
					//$url_nf = '../../insere_contas_fornecedores.php?retorno=fracasso&setor=nf&chave='.$chave;
					//return $url_nf;
				}else{

					$idNf = pega_id_nf_chave($chave);

					$sql_insert_contas_a_pagar = "INSERT INTO `contas` (`tipo`, `qtd_parcelas`, `total`, `status`, `NFs_idNFs`,
				 	`NFs_Unidade_fornecedor_idUnidade_fornecedor`, `NFs_Unidade_fornecedor_fornecedor_idFornecedor`, `NFs_Sucursal_idSucursal`)
		 			VALUES ('$tipo','$Num_de_parcelas','$valor_liquido','ativo','$idNf','$id_unidade_fornecedor','$id_fornecedor','$id_sucursal');";
					$inserir_contas_a_pagar = $conectabase->query($sql_insert_contas_a_pagar);
					if ($inserir_contas_a_pagar) {
						return TRUE;
					} else{
						$num_erro = $conectabase->errno;
						$erro = array ('tabela' => 'contas','tp_conta' => 'variavel','tipo_doc' => 'nfe','numero' => '01','numero_banco'=> $num_erro);
						//$erro = 'Erro: ('. $conectabase->errno .') '. $conectabase->error;
						$sql_del_nf = "DELETE FROM `nfs` WHERE `chave` = '$chave';";
						mysqli_query($conectabase,$sql_del_nf);
						//$url_conta = '../../insere_contas_fornecedores.php?retorno=fracasso&setor=conta&chave='.$chave;
						//header("location:$url_conta");

						return $erro;
					}
				}
				break;
			default:
				$erro = array ('tabela' => '0','tp_conta' => 'variavel','tipo_doc' => '0','numero' => '03','numero_banco'=> '0');
				//$erro = "Tipo de documento inválido ou não estipulado";
				return $erro;
		} // switch tipo_doc

	} else {
		$erro = array ('tabela' => '0','tp_conta' => 'variavel','tipo_doc' => '0','numero' => '02','numero_banco'=> '0');
		//$erro = 'Sucursal e/ou fornecedor não estipulado';
		return $erro;
	}
}

function insere_duplicata_fixa($forma_pagamento,$tipo_doc,$forma_conta,$obs_doc,$inicio,$fim,$periodicidade,$valor_estimado,$id_sucursal,$id_fornecedor,$id_unidade_fornecedor,$chave = 'nulo'){
	require_once('../../functions/tempo.php');
	require('../../conectadb2.php');

	if(verifica_ids($id_sucursal,$id_fornecedor,$id_unidade_fornecedor)==TRUE){

	$id_ultima_conta = ultima_id_contas($tipo_doc);
	$intervalo = converte_periodo_em_dias($inicio,$fim);
	$qtd_ciclos = calcula_qtd_ciclos($intervalo,$periodicidade);
	$valor_parcela = converte_numero($valor_estimado);
	$vencimentos_periodicos = cria_vencimentos_periodicos($inicio,$fim,$periodicidade);

		// abaixo trocar a cadeia de IF por SWITCH CASE
	switch ($tipo_doc) {
		case "nfm":
			$sql_dup = "INSERT INTO `duplicatas_sem_nfe`(`form_pg`,`valor`, `vencimento`, `posicao_parcela`, `status`, `idContas_sem_nfe`, `idSucursal`, `idUnidade_fornecedor`, `idFornecedor`) VALUES";
			for ($i = 0; $i < $qtd_ciclos; $i++ ){
				$posi = 1+$i;
				$vencimento_x = $vencimentos_periodicos[$i];
				$sql_dup .="('$forma_pagamento','$valor_parcela','$vencimento_x','$posi','pendente','$id_ultima_conta','$id_sucursal','$id_unidade_fornecedor','$id_fornecedor'),";
			}
			$sql_dup = substr($sql_dup,0,-1 );
			$inserir_duplicatas = $conectabase->query($sql_dup);
			if ($inserir_duplicatas) {
				//echo 'Cool';
				return TRUE;
			}else{
				$num_erro = $conectabase->errno;
				$erro = array ('tabela' => 'duplicatas_sem_nfe','tp_conta' => 'fixa','tipo_doc' => 'nfm','numero' => '01','numero_banco'=> $num_erro);
				//$erro = 'Erro: ('. $conectabase->errno .') '. $conectabase->error;
				return $erro;
			}
			break;
		case "doc":
			$sql_dup = "INSERT INTO `duplicatas_sem_nfe`(`form_pg`,`valor`, `vencimento`, `posicao_parcela`, `status`, `idContas_sem_nfe`, `idSucursal`, `idUnidade_fornecedor`, `idFornecedor`) VALUES";
			for ($i = 0; $i < $qtd_ciclos; $i++ ){
				$posi = 1+$i;
				$vencimento_x = $vencimentos_periodicos[$i];
				$sql_dup .="('$forma_pagamento','$valor_parcela','$vencimento_x','$posi','pendente','$id_ultima_conta','$id_sucursal','$id_unidade_fornecedor','$id_fornecedor'),";
			}
			$sql_dup = substr($sql_dup,0,-1 );
			$inserir_duplicatas = $conectabase->query($sql_dup);
			if ($inserir_duplicatas) {
				return TRUE;
			}else{
				$num_erro = $conectabase->errno;
				$erro = array ('tabela' => 'duplicatas_sem_nfe','tp_conta' => 'fixa','tipo_doc' => 'nfm','numero' => '01','numero_banco'=> $num_erro);
			//	$erro = 'Erro: ('. $conectabase->errno .') '. $conectabase->error;
				return $erro;
			}
			break;
		case "nfe":
			$idNf = pega_id_nf_chave($chave);
			$sql_dup = "INSERT INTO `duplicatas` (`form_pg`,`valor`,`vencimento`, `posicao_parcela`, `status`, `Contas_idContas`, `Contas_NFs_idNFs`,
		 `Contas_NFs_Unidade_fornecedor_idUnidade_fornecedor`,`Contas_NFs_Unidade_fornecedor_fornecedor_idFornecedor`,
		 `Contas_NFs_Sucursal_idSucursal`) VALUES";
			for ($i = 0; $i < $qtd_ciclos; $i++ ){
				$posi = 1+$i;
				$vencimento_x = $vencimentos_periodicos[$i];
				//$vencimento_x = ajusta_data_to_mysql($vencimento_x_comum);

				$sql_dup .="('$forma_pagamento','$valor_parcela','$vencimento_x','$posi','pendente','$id_ultima_conta','$idNf','$id_unidade_fornecedor','$id_fornecedor','$id_sucursal'),";
			}
			$sql_dup = substr($sql_dup,0,-1 );
			$inserir_duplicatas = $conectabase->query($sql_dup);
			if ($inserir_duplicatas) {
				//echo 'Cool
				return TRUE;
			} else{
				$num_erro = $conectabase->errno;
				$erro = array ('tabela' => 'duplicatas','tp_conta' => 'fixa','tipo_doc' => 'nfe','numero' => '01','numero_banco'=> $num_erro);
				//$erro = 'Erro: ('. $conectabase->errno .') '. $conectabase->error;
				return $erro;
			}
			break;

		default:
			$erro = array ('tabela' => '0','tp_conta' => 'fixa','tipo_doc' => '0','numero' => '03','numero_banco'=> '0');
			//$erro = "Tipo de documento inválido ou não estipulado";
			return $erro;
	} // switch
	}else{
		$erro = array ('tabela' => '0','tp_conta' => 'fixa','tipo_doc' => '0','numero' => '02','numero_banco'=> '0');
		//$erro = 'Sucursal e/ou fornecedor não estipulado';
		return $erro;
	}
}

function insere_duplicata_variavel($forma_pagamento,$tipo_doc,$forma_conta,$obs_doc,$vencimentos_parcelas,$valor_parcelas,$Num_de_parcelas,$posicao,$id_sucursal,$id_fornecedor,$id_unidade_fornecedor,$chave){
	require('../../functions/tempo.php');
	require('../../conectadb2.php');

	if(verifica_ids($id_sucursal,$id_fornecedor,$id_unidade_fornecedor)==TRUE){

		$id_ultima_conta = ultima_id_contas($tipo_doc);

		// abaixo trocar a cadeia de IF por SWITCH CASE
		switch ($tipo_doc) {
			case "nfm":
				$sql_dup ="INSERT INTO `duplicatas_sem_nfe`(`form_pg`,`valor`, `vencimento`, `posicao_parcela`, `status`, `idContas_sem_nfe`, `idSucursal`, `idUnidade_fornecedor`, `idFornecedor`) VALUES";
				for ($i=0;$i<count($vencimentos_parcelas);$i++){
					$posi = 1+$i;
					$valor_parcela_x_br = $valor_parcelas[$i];
					$valor_parcela_x = converte_numero($valor_parcela_x_br);
					$vencimento_x = $vencimentos_parcelas[$i];
					//$vencimento_x = ajusta_data_to_mysql($vencimento_x_comum);

					$sql_dup .="('$forma_pagamento','$valor_parcela_x','$vencimento_x','$posi','pendente','$id_ultima_conta','$id_sucursal','$id_unidade_fornecedor','$id_fornecedor'),";
				}
				$sql_dup = substr($sql_dup,0,-1 );
				$inserir_duplicatas = $conectabase->query($sql_dup);
				if ($inserir_duplicatas) {
					//echo 'Cool';
					return TRUE;
				} else{
					$num_erro = $conectabase->errno;
					$erro = array ('tabela' => 'duplicatas_sem_nfe','tp_conta' => 'variavel','tipo_doc' => 'nfm','numero' => '01','numero_banco'=> $num_erro);
					//$erro = 'Erro: ('. $conectabase->errno .') '. $conectabase->error;
					return $erro;
				}
				break;
			case "doc":
				$sql_dup ="INSERT INTO `duplicatas_sem_nfe`(`form_pg`,`valor`, `vencimento`, `posicao_parcela`, `status`, `idContas_sem_nfe`, `idSucursal`, `idUnidade_fornecedor`, `idFornecedor`) VALUES";
				for ($i=0;$i<count($vencimentos_parcelas);$i++){
					$posi = 1+$i;
					$valor_parcela_x_br = $valor_parcelas[$i];
					$valor_parcela_x = converte_numero($valor_parcela_x_br);
					$vencimento_x = $vencimentos_parcelas[$i];
					//$vencimento_x = ajusta_data_to_mysql($vencimento_x_comum);

					$sql_dup .="('$forma_pagamento','$valor_parcela_x','$vencimento_x','$posi','pendente','$id_ultima_conta','$id_sucursal','$id_unidade_fornecedor','$id_fornecedor'),";
				}
				$sql_dup = substr($sql_dup,0,-1 );
				$inserir_duplicatas = $conectabase->query($sql_dup);
				if ($inserir_duplicatas) {
					//echo 'Cool';
					return TRUE;
				} else{
					$num_erro = $conectabase->errno;
					$erro = array ('tabela' => 'duplicatas_sem_nfe','tp_conta' => 'variavel','tipo_doc' => 'doc','numero' => '01','numero_banco'=> $num_erro);
				}
				break;
			case "nfe":
				$idNf = pega_id_nf_chave($chave);

				$sql_dup = "INSERT INTO `duplicatas` (`form_pg`,`valor`,`vencimento`, `posicao_parcela`, `status`, `Contas_idContas`, `Contas_NFs_idNFs`,
		 `Contas_NFs_Unidade_fornecedor_idUnidade_fornecedor`,`Contas_NFs_Unidade_fornecedor_fornecedor_idFornecedor`,
		 `Contas_NFs_Sucursal_idSucursal`) VALUES";

				for ($i=0;$i<count($vencimentos_parcelas);$i++){
					$posi = 1+$i;
					$valor_parcela_x_br = $valor_parcelas[$i];
					$valor_parcela_x = converte_numero($valor_parcela_x_br);
					$vencimento_x = $vencimentos_parcelas[$i];
					//$vencimento_x = ajusta_data_to_mysql($vencimento_x_comum);

					$sql_dup .="('$forma_pagamento','$valor_parcela_x','$vencimento_x','$posi','pendente','$id_ultima_conta','$idNf','$id_unidade_fornecedor','$id_fornecedor','$id_sucursal'),";
				}
				$sql_dup = substr($sql_dup,0,-1 );
				$inserir_duplicatas = $conectabase->query($sql_dup);
				if ($inserir_duplicatas) {
					//echo 'Cool';
					return TRUE;
				} else{
					$num_erro = $conectabase->errno;
					$erro = array ('tabela' => 'duplicatas','tp_conta' => 'variavel','tipo_doc' => 'nfe','numero' => '01','numero_banco'=> $num_erro);
				}
				break;

			default:
				$erro = array ('tabela' => '0','tp_conta' => 'fixa','tipo_doc' => '0','numero' => '03','numero_banco'=> '0');
				//$erro = "Tipo de documento inválido ou não estipulado";
				return $erro;
		} // switch
	}else{
		$erro = array ('tabela' => '0','tp_conta' => 'fixa','tipo_doc' => '0','numero' => '02','numero_banco'=> '0');
		//$erro = 'Sucursal e/ou fornecedor não estipulado';
		return $erro;
	}
}

/** Insere Duplicatas da NFe cadastrada (função substituida por insere_duplicata_variavel
// usada somente se for uma NFe (Nota fiscal eletronica) com chave da receita, pois está ligada a tabela nfs que exige a chave como um index unique
function insere_duplicatas($id_sucursal,$id_fornecedor,$id_unidade_fornecedor,$chave,$vencimentos_parcelas,$valor_parcelas,$Num_de_parcelas,$posicao){
	require('../../conectadb2.php');
	if(verifica_ids($id_sucursal,$id_fornecedor,$id_unidade_fornecedor)==TRUE){


		$id_ultima_conta = ultima_id_contas($tipo_doc);
		$idNf = pega_id_nf_chave($chave);

		$sql_dup = "INSERT INTO `duplicatas` (`valor`,`vencimento`, `posicao_parcela`, `status`, `Contas_idContas`, `Contas_NFs_idNFs`,
		 `Contas_NFs_Unidade_fornecedor_idUnidade_fornecedor`,`Contas_NFs_Unidade_fornecedor_fornecedor_idFornecedor`,
		 `Contas_NFs_Sucursal_idSucursal`) VALUES";

		for ($i=0;$i<count($vencimentos_parcelas);$i++){
			$posi = 1+$i;
			$valor_parcela_x_br = $valor_parcelas[$i];
			$valor_parcela_x = converte_numero($valor_parcela_x_br);
			$vencimento_x = $vencimentos_parcelas[$i];
			//$vencimento_x = ajusta_data_to_mysql($vencimento_x_comum);

			$sql_dup .="('$valor_parcela_x','$vencimento_x','$posi','pendente','$id_ultima_conta','$idNf','$id_unidade_fornecedor','$id_fornecedor','$id_sucursal'),";
		}
		$sql_dup = substr($sql_dup,0,-1 );
		$inserir_duplicatas = $conectabase->query($sql_dup);
		if ($inserir_duplicatas) {
			//echo 'Cool';
			return TRUE;
		} else{
			$erro = 'Erro: ('. $conectabase->errno .') '. $conectabase->error;
			return $erro;
		}
	} else {
		$erro = 'Erro: ('. $conectabase->errno .') '. $conectabase->error;
		return $erro;
	}
}
**/
/** usa o arquivo funcoes_chave.php para determinar se a chave é válida **/
function testa_chave($chave){
	require('../../functions/funcoes_chave.php');
	$array_chave = Monta_array_chave($chave);
	$chave43=substr($chave,0,43 );
	$UFsigla = codifica_UF($array_chave[0]);

	if (calcula_dv($chave43)!=$array_chave[9]) {
		return FALSE;
	}elseif (strlen($chave)<>44) {
		return FALSE;
	}elseif ($UFsigla == 'XX') {
		return FALSE;

	}else{
		return TRUE;
	}
}

/** Execução **/

/** Puxando dados do formulario **/
$tipo = $_POST['tipo_conta']; //mercadoria, financeiro, despesas, etc...
$forma_conta = $_POST['forma_conta']; //variavel, fixa
$tipo_doc = $_POST['tipo_doc']; //nfe, nfm, doc
$obs_doc = $_POST['Obs_DOC'];

if (isset($_POST['Chave_NFe'])) {
	$chave_suja = $_POST['Chave_NFe'];
	$chave = limpa_input_chave($chave_suja); //puxa função que ajusta a chave sem a mascara
}



$num_NFe = $_POST['Num_NFe'];
$num_NFm = $_POST['Num_NFm'];
$num_DOC = $_POST['Num_DOC'];
$numero_documento = determina_documento($tipo_doc,$num_NFe,$num_NFm,$num_DOC);


$Serie_NFe = $_POST['Serie_NFe'];
$Serie_NFm = $_POST['Serie_NFm'];
$Serie_DOC = $_POST['Serie_DOC'];
$serie_documento = determina_serie($tipo_doc,$Serie_NFe,$Serie_NFm,$Serie_DOC);

$valor_NFe_br = $_POST['Valor_NFe'];
$valor_NFm_br = $_POST['Valor_NFm'];
$valor_DOC_br = $_POST['Valor_NFm'];

$desconto_nfe_br = $_POST['desconto_nfe'];
$desconto_nfm_br = $_POST['desconto_nfm'];
$desconto_doc_br = $_POST['desconto_doc'];

$id_sucursal = $_POST['sucursal'];
$id_fornecedor = $_POST['fornecedor'];
$id_unidade_fornecedor = $_POST['unidade_fornecedor'];

// Dados do faturamento
$vencimentos_parcelas = $_POST['vencimento'];
$valor_parcelas = $_POST['valor'];
$Num_de_parcelas = count($vencimentos_parcelas);
$posicao = array_keys($vencimentos_parcelas);

$valor_estimado = $_POST['parcela_estimada'];

$form_pag = $_POST['fp'];
$form_pag_nfe = $_POST['fp_nfe'];
$fp = determina_fp($tipo_doc,$form_pag,$form_pag_nfe);

$inicio = $_POST['inicio'];
$fim = $_POST['fim'];
$periodicidade_pre = $_POST['periodicidade']; // PERIODICIDADE PREDEFINIFA
$periodicidade_outros = $_POST['periodicidade_outros']; //NUMERO DE DIAS DIGITADO PELO USUARIO CASO ELE SELECIONE OUTROS NO DROPBOX PERIODICIDADE

/** Tratando e selecionando alguns dados puxados **/

$valor_NFe = converte_numero($valor_NFe_br);
$valor_NFm = converte_numero($valor_NFm_br);
$valor_DOC = converte_numero($valor_DOC_br);
$valor_total = determina_valor_total($tipo_doc,$valor_NFe,$valor_NFm,$valor_DOC);

$desconto_nfe = converte_numero($desconto_nfe_br);
$desconto_nfm = converte_numero($desconto_nfm_br);
$desconto_doc = converte_numero($desconto_doc_br);
$desconto = determina_desconto($tipo_doc,$desconto_nfe,$desconto_nfm,$desconto_doc);


$desconto = determina_desconto($tipo_doc,$desconto_nfe,$desconto_nfm,$desconto_doc);
$valor_liquido = $valor_total - $desconto;

$periodicidade = ajusta_periodicidade($periodicidade_pre,$periodicidade_outros );


switch($forma_conta){
	case"fixa":
		if (insere_conta_fixa($tipo_doc,$tipo ,$forma_conta ,$numero_documento ,$serie_documento ,$periodicidade ,$inicio ,$fim ,$id_sucursal ,$id_fornecedor ,$id_unidade_fornecedor,$valor_total,$valor_liquido,$desconto) !== TRUE) {

			$erro = insere_conta_fixa($tipo_doc,$tipo ,$forma_conta ,$numero_documento ,$serie_documento ,$periodicidade ,$inicio ,$fim ,$id_sucursal ,$id_fornecedor ,$id_unidade_fornecedor,$valor_total,$valor_liquido,$desconto);
			$erro_tabela = $erro['tabela'];
			$erro_tp_conta = $erro['tp_conta'];
			$erro_tipo_doc = $erro['tipo_doc'];
			$erro_numero = $erro['numero'];
			$erro_numero_banco = $erro['numero_banco'];
			$url = '../../insere_contas_fornecedores.php?retorno=fracasso&tb='.$erro_tabela.'&tp_conta='.$erro_tp_conta.'&tp_doc='.$erro_tipo_doc.'&num_erro='.$erro_numero.'&num_errdb='.$erro_numero_banco.'&num_doc='.$numero_documento;
			//$url_conta = '../../insere_contas_fornecedores.php?retorno=fracasso&setor=conta&chave='.$numero_documento;
			header("location:$url");
			//echo $inicio;
			//echo "<br>";
			//echo $fim;
		}elseif(insere_duplicata_fixa($fp,$tipo_doc,$forma_conta ,$obs_doc ,$inicio ,$fim ,$periodicidade ,$valor_estimado,$id_sucursal,$id_fornecedor,$id_unidade_fornecedor,$chave)!== TRUE){
			switch ($tipo_doc) {
				case "nfe"://no caso apenas existe um case nfe, pois nessa situação temos que também apagar a tabela do banco nfs
					$erro = insere_duplicata_fixa($fp,$tipo_doc,$forma_conta ,$obs_doc ,$inicio ,$fim ,$periodicidade ,$valor_estimado,$id_sucursal,$id_fornecedor,$id_unidade_fornecedor,$chave);
					$ultima_conta = ultima_id_contas($tipo_doc);
					$sql_del_conta = "DELETE FROM `contas` WHERE `idContas` = '$ultima_conta'; ";
					mysqli_query($conectabase,$sql_del_conta );
					//$url_duplicata = '../../insere_contas_fornecedores.php?retorno=fracasso&setor=duplicata&chave='.$numero_documento;
					$erro_tabela = $erro['tabela'];
					$erro_tp_conta = $erro['tp_conta'];
					$erro_tipo_doc = $erro['tipo_doc'];
					$erro_numero = $erro['numero'];
					$erro_numero_banco = $erro['numero_banco'];
					$url = '../../insere_contas_fornecedores.php?retorno=fracasso&tb='.$erro_tabela.'&tp_conta='.$erro_tp_conta.'&tp_doc='.$erro_tipo_doc.'&num_erro='.$erro_numero.'&num_errdb='.$erro_numero_banco.'&num_doc='.$numero_documento;
					header("location: $url");
					break;
				default:
					$erro = insere_duplicata_fixa($fp,$tipo_doc,$forma_conta ,$obs_doc ,$inicio ,$fim ,$periodicidade ,$valor_estimado,$id_sucursal,$id_fornecedor,$id_unidade_fornecedor,$chave);
					$ultima_conta = ultima_id_contas($tipo_doc);
					$sql_del_conta = "DELETE FROM `contas_sem_nfe` WHERE `idContas_sem_nfe` = '$ultima_conta'; ";
					mysqli_query($conectabase,$sql_del_conta );
					//$url_duplicata = '../../insere_contas_fornecedores.php?retorno=fracasso&setor=duplicata&chave='.$numero_documento;
					$erro_tabela = $erro['tabela'];
					$erro_tp_conta = $erro['tp_conta'];
					$erro_tipo_doc = $erro['tipo_doc'];
					$erro_numero = $erro['numero'];
					$erro_numero_banco = $erro['numero_banco'];
					$url = '../../insere_contas_fornecedores.php?retorno=fracasso&tb='.$erro_tabela.'&tp_conta='.$erro_tp_conta.'&tp_doc='.$erro_tipo_doc.'&num_erro='.$erro_numero.'&num_errdb='.$erro_numero_banco.'&num_doc='.$numero_documento;
					header("location: $url");
			} // switch tipo_doc
		}else{
			$url = '../../insere_contas_fornecedores.php?retorno=sucesso&tp_conta='.$forma_conta.'&tp_doc='.$tipo_doc.'&num_doc='.$numero_documento;
			//$url_s = '../../insere_contas_fornecedores.php?retorno=sucesso&setor=duplicata&chave='.$numero_documento;
			header("location: $url");
		}
		break;
	case "variavel":
		if (insere_conta_variavel($tipo_doc,$obs_doc,$forma_conta,$numero_documento,$serie_documento,$id_sucursal,$id_fornecedor,$id_unidade_fornecedor,$tipo,$valor_total,$valor_liquido,$desconto,$Num_de_parcelas,$chave)!== TRUE) {
			$erro =insere_conta_variavel($tipo_doc,$obs_doc,$forma_conta,$numero_documento,$serie_documento,$id_sucursal,$id_fornecedor,$id_unidade_fornecedor,$tipo,$valor_total,$valor_liquido,$desconto,$Num_de_parcelas,$chave);
			$erro_tabela = $erro['tabela'];
			$erro_tp_conta = $erro['tp_conta'];
			$erro_tipo_doc = $erro['tipo_doc'];
			$erro_numero = $erro['numero'];
			$erro_numero_banco = $erro['numero_banco'];
			$url = '../../insere_contas_fornecedores.php?retorno=fracasso&tb='.$erro_tabela.'&tp_conta='.$erro_tp_conta.'&tp_doc='.$erro_tipo_doc.'&num_erro='.$erro_numero.'&num_errdb='.$erro_numero_banco.'&num_doc='.$numero_documento;

			//$url_conta = '../../insere_contas_fornecedores.php?retorno=fracasso&setor=conta&chave='.$numero_documento;
			header("location:$url");
		} elseif (insere_duplicata_variavel($fp,$tipo_doc,$forma_conta,$obs_doc,$vencimentos_parcelas,$valor_parcelas,$Num_de_parcelas,$posicao,$id_sucursal,$id_fornecedor,$id_unidade_fornecedor,$chave)!==TRUE) {
			switch ($tipo_doc) {
				case "nfe":
					$erro = insere_duplicata_variavel($fp,$tipo_doc,$forma_conta,$obs_doc,$vencimentos_parcelas,$valor_parcelas,$Num_de_parcelas,$posicao,$id_sucursal,$id_fornecedor,$id_unidade_fornecedor,$chave);

					$ultima_conta = ultima_id_contas($tipo_doc);
					$sql_del_conta = "DELETE FROM `contas` WHERE `idContas` = '$ultima_conta'; ";
					mysqli_query($conectabase,$sql_del_conta );
					//$url_duplicata = '../../insere_contas_fornecedores.php?retorno=fracasso&setor=duplicata&chave='.$chave;
					$erro_tabela = $erro['tabela'];
					$erro_tp_conta = $erro['tp_conta'];
					$erro_tipo_doc = $erro['tipo_doc'];
					$erro_numero = $erro['numero'];
					$erro_numero_banco = $erro['numero_banco'];
					$url = '../../insere_contas_fornecedores.php?retorno=fracasso&tb='.$erro_tabela.'&tp_conta='.$erro_tp_conta.'&tp_doc='.$erro_tipo_doc.'&num_erro='.$erro_numero.'&num_errdb='.$erro_numero_banco.'&num_doc='.$numero_documento;
					header("location: $url");
					break;
				default:
					$erro = insere_duplicata_variavel($fp,$tipo_doc,$forma_conta,$obs_doc,$vencimentos_parcelas,$valor_parcelas,$Num_de_parcelas,$posicao,$id_sucursal,$id_fornecedor,$id_unidade_fornecedor,$chave);
					$ultima_conta = ultima_id_contas($tipo_doc);
					$sql_del_conta = "DELETE FROM `contas_sem_nfe` WHERE `idContas_sem_nfe` = '$ultima_conta'; ";
					mysqli_query($conectabase,$sql_del_conta );
					//$url_duplicata = '../../insere_contas_fornecedores.php?retorno=fracasso&setor=duplicata&chave='.$numero_documento;
					$erro_tabela = $erro['tabela'];
					$erro_tp_conta = $erro['tp_conta'];
					$erro_tipo_doc = $erro['tipo_doc'];
					$erro_numero = $erro['numero'];
					$erro_numero_banco = $erro['numero_banco'];
					$url = '../../insere_contas_fornecedores.php?retorno=fracasso&tb='.$erro_tabela.'&tp_conta='.$erro_tp_conta.'&tp_doc='.$erro_tipo_doc.'&num_erro='.$erro_numero.'&num_errdb='.$erro_numero_banco.'&num_doc='.$numero_documento;
					header("location: $url");
			} // switch tipo_doc
		}else{
			$url = '../../insere_contas_fornecedores.php?retorno=sucesso&tp_conta='.$forma_conta.'&tp_doc='.$tipo_doc.'&num_doc='.$numero_documento;
			//$url_s = '../../insere_contas_fornecedores.php?retorno=sucesso&setor=duplicata&chave='.$numero_documento;
			header("location: $url");
		}
		break;
	default:
		$url = '../../insere_contas_fornecedores.php?retorno=fracasso&tb=0&tp_conta=0&tp_doc='.$tipo_doc.'&num_erro=0&num_errdb=XXX&num_doc='.$numero_documento;
		//$url = '../../insere_contas_fornecedores.php?retorno=fracasso&tp_doc='.$tipo_doc.'&num_erro=05&num_doc='.$numero_documento;
		header("location: $url");
		//echo "forma de pagamento não identificada.";
}
