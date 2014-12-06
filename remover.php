<?php

define('LOJA', 'Loja Legado');

$database = new PDO('sqlite:database.sqlite3');

$produto_id = intVal($_GET['cod']);

if (!$_COOKIE['carrinho']) {
	$_COOKIE['carrinho'] = '';
}

$produtos = trim($_COOKIE['carrinho'], ',');
$produtos = explode(',', $produtos);
$produtos = array_unique($produtos);

$_produtos = array();

foreach($produtos as $produto) {
	if (intVal($produto) != $produto_id) {
		$_produtos[] = $produto;
	}
}

$produtos = implode(',', $_produtos);

setcookie('carrinho', $produtos, time()+3600);

header('Location: /carrinho.php');

?>