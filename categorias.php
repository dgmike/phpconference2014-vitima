<?php
define('LOJA', 'Loja Legado');

$database = new PDO('sqlite:database.sqlite3');

$categoria_id = intVal($_GET['cod']);

$categoria = $main_categoria = $database->query("SELECT categorias.titulo FROM categorias WHERE id = $categoria_id")->fetch();

if (!$categoria) {
	header('Not Found', true, 404);
	echo 'Página não encontrada';
	exit;
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $categoria['titulo'] ?> - <?= LOJA ?></title>
        <link rel="stylesheet" href="main.css">
    </head>

    <body>
    	<h1 class="header">
    	    <?= LOJA ?>
    	</h1>

		<div class="content">

			<?php include 'menu.inc.php' ?>

			<div class="main">
				<h1><?= $main_categoria['titulo'] ?></h1>
			</div>

	        <ul class="produtos">
		        
		<?php
		$produtos = $database->query("SELECT DISTINCT
		    produtos.id, categorias.titulo as categoria, produtos.titulo, produtos.preco, 
		    produtos.desconto, produtos.preco_final
		    FROM produtos
		    LEFT JOIN categorias_produtos ON produtos.id = categorias_produtos.id_produto
		    LEFT JOIN categorias ON categorias_produtos.id_categoria = categorias.id
		    WHERE categorias.id = $categoria_id");

		foreach ($produtos as $produto)
		{
		    $produto['desconto'] = intVal($produto['desconto']);
		?>
		            <li class="produto">
		                <a href="/produtos.php?cod=<?= $produto['id'] ?>">
		                    <img class="produto--imagem" src="produtos/<?= $produto['id'] ?>.jpg" alt="<?= $produto['categoria'] ?>: <?= $produto['titulo'] ?>" />
		                    <span class="produto--categoria"><?= $produto['categoria'] ?></span>
		                    <span class="produto--titulo"><?= $produto['titulo'] ?></span>
		                    <span class="produto--preco<?php if ($produto['desconto']) { echo ' produto--preco--com-desconto'; } ?>">R$ <?= $produto['preco'] ?></span>
		                    <?php if ($produto['desconto']) { ?>
		                    <span class="produto--desconto">com <?= $produto['desconto'] ?>% de desconto</span>
		                    <span class="produto--preco-final">R$ <?= $produto['preco_final'] ?></span>
		                    <?php } ?>
		<?php
		}
		?>
		                </a>
		            </li>
		        </ul>

		</div>

		<?php include 'rodape.inc.php' ?>

    </body>
</html>