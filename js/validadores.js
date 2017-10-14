
function checkNumber(valor) {
	var regra = /^[0-9]+$/;
	if (valor.match(regra))
		return true;
};

// esta funçao foi criada afim de resolver um preblema para a função ValidaChaveNFE fora dela entregando a chave em forma de string sem os intervalos da mascara
function LimpaInputChave(campo_chave){
	if (checkNumber(campo_chave) == true) {
		var chave_limpa = campo_chave;
		return chave_limpa;
	} else {

	var c1=campo_chave.substring(0,4);
	var c2=campo_chave.substring(5,9);
	var c3=campo_chave.substring(10,14);
	var c4=campo_chave.substring(15,19);
	var c5=campo_chave.substring(20,24);
	var c6=campo_chave.substring(25,29);
	var c7=campo_chave.substring(30,34);
	var c8=campo_chave.substring(35,39);
	var c9=campo_chave.substring(40,44);
	var c10=campo_chave.substring(45,49);
	var c11=campo_chave.substring(50,54);
	var chave_limpa = new String (c1+c2+c3+c4+c5+c6+c7+c8+c9+c10+c11);

	return chave_limpa;
	}
}


// esta função retorna true se a chave for boa e false se for ruim. Ideal que seja usada em conjunto com a Retorna_result_chave
function ValidaChaveNFE(chave_suja) {
	//var chave = "43160390312133001087550010000687491017210992";

	var chave = LimpaInputChave(chave_suja);
//	alert(chave);
	var multiplicadores;
	var chavedv;
	var QtdMultiplicadores;
	var i = 42;
	var SomaPonderada = 0;
//	alert(typeof(SomaPonderada));
	chave43 = (chave.substring(0,43));
	multiplicadores = ["2","3","4","5","6","7","8","9"];
	chavedv = chave.substring(43,44);
	QtdMultiplicadores = multiplicadores.length;

	while(i>=0){
		for (m=0; m<QtdMultiplicadores && i>=0; m++) {
			//alert(chave43[2]);
			var fator1 = chave43[i];
			var fator2 = multiplicadores[m];
			var nfator1=parseInt(fator1);
			var nfator2=parseInt(fator2);
			var soma=nfator1*nfator2;
			//alert(soma);
			//var soma1=chave43.chartAt(i) * multiplicadores.chartAt(m);
			SomaPonderada+=soma;
		//	alert(typeof(SomaPonderada));
			i--;
		}

	} // while
	var resto = SomaPonderada % 11;
	if (resto == 0 || resto == 1) {
		var dv= 0;
	} else {
		var dv = 11-resto;
	}
	if (chavedv != dv ) {
		return false;
	//	alert("Chave incorreta");
	}else{
		return true;
		//alert("chave boa");
	}
console.log(dv);
console.log(chave43);

}

//essa função desmembra a chave entregando um array com cada seção da chave. para fim de preenchimento automatico
function Desmembra_chave(chave_suja){
	var chave = LimpaInputChave(chave_suja);
	//var chave = "43160390312133001087550010000687491017210992";
	var UF = chave.substr(0,2 ); //0
	var Ano = chave.substr(2,2 ); //1
	var Mes = chave.substr(4,2); //2
	var CNPJ = chave.substr(6,14 ); //3
	var Modelo_NF = chave.substr(20,2 ); //4
	var Serie_NF = chave.substr(22,3); //5
	var Num_NF = chave.substr(25,9 ); //6
	var Forma_emissao = chave.substr(34,1 ); //7
	var Codigo_NF = chave.substr(35,8 ); //8
	var DV = chave.substr(43,1 ); //9

	var ar_chave = new Array(UF,Ano,Mes,CNPJ,Modelo_NF,Serie_NF,Num_NF,Forma_emissao,Codigo_NF,DV);
	return ar_chave;
}

//
<!-- função perdeu razao de existir -->
function retorna_result_chave(chave_suja){
	Desmembra_chave(chave_suja);
	if (chave_suja == '' || chave_suja == '____ ____ ____ ____ ____ ____ ____ ____ ____ ____ ____' || chave_suja == '**** **** **** **** **** **** **** **** **** **** ****') {
		return Chave_NFe.placeholder='Digite aqui a chave da NFe';
		//alert (chave_suja);
	} else {
		if (ValidaChaveNFE(chave_suja) == true) {
			Num_NFe.value=Desmembra_chave(chave_suja)[6];
			Num_NFe.disabled=true;
		} else {
		alert("Chave Inválida");
		}
	}
}


<!--erros 4.x -->
function preenche_financeiro_by_chave(chave_suja){

	if (chave_suja == '' || chave_suja == '____ ____ ____ ____ ____ ____ ____ ____ ____ ____ ____') {

		return Chave_NFe.placeholder='Digite aqui a chave da NFe';

	} else{
		if (ValidaChaveNFE(chave_suja)== true) {

			Num_NFe.value=Desmembra_chave(chave_suja)[6];
			$('#Num_NFe').attr('readonly', true);
			$('#Num_NFe').prop('readonly', true);
			$("#Num_NFe").addClass("preenchido");
			//Num_NFe.disabled=true;
			Serie_NFe.value=Desmembra_chave(chave_suja)[5];
			$('#Serie_NFe').attr('readonly', true);
			$('#Serie_NFe').prop('readonly', true);
			$("#Serie_NFe").addClass("preenchido");
			//Serie_NFe.disabled=true;
			//cad_for.disabled=true;
			var cnpjok = Desmembra_chave(chave_suja)[3];
			$("#fornecedor").load("ajax/ajax_fornecedor.php?cnpj="+cnpjok); //essa função retorna o item preechido no select
			//$('#fornecedor').attr('readonly', true);
			//$('#fornecedor').prop('readonly', true);
			//$("#fornecedor").addClass("preenchido");
			//fornecedor.disabled=true;
			$("#unidade_fornecedor").load("ajax/ajax_unidade_fornecedor.php?cnpj="+cnpjok);
			//$('#unidade_fornecedor').attr('readonly', true);
			//$('#unidade_fornecedor').prop('readonly', true);
			//$("#unidade_fornecedor").addClass("preenchido");
			//unidade_fornecedor.disabled=true;
			$("#Valor_NFe").focus();
		}else{
	alert("Erro 4.2: Chave inválida");
		}}

}

function ajax_plus(){
	$("#fornecedor").load("ajax/ajax_plus.php?f=01");
}

function valida_data(campo,data){

	var dia = data.substr(0,2);
	var mes = data.substr(3,2 );
	var ano = 20+data.substr(6,2);

	if (dia < 01 || dia > 31 || mes < 01 || mes > 12) {
		//return false;
		alert('data inválida');
		campo.focus;
} else{
	if ((mes == 4 || mes == 6 || mes == 9 || mes == 11 ) && (dia == 31)) {
		//return false;
		alert('data inválida');
		campo.focus;
	}else{
	if (mes == 2 && (dia>29||(dia==29 && ano%4!=0))) {
		//return false;
		alert('data inválida');
		campo.focus;
		}else {
		if (ano < 1900) {
			//return false;
			alert('data inválida');
			campo.focus();
			} else{
			return true;
			}
		}
	}
}
}



function preenche_marca_e_forn(){

			$("#fornecedor").load("ajax/ajax_nome_forn.php"); //essa função retorna o item preechido no select

			$("#marca").load("ajax/ajax_marca.php");


}