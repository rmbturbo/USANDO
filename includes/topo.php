<?php
if (!isset($_SESSION)) session_start();

if (!isset($_SESSION['usuarioID'])) {
	// Destrói a sessão por segurança
	session_destroy();
	// Redireciona o visitante de volta pro login
	//echo 'sessao nao encontrada';
	header("Location: index.php"); exit;
}

include_once('logoff.php');
$acesso = $_SESSION['usuarioAcesso'];
$usuario = $_SESSION['usuarioERP'];



if ($acesso == '001') {

//	echo '<div class="alert alert-success" role="alert">Bem vindo ao ERP Sapatino '.$usuario. '</div>';
	?>

<!--Inicio da barra padrão -->
	<nav class="navbar navbar-default">
	<div class="container span7 text-center col-md-10 col-md-offset-3" style="margin: 0 auto;float: none;">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Sapatino</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Cameras <span class="sr-only">(current)</span></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Configurações <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Cadastro Unidades</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Cadastro parametros</a></li>
            <li><a href="#">Cadastro tributos</a></li>
          </ul>
        </li>
        <li><a href="#">Enviar NFe</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Caixa <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Fechamento Hoje<?php //echo $data = date("d/m/Y");  ?></a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Ajustes Ontem</a></li>
            <li><a href="#">Ajuste de caixa</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Relatório por periodo</a></li>
            <li><a href="#">Relatório mês anterior</a></li>
            <li><a href="#">Relatório 7 dias </a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Produtos <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="cad_marcas.php">Cadastrar Marca</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Cadastrar novo produto</a></li>
            <li><a href="#">Cadastrar novo produto</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Cadastro de Marcas</a></li>
            <li><a href="#">Cadastro de Produtos</a></li>
            <li role="separator" class="divider"></li>
            <li><a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Parâmetros <span class="caret"></span></a>
            	 <ul class="dropdown-submenu">
            	 	<li><a href="#">Preços de venda</a></li>
            	 	<li><a href="#">Utiquetas</a></li>
            	 </ul>
            </li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Financeiro <span class="caret"></span></a>
          <ul class="dropdown-menu" >
            <li><a href="insere_contas_fornecedores.php">Cadastrar Despesa</a></li>
              <li role="separator" class="divider"></li>
            <li><a href="duplicatas_a_pagar.php">Contas a pagar</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Fluxo de caixa</a></li>
            <li><a href="#">Relatório de contas</a></li>
            <li><a href="#">Relatório de custos</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Relatório de vendas</a></li>
            <li><a href="#">Relatório de estoque</a></li>

          </ul>
        </li>
               <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Fornecedores<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="insere_nome_fornecedor.php">Cadastrar nome de fornecedor</a></li>
            <li><a href="insere_fornecedor.php">Cadastrar unidade de fornecedor</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="cad_representante.php">Cadastrar Representante</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Alterar Cadastro de Fornecedores</a></li>
          </ul>
        </li>

      </ul>
      <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Buscar">
        </div>
        <button type="submit" class="btn btn-default">Buscar</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Link</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $usuario; ?><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Cadastro</a></li>
            <li><a href="#">Alterar senha</a></li>
            <li role="separator" class="divider"></li>
            <li role="separator" class="divider"></li>
            <li><a href="?sair">Sair</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
  </div>
</nav>
<!--Fim da barra padrão -->

	<?php
} elseif($acesso == '002'){

	?>

		<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Sapatino</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Cameras <span class="sr-only">(current)</span></a></li>
        <li><a href="#">Enviar NFe</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Caixa <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Fechamento Hoje<?php //echo $data = date("d/m/Y");  ?></a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Ajustes Ontem</a></li>
            <li><a href="#">Ajuste de caixa</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Relatório por periodo</a></li>
            <li><a href="#">Relatório mês anterior</a></li>
            <li><a href="#">Relatório 7 dias </a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Financeiro <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#"><font color="#E1E1E1">Inserir Contas fornecedor</font></a></li>
            <li><a href="#"><font color="#E1E1E1">Inserir Contas fixas</font></a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#"><font color="#E1E1E1">Controle de contas</font></a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#"><font color="#E1E1E1">Fluxo de caixa</font></a></li>
            <li><a href="#"><font color="#E1E1E1">Relatório de contas</font></a></li>
            <li><a href="#"><font color="#E1E1E1">Relatório de custos</font></a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Relatório de vendas</a></li>
            <li><a href="#">Relatório de estoque</a></li>

          </ul>
        </li>
               <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Fornecedor <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#"><font color="#E1E1E1">Inserir fornecedor</font></a></li>
            <li><a href="#"><font color="#E1E1E1">Inserir unidade de fornecedor</font></a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Cadastro de Fornecedores</a></li>
          </ul>
        </li>

      </ul>
      <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Buscar">
        </div>
        <button type="submit" class="btn btn-default">Buscar</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Link</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $usuario; ?><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Cadastro</a></li>
            <li><a href="#">Alterar senha</a></li>
            <li role="separator" class="divider"></li>
            <li role="separator" class="divider"></li>
            <li><a href="?sair">Sair</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


	<?php


	echo 'grau de acesso 002 gerente';

}elseif($acesso == '003'){

	echo 'grau de acesso 003 caixa';

}else{

	echo 'acesso negado'.$acesso;
}
?>