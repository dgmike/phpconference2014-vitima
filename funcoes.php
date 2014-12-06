<?php

function dinheiro($valor)
{
    return 'R$ ' . number_format($valor, 2, ',', '');
}

function precoComDesconto($produtos, $codigo_promocional = false)
{
    $total = 0;

    foreach( $produtos as $produto )
        {
            $total += $produto['preco_final'];
    }

    $porcentagem = 0;

    if (count($produtos) == 2) {
        $porcentagem = 5;
        $total = $total - ($total * 5/100);
    } elseif (count($produtos) == 3) {
        $porcentagem = 7;
        $total -= $total * 7/100;
    } elseif (count($produtos) == 4) {
        $porcentagem = 12;
        $total -= $total * 12/100;
    } elseif (count($produtos) > 4) {
        $porcentagem = 14;
        $total -= $total * 14/100;
    }

    $desconto_codigo_promocional = 0;

    if ($codigo_promocional)
    {
        $database = new PDO('sqlite:database.sqlite3');

        $desconto_codigo_promocional = (float) $database->query("SELECT desconto
                FROM codigos_promocionais
                WHERE codigo = '$codigo_promocional' AND usado = 0")->fetchColumn();

        if ($desconto_codigo_promocional) {
            $total = $total * $desconto_codigo_promocional/100;
        }
    }

    return array($porcentagem, $total, $desconto_codigo_promocional);
}


function finaliza ($produtos, $total, $codigo_promocional ) {

    $produtos = serialize($produtos);

    $email = filter_input(INPUT_POST, 'email');
    $nome = filter_input(INPUT_POST, 'nome');
    $endereco = filter_input(INPUT_POST, 'endereco');
    $tipo_pagamento = filter_input(INPUT_POST, 'tipo_pagamento');

    $criado_em = $criado_em = strftime('%Y-%M-%d %T');

        $database = new PDO('sqlite:database.sqlite3');

    if ($codigo_promocional) {
        $database->exec("UPDATE codigos_promocionais SET usado = 1
              WHERE codigo = '$codigo_promocional'");
    }

    $database->exec("INSERT INTO carrinho (produtos, email, nome, endereco, tipo_pagamento, total, criado_em)
        VALUES ('$produtos', '$email', '$nome', '$endereco', '$tipo_pagamento', '$total', '$criado_em')");
}
?>