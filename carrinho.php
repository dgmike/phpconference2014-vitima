<?php

include 'funcoes.php';

define('LOJA', 'Loja Legado');

$database = new PDO('sqlite:database.sqlite3');

if (!isset($_COOKIE) || !isset($_COOKIE['carrinho'])) {
	$_COOKIE['carrinho'] = '';
}

$carrinho_cookies = explode(',', $_COOKIE['carrinho']);

$carrinho = array();
$produtos = array();

foreach ($carrinho_cookies as $produto) {

	if (preg_match('/^\d+$/', trim($produto)))
	{
		$produto = $database->query("SELECT produtos.id, produtos.titulo, produtos.preco, produtos.desconto, produtos.preco_final FROM produtos WHERE produtos.id = $produto")
							->fetch(PDO::FETCH_ASSOC);
		if ($produto) {
			$carrinho[] = $produto;
			$produtos[] = $produto['id'];
		}
	}
}

$codigo_promocional = filter_input(INPUT_POST, 'codigo_promocional');

if (!$codigo_promocional && $_COOKIE['codigo_promocional']) {
	$codigo_promocional = $_COOKIE['codigo_promocional'];
}

setcookie('codigo_promocional', $codigo_promocional);

$porcentagemPreco = precoComDesconto($carrinho, $codigo_promocional);

$porcentagem = $porcentagemPreco[0];
$total = $porcentagemPreco[1];
$desconto_codigo_promocional = $porcentagemPreco[2];

if (!$produtos) {
	header('Location: /');
}

setcookie('carrinho', implode(',', $produtos), time()+3600);

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Carrinho de Compras - <?= LOJA ?></title>
        <link rel="stylesheet" href="main.css">
    </head>

    <body>
    	<h1 class="header">
    	    <?= LOJA ?>
    	</h1>

		<div class="content">

		<?php include 'menu.inc.php' ?>

		<div class="carrinho">

			<h1>Carrinho de compras</h1>

			<table width="100%" cellspacing="0">
				<thead>
					<th colspan="2">Produto</th>
					<th>Valor</th>
					<th>Desconto</th>
					<th colspan="2">Valor Final</th>
				</thead>
				<tbody>
					<?php foreach ($carrinho as $produto) {
						?>
						<tr>
							<td width="10" align="center"><img src="/produtos/<?= $produto['id'] ?>.jpg" alt="<?= $produto['titulo'] ?>" /></td>
							<td><?= $produto['titulo'] ?></td>
							<td>R$ <?= $produto['preco'] ?></td>
							<td><?= $produto['desconto'] ?>%</td>
							<td>R$ <?= $produto['preco_final'] ?></td>
							<td width="10" align="center"><a href="/remover.php?cod=<?= $produto['id'] ?>" title="Remover este produto" class="remover">x</a></td>
						</tr>
					<?php } ?>
				</tbody>
				<tfoot>
					<?php if (!$desconto_codigo_promocional) { ?>
					<tr>
						<th colspan="3"><label for="codigo_promocional">Código Promocional</label></th>
						<th colspan="3">
							<form action="/carrinho.php" method="post">
								<input type="text" id="codigo_promocional" name="codigo_promocional" />
								<button type="submit">Calcular</button>
							</form>
						</th>
					</tr>
					<?php } else { ?>
					<tr>
						<th colspan="4">Desconto Código Promocional</th>
						<th colspan="2"><?= $desconto_codigo_promocional ?>%</th>
					</tr>
					<?php } ?>

					<?php if ($porcentagem) { ?>
					<tr>
						<th colspan="4">Desconto especial</th>
						<th colspan="2"><?= $porcentagem ?>%</th>
					</tr>
					<?php } ?>
					<tr>
						<th colspan="4">Total</th>
						<th colspan="2">R$ <?= $total ?></th>
					</tr>
				</tfoot>
			</table>

			<p style="text-align: right; margin: 15px 0">
				<a href="/finalizar.php" class="produto--adicionar">Finalizar</a>
			</p>

		</div>

		</div>

		<?php include 'rodape.inc.php' ?>

	</body>
</html>