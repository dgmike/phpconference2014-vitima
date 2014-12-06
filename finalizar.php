<?php

include 'funcoes.php';

define('LOJA', 'Loja Legado');

$database = new PDO('sqlite:database.sqlite3');

if (!$_COOKIE['carrinho']) {
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

$porcentagemPreco = precoComDesconto($carrinho);
$porcentagem = $porcentagemPreco[0];
$total = $porcentagemPreco[1];

$codigo_promocional = false;
if ($_COOKIE['codigo_promocional']) {
	$codigo_promocional = $_COOKIE['codigo_promocional'];
}

if (!$produtos) {
	header('Location: /');
}

setcookie('carrinho', implode(',', $produtos), time()+3600);

if (isset($_POST['finalizar'])) {
	finaliza($carrinho, $total, $codigo_promocional);
	setcookie('carrinho', null);
	header('Location: /obrigado.php');

}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Finalizar Compra - <?= LOJA ?></title>
        <link rel="stylesheet" href="main.css">
    </head>

    <body>
    	<h1 class="header">
    	    <?= LOJA ?>
    	</h1>

		<div class="content">

			<?php include 'menu.inc.php' ?>

		<div class="carrinho">

			<h1>Finalizar compra</h1>

			<form action="/finalizar.php" method="post" class="form">
				<label>Nome <input type="text" name="nome" /></label>
				<label>E-mail <input type="email" name="email" /></label>
				<label>Endereço <textarea name="endereco"></textarea></label>
				<label>Total <input type="email" value="R$ <?= $total ?>" name="" readonly="true" /></label>

				<fieldset>
					<legend>Forma de pagamento</legend>
					<label class="pagamento--forma pagamento--boleto">
						<span class="bandeira"></span>
						<input type="radio" name="tipo_pagamento" value="boleto" />
						Boleto
					</label>
					<label class="pagamento--forma pagamento--mastercard">
						<span class="bandeira"></span>
						<input type="radio" name="tipo_pagamento" value="mastercard" />
						MasterCard
					</label>
					<label class="pagamento--forma pagamento--diners">
						<span class="bandeira"></span>
						<input type="radio" name="tipo_pagamento" value="diners" />
						Diners
					</label>
					<label class="pagamento--forma pagamento--americanexpress">
						<span class="bandeira"></span>
						<input type="radio" name="tipo_pagamento" value="americanexpress" />
						American Express
					</label>
					<br />
					<label class="pagamento--forma pagamento--elo">
						<span class="bandeira"></span>
						<input type="radio" name="tipo_pagamento" value="elo" />
						Elo
					</label>
					<label class="pagamento--forma pagamento--visa">
						<span class="bandeira"></span>
						<input type="radio" name="tipo_pagamento" value="visa" />
						Visa
					</label>
					<label class="pagamento--forma pagamento--itau">
						<span class="bandeira"></span>
						<input type="radio" name="tipo_pagamento" value="debitoitau" />
						Débito Itaú
					</label>
					<label class="pagamento--forma pagamento--bradesco">
						<span class="bandeira"></span>
						<input type="radio" name="tipo_pagamento" value="debitobradesco" />
						Débito Bradesco
					</label>
				</fieldset>


				<button type="submit" name="finalizar" value="finalizar" class="produto--adicionar">Finalizar</a>
			</form>

		</div>

		</div>

        <?php include 'rodape.inc.php' ?>

	</body>
</html>