
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
include('logoff.php'); ?>
	</head>

	<body>

<!-- Entrada do Topo da pagina -->
<?php
echo '<div class="alert alert-success" role="alert">Bem vindo ao ERP Sapatino '.$usuario. '</div>';
include('includes/topo.php'); ?>

<!-- Entrada do painel de notificações -->
<div class="panel panel-default">
  <div class="panel-heading">Notas financeiro</div>
  <div class="panel-body">
    Anotações por php
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Notas de caixas</h3>
  </div>
  <div class="panel-body">
    Anotações por php
  </div>
</div>

<!-- Finalização -->

	</body>
</html>