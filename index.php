<?php

define('LOJA', 'Loja Legado');

$database = new PDO('sqlite:database.sqlite3');

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= LOJA ?></title>
        <link rel="stylesheet" href="main.css">
    </head>

    <body>
        <h1 class="header">
            <?= LOJA ?>
        </h1>

        <div class="content">

        <?php include 'menu.inc.php' ?>


        <div class="main">
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- loja -->
            <ins class="adsbygoogle"
                 style="display:inline-block;width:728px;height:90px"
                 data-ad-client="ca-pub-2798607881084626"
                 data-ad-slot="4922914001"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>

        <ul class="produtos">
<?php
$produtos = $database->query("SELECT valor FROM configuracoes WHERE chave = 'produtos_home'")->fetch();
$produtos = explode(',', $produtos['valor']);
$produtos_ids = '(' . implode(', ', $produtos) . ')';
$produtos_order = 'CASE';
foreach ($produtos as $order_id => $produto_id) {
    $produtos_order .= ' WHEN produtos.id = ' . $produto_id . ' THEN ' . $order_id;
}
$produtos_order .= ' END';

$produtos = $database->query("SELECT DISTINCT
    produtos.id, categorias.titulo as categoria, produtos.titulo, produtos.preco,
    produtos.desconto, produtos.preco_final
    FROM produtos
    LEFT JOIN categorias_produtos ON produtos.id = categorias_produtos.id_produto
    LEFT JOIN categorias ON categorias_produtos.id_categoria = categorias.id
    WHERE produtos.id IN $produtos_ids
    ORDER BY $produtos_order
    LIMIT 9");

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
<?php } ?>
                </a>
            </li>
        </ul>

        </div>

        <?php include 'rodape.inc.php' ?>

    </body>
</html>
