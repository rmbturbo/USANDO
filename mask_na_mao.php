<script type="text/javascript"> // Mascaras Javascript

function mascara(o,f){
	v_obj=o
	v_fun=f
	setTimeout("execmascara()",1)
}
function execmascara(){
	v_obj.value=v_fun(v_obj.value)
}

function id( el ){
	return document.getElementById( el );
}

// aqui começa as mascaras

function mtel(v){ //MASCARA PARA TELEFONE

	v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
	v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
	v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
	return v;
}


function mcpf(v){  //MASCARA PARA CPF

	v=v.replace(/\D/g,"")                    //Remove tudo o que não é dígito
	v=v.replace(/(\d{3})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto dígitos
	v=v.replace(/(\d{3})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto dígitos
	//de novo (para o segundo bloco de números)
	v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2") //Coloca um hífen entre o terceiro e o quarto dígitos
	return v;
}

function mcnpj(v){  //MASCARA PARA CNPJ

	v=v.replace(/\D/g,"")                    //Remove tudo o que não é dígito

	v=v.replace(/(\d{2})(\d)/,"$1.$2")
	v=v.replace(/(\d{3})(\d)/,"$1.$2")
	v=v.replace(/(\d{3})(\d)/,"$1/$2")
	v=v.replace(/(\d)(\d{2})$/,"$1-$2");    //Coloca o . antes dos últimos 3 dígitos, e antes do verificador
	return v;
}

function mie(v){  //MASCARA PARA CNPJ

	v=v.replace(/\D/g,"")                    //Remove tudo o que não é dígito
	v=v.replace(/(\d{3})(\d)/,"$1.$2")
	v=v.replace(/(\d{3})(\d)/,"$1.$2")
	v=v.replace(/(\d{3})(\d)/,"$1.$2")
	return v;
}


function mrg(v){  //MASCARA PARA RG

	//  v=v.replace( /\s/g, '' );                  //Remove tudo o que não é dígito
	//	v=v.replace(/(\d)(\d{7})$/,"$1.$2");   	 //Coloca o . antes dos últimos 3 dígitos, e antes do verificador
	//  v=v.replace(/(\d)(\d{4})$/,"$1.$2");    //Coloca o . antes dos últimos 3 dígitos, e antes do verificador
	//  v=v.replace(/(\d)(\d)$/,"$1-$2");       //Coloca o - antes do último dígito

	v=v.replace(/(\d{2})(\d)/,"$1.$2")       //Coloca um ponto entre o segundo e o terceiro dígitos
	v=v.replace(/(\d{3})(\d)/,"$1.$2")
	v=v.replace(/(\d{5})(\d)/,"$1.$2")
	v=v.replace(/(\d{9})(\d)/,"$1-$2")
	return v;
}

function mcep(v){  //MASCARA PARA CEP

	v=v.replace(/\D/g,"")                      //Remove tudo o que não é dígito
	v=v.replace(/^(\d{5})(\d)/,"$1-$2")         //Esse é tão fácil que não merece explicações
	return v;
}

function mcartao(v){ //MASCARA PARA CARTAO

	v=v.replace(/\D/g,"")                    //Remove tudo o que não é dígito
	v=v.replace(/(\d{4})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto dígitos
	v=v.replace(/(\d{4})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto dígitos
	v=v.replace(/(\d{4})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto dígitos
	v=v.replace(/(\d{4})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto dígitos
	return v;
}

function mdata(v){ // MASCARA PARA DATA

	v=v.replace(/\D/g,"");                    //Remove tudo o que não é dígito
	v=v.replace(/(\d{2})(\d)/,"$1/$2");
	v=v.replace(/(\d{2})(\d)/,"$1/$2");
	return v;
}

function mvalor(v){  //MASCARA PARA VALOR EM $$

	v=v.replace(/\D/g,"");//Remove tudo o que não é dígito
	v=v.replace(/(\d)(\d{8})$/,"$1.$2");//coloca o ponto dos milhões
	v=v.replace(/(\d)(\d{5})$/,"$1.$2");//coloca o ponto dos milhares

	v=v.replace(/(\d)(\d{2})$/,"$1,$2");//coloca a virgula antes dos 2 últimos dígitos
	return v;
}

function mvalor(v){  //MASCARA PARA VALOR EM $$

	v=v.replace(/\D/g,"");//Remove tudo o que não é dígito
	v=v.replace(/(\d)(\d{8})$/,"$1.$2");//coloca o ponto dos milhões
	v=v.replace(/(\d)(\d{5})$/,"$1.$2");//coloca o ponto dos milhares

	v=v.replace(/(\d)(\d{2})$/,"$1,$2");//coloca a virgula antes dos 2 últimos dígitos
	return v;
}

function memail(v){

	v=v.replace( /\s/g, '' );
	return v;
}

window.onload = function(){ // FUNCAO QUE É ACIONADO AO CARREGAR A PAGINA ( WINDOW.ONLOAD )

	id('txtCel').onkeyup = function(){ //ATRIBUI O CAMPO COM ID txtCel A MASCARA DE TELEFONE
		mascara( this, mtel );
	}

	id('txtFixo').onkeyup = function(){ //ATRIBUI O CAMPO COM ID txtFixo A MASCARA DE TELEFONE
		mascara( this, mtel );
	}

	id('txtComercial').onkeyup = function(){ //ATRIBUI O CAMPO COM ID txtComercial A MASCARA DE TELEFONE
		mascara( this, mtel );
	}
}
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-md-3">Celular</label>
								<div class="col-md-4">
									<input type="tel" class="form-control" id="txtCel" name="txtCel" value="<?php echo $_POST['txtCel'];?>" maxlength="15" >
								</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-md-3">Telefone fixo</label>
								<div class="col-md-4">
									<input type="text" id="txtFixo" name="txtFixo" class="form-control" value="<?php echo $_POST['txtFixo'];?>" maxlength="15" >
								</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-md-3">Telefone Comercial</label>
								<div class="col-md-4">
									<input type="tel" class="form-control" id="txtComercial" name="txtComercial" value="<?php echo $_POST['txtComercial'];?>" maxlength="15">
								</div>
						</div>
					</div>
				</div><!--::: ROW :: -->