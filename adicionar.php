<?php

define('LOJA', 'Loja Legado');

$database = new PDO('sqlite:database.sqlite3');

$produto_id = intVal($_GET['cod']);

$produto = $database->query("SELECT produtos.id FROM produtos WHERE produtos.id = $produto_id")->fetch();

if (!$produto) {
	header('Not Found', true, 404);
	echo 'Página não encontrada';
	exit;
}

if (!isset($_COOKIE['carrinho'])) {
	$_COOKIE['carrinho'] = '';
}

$produtos = trim($_COOKIE['carrinho'] . ',' . $produto_id, ',');
$produtos = explode(',', $produtos);
$produtos = array_unique($produtos);
$produtos = implode(',', $produtos);

setcookie('carrinho', $produtos, time()+3600);

header('Location: /carrinho.php');

?>