<?php
define('LOJA', 'Loja Legado');

$database = new PDO('sqlite:database.sqlite3');

$produto_id = intVal($_GET['cod']);

$produto = $database->query("SELECT produtos.id as id, categorias.id as categoria_id, categorias.titulo as categoria, produtos.titulo, produtos.descricao, produtos.preco, produtos.desconto, produtos.preco_final
	FROM produtos
	JOIN categorias_produtos ON categorias_produtos.id_produto = produtos.id
	JOIN categorias ON categorias_produtos.id_categoria = categorias.id
 	WHERE produtos.id = $produto_id")->fetch();

if (!$produto) {
	header('Not Found', true, 404);
	echo 'Página não encontrada';
	exit;
}

$produto['desconto'] = intVal($produto['desconto']);
$categoria_id = $produto['categoria_id'];

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $produto['titulo'] ?><?= LOJA ?></title>
        <link rel="stylesheet" href="main.css">
    </head>

    <body>
    	<h1 class="header">
    	    <?= LOJA ?>
    	</h1>

		<div class="content">

		<?php include 'menu.inc.php' ?>

        <div class="produto produto--detalhes">
        	<ul class="breadcrumb">
        		<li class="breadcrumb--item"><a href="/categorias.php?cod=<?= $produto['categoria_id'] ?>"><?= $produto['categoria'] ?></a></li>
        		<li class="breadcrumb--item"><?= $produto['titulo'] ?></li>
        	</ul>

        	<h2 class="produto--titulo"><?= $produto['titulo'] ?></h2>

			<div class="produto--imagem">
	        	<img src="/produtos/<?= $produto['id'] ?>.jpg" alt="<?= $produto['categoria'] ?>: <?= $produto['titulo'] ?>" />
        	</div>

        	<div class="produto--descricao">
        		<p><?= $produto['descricao'] ?></p>
        	</div>

    		<div class="preco">
                <span class="produto--preco<?php if ($produto['desconto']) { echo ' produto--preco--com-desconto'; } ?>">R$ <?= $produto['preco'] ?></span>
                <?php if ($produto['desconto']) { ?>
                <span class="produto--desconto">com <?= $produto['desconto'] ?>% de desconto</span>
                <span class="produto--preco-final">R$ <?= $produto['preco_final'] ?></span>
                <?php } ?>        			
    		</div>

    		<div class="produto--acao">
    			<a href="/adicionar.php?cod=<?= $produto['id'] ?>" class="produto--adicionar">Adicionar ao carrinho</a>
    		</div>
        </div>

        <div class="comentarios">
        	
        	<div id="disqus_thread"></div>
    	    <script type="text/javascript">
    	        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
    	        var disqus_shortname = 'dgmike'; // required: replace example with your forum shortname
    	        var disqus_identifier = '/php-conference/2014/codigo-legado/loja-exemplo';
    	        var disqus_title = 'PHPConference 2014 - Código Legado - Loja Exemplo';
    	        var disqus_url = 'http://dgmike.com.br/php-conference/2014/codigo-legado/loja-exemplo';

    	        /* * * DON'T EDIT BELOW THIS LINE * * */
    	        (function() {
    	            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
    	            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
    	            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    	        })();
    	    </script>
    	    

        </div>

		</div>

        <?php include 'rodape.inc.php' ?>

    </body>
</html>