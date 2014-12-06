		<ul class="menu">
		    <li class="menu--item"><a class="menu--link" href="/" title="<?= LOJA ?>"><?= LOJA ?></a></li>
		    <?php if (isset($_COOKIE['carrinho']) && $_COOKIE['carrinho']) { ?>
		    <li class="menu--item"><a class="menu--link" href="/carrinho.php" title="<?= LOJA ?>">Carrinho de compras</a></li>
		    <?php } ?>
		    <hr>
		    <?php
		        $categorias = $database->query("SELECT categorias.id, categorias.titulo FROM categorias ORDER BY titulo");
		        foreach ($categorias as $categoria) { ?>
		    <li class="menu--item<?php if (isset($categoria_id) && $categoria['id'] == $categoria_id) { echo ' menu--item--selecionado'; } ?>"><a class="menu--link" href="/categorias.php?cod=<?= $categoria['id'] ?>" title="<?= $categoria['titulo'] ?>"><?= $categoria['titulo'] ?></a></li>
		    <?php } ?>
		</ul>