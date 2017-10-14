<?php

require('conectadb2.php');

$apelido = $_POST['apelido'];
$nome = $_POST['nome'];
$tel1 = $_POST['tel1'];
$tel2 = $_POST['tel2'];
$tel3 = $_POST['tel3'];
$tel4 = $_POST['tel4'];
$email = $_POST['email'];
$site = $_POST['site'];
$obs = $_POST['obs'];

$fornecedores = $_POST['fornecedor'];
$num_forn = count($fornecedores);


$marcas = $_POST['marca'];
$num_marcas = count($marcas);



echo $apelido;
echo '<br>';
echo $nome;
echo '<br>';
print_r($fornecedores);
echo '<br>';
echo $num_forn;
echo '<br>';
print_r($marcas);
echo '<br>';
echo $num_marcas;