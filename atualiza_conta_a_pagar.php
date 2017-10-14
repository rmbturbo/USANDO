<?php
include('conectadb2.php');
$inicio = $_GET['inicio'];
$fim = $_GET['fim'];
$id_duplicata = $_POST['id_dup'];
$total = count($id_duplicata);

$situacao = $_POST['situacao'];
$fp = $_POST['fp'];
$valor_pago = $_POST['valor_pgo'];
$obs = $_POST['obs'];
$tabela_ou_idnfe = $_POST['tabela_ou_idnfe']; // serve para identificar se uma duplicata parte de uma conta com nfe ou sem nfe



	include('conectadb2.php');

	for ($i=0;$i<$total;$i++){
		$tabela_ou_idnfe_x = $tabela_ou_idnfe[$i];
		switch ($tabela_ou_idnfe_x) {
			case "Sem NFe":
				$id_dup_x = $id_duplicata[$i];
				$situacao_x = $situacao[$i];
				$valor_pago_x = $valor_pago[$i];
				$fp_x = $fp[$i];
				$obs_x = $obs[$i];
				$sql_up="UPDATE `duplicatas_sem_nfe` SET `valor_pago`='$valor_pago_x',`status`='$situacao_x',`form_pg`='$fp_x',`obs`='$obs_x' WHERE `idDuplicata_sem_nfe`='$id_dup_x'; ";

				$altera_duplicatas = $conectabase->query($sql_up);

				if ($altera_duplicatas) {
					$url_retorno = 'duplicatas_a_pagar.php?retorno=sucesso&inicio='.$inicio.'&fim='.$fim;
					header("location: $url_retorno");

				} else{
					$url_retorno = 'duplicatas_a_pagar.php?retorno=fracasso&inicio='.$inicio.'&fim='.$fim;
					header("location: $url_retorno");
				}
				break;
				default:
					$id_dup_x = $id_duplicata[$i];
					$situacao_x = $situacao[$i];
					$valor_pago_x = $valor_pago[$i];
					$fp_x = $fp[$i];
					$obs_x = $obs[$i];
					$sql_up="UPDATE `duplicatas` SET `valor_pago`='$valor_pago_x',`status`='$situacao_x',`form_pg`='$fp_x',`obs`='$obs_x' WHERE `idDuplicatas`='$id_dup_x'; ";

					$altera_duplicatas = $conectabase->query($sql_up);

					if ($altera_duplicatas) {
						$url_retorno = 'duplicatas_a_pagar.php?retorno=sucesso&inicio='.$inicio.'&fim='.$fim;
						header("location: $url_retorno");
					} else{
						$url_retorno = 'duplicatas_a_pagar.php?retorno=fracasso&inicio='.$inicio.'&fim='.$fim;
						header("location: $url_retorno");
					}
		} // switch
	}


?>