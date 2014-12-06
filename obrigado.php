<?php
define('LOJA', 'Loja Legado');
$database = new PDO('sqlite:database.sqlite3');
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

			<div class="main">

				<h1>Obrigado ;-)</h1>

				<p>Em breve sua compra chegará a sua casa.</p>

				<br />
				<br />
				<br />
				<br />
				<br />
				<br />

			</div>

		</div>

        <?php include 'rodape.inc.php' ?>

	</body>
</html>