<?php

$database = new PDO('sqlite:database.sqlite3');

$database->exec("CREATE TABLE IF NOT EXISTS produtos (
                 id INTEGER PRIMARY KEY,
                 titulo TEXT,
                 descricao TEXT,
                 preco REAL,
                 desconto REAL,
                 preco_final REAL,
                 criado_em INTEGER)");

$database->exec("CREATE TABLE IF NOT EXISTS categorias (
                 id INTEGER PRIMARY KEY,
                 titulo TEXT,
                 criado_em INTEGER)");

$database->exec("CREATE TABLE IF NOT EXISTS categorias_produtos (
                 id_produto INTEGER,
                 id_categoria INTEGER)");

$database->exec("CREATE TABLE IF NOT EXISTS carrinho (
                 id INTEGER PRIMARY KEY,
                 produtos TEXT,
                 email TEXT,
                 nome TEXT,
                 endereco TEXT,
                 tipo_pagamento TEXT,
                 total REAL,
                 criado_em INTEGER)");

$database->exec("CREATE TABLE IF NOT EXISTS codigos_promocionais (
                 codigo TEXT PRIMARY KEY,
                 desconto REAL,
                 usado BOOLEAN)");

$database->exec("CREATE TABLE IF NOT EXISTS configuracoes (
                 chave TEXT PRIMARY KEY,
                 valor TEXT)");

$database->exec("CREATE TABLE IF NOT EXISTS versao (
                 versao INTEGER DEFAULT 0)");

$versao = $database->query("SELECT MAX(versao) as versao FROM versao");
$versao = $versao->fetch();
$versao = (int) $versao['versao'];

// var_dump($versao);

if ($versao < 1) { // install

    $criado_em = strtotime('2014-06-03 15:48:07');
    // var_dump($criado_em);

    // produtos
    $database->exec("INSERT INTO produtos (id, titulo, descricao, preco, desconto, preco_final, criado_em)
                     VALUES (1, 'saia curta azul', 'Uma bela saia para você é uma mulher que gosta de inovar', 81.9, 5, 77.805, '$criado_em')");

    $database->exec("INSERT INTO produtos (id, titulo, descricao, preco, desconto, preco_final, criado_em)
                     VALUES (2, 'saia media vermelha', 'Uma bela saia para você é uma mulher que gosta de inovar', 78.3, 3, 75.951, '$criado_em')");

    $database->exec("INSERT INTO produtos (id, titulo, descricao, preco, desconto, preco_final, criado_em)
                     VALUES (3, 'saia longa floral', 'Uma bela saia para você é uma mulher que gosta de inovar', 124.99, 8.3, 114.61583, '$criado_em')");

    $database->exec("INSERT INTO produtos (id, titulo, descricao, preco, desconto, preco_final, criado_em)
                     VALUES (4, 'vestido floral', 'Um belo vestido para você que gosta de moda feminina de forma mais feliz', 144.9, 8, 133.308, '$criado_em')");

    $database->exec("INSERT INTO produtos (id, titulo, descricao, preco, desconto, preco_final, criado_em)
                     VALUES (5, 'vestido curto azul', 'Um belo vestido para você que gosta de moda feminina de forma mais feliz', 87.3, 3, 84.681, '$criado_em')");

    $database->exec("INSERT INTO produtos (id, titulo, descricao, preco, desconto, preco_final, criado_em)
                     VALUES (6, 'vestido curto vermelho', 'Um belo vestido para você que gosta de moda feminina de forma mais feliz', 87.3, 3, 84.681, '$criado_em')");

    $database->exec("INSERT INTO produtos (id, titulo, descricao, preco, desconto, preco_final, criado_em)
                     VALUES (7, 'vestido amarelo verão', 'Um belo vestido para você que gosta de moda feminina de forma mais feliz', 82.9, 3, 80.413, '$criado_em')");

    $database->exec("INSERT INTO produtos (id, titulo, descricao, preco, desconto, preco_final, criado_em)
                     VALUES (8, 'vestido verão malha', 'Um belo vestido para você que gosta de moda feminina de forma mais feliz', 89.9, 0, 89.9, '$criado_em')");

    $database->exec("INSERT INTO produtos (id, titulo, descricao, preco, desconto, preco_final, criado_em)
                     VALUES (9, 'vestido verão algodão', 'Um belo vestido para você que gosta de moda feminina de forma mais feliz', 76.34, 0, 76.34, '$criado_em')");

    // categorias
    $database->exec("INSERT INTO categorias (id, titulo, criado_em) VALUES (1, 'saias', '$criado_em')");
    $database->exec("INSERT INTO categorias (id, titulo, criado_em) VALUES (2, 'vestidos', '$criado_em')");

    // relacionamentos
    $database->exec("INSERT INTO categorias_produtos (id_categoria, id_produto) VALUES (1, 1)");
    $database->exec("INSERT INTO categorias_produtos (id_categoria, id_produto) VALUES (1, 2)");
    $database->exec("INSERT INTO categorias_produtos (id_categoria, id_produto) VALUES (1, 3)");
    $database->exec("INSERT INTO categorias_produtos (id_categoria, id_produto) VALUES (2, 4)");
    $database->exec("INSERT INTO categorias_produtos (id_categoria, id_produto) VALUES (2, 5)");
    $database->exec("INSERT INTO categorias_produtos (id_categoria, id_produto) VALUES (2, 6)");
    $database->exec("INSERT INTO categorias_produtos (id_categoria, id_produto) VALUES (2, 7)");
    $database->exec("INSERT INTO categorias_produtos (id_categoria, id_produto) VALUES (2, 8)");
    $database->exec("INSERT INTO categorias_produtos (id_categoria, id_produto) VALUES (2, 9)");

    // versionamento
    $database->exec("INSERT INTO versao (versao) VALUES (1)");
}
if ($versao < 2) {
    $criado_em = strtotime('2014-08-12 15:48:07');

    // categoria
    $database->exec("INSERT INTO categorias (id, titulo, criado_em) VALUES (3, 'casacos', '$criado_em')");

    // produtos
    $database->exec("INSERT INTO produtos (id, titulo, descricao, preco, desconto, preco_final, criado_em)
                     VALUES (10, 'casaquinho preto manga longa', 'Este casaquinho de manga longa, em helanca light, vai deixá-la charmosa em qualquer ocasião. Super moderno e elegante, o casaquinho é essencial para mulheres práticas e de bom gosto! Dependendo da produção, ele pode compor looks casuais para o dia e mais clássicos para a noite. Você vai arrasar com esse casaquinho, além de adorar sua praticidade!', 24.99, 0, 24.99, '$criado_em')");

    $database->exec("INSERT INTO produtos (id, titulo, descricao, preco, desconto, preco_final, criado_em)
                     VALUES (11, 'Sobretudo Preto Plus Size', 'Sobretudo Preto Plus Size, confeccionada em moletinho de poliéster. Modelo de manga longa, traspassado, recorte na cintura e fechamento em botões. Casaco feito sob medida, pensando em você.', 54.99, 14, 51.5914, '$criado_em')");

    $database->exec("INSERT INTO produtos (id, titulo, descricao, preco, desconto, preco_final, criado_em)
                     VALUES (12, 'Sobretudo em Sarja Preto', 'Sobretudo em Sarja Plus Size Quintess, confeccionado em sarja. Modelo de manga longa, com gola e punho. Fechamento em botões, com recortes, bolsos funcionais e detalhe de pregas frontais e trazeiras. Perfeito para essa estação! O casaco sobretudo é a solução mais elegante para os dias de frio.', 139.99, 25, 104.9925, '$criado_em')");

    $database->exec("INSERT INTO produtos (id, titulo, descricao, preco, desconto, preco_final, criado_em)
                     VALUES (13, 'Casaquinho Bordô', 'Casaquinho Bordô Plus Size, confeccionada em malha de poliéster. Modelo de manga longa, comprimento frontal levemente alongado. Peça muito linda, na hora que bater aquele friozinho.', 39.99, 0, 39.99, '$criado_em')");

    $database->exec("INSERT INTO produtos (id, titulo, descricao, preco, desconto, preco_final, criado_em)
                     VALUES (14, 'Sobretudo Preto Plus Size', 'Este casaquinho de manga longa, em helanca light, vai deixá-la charmosa em qualquer ocasião. Super moderno e elegante, o casaquinho é essencial para mulheres práticas e de bom gosto! Dependendo da produção, ele pode compor looks casuais para o dia e mais clássicos para a noite. Você vai arrasar com esse casaquinho, além de adorar sua praticidade!', 24.99, 0, 24.99, '$criado_em')");

    $database->exec("INSERT INTO produtos (id, titulo, descricao, preco, desconto, preco_final, criado_em)
                     VALUES (15, 'Jaqueta com Recortes que Imitam Couro Preto', 'Jaqueta com recortes que imitam couro, desenvolvida em cotton. Modelo com fechamento frontal de zíper. Ideal para compor looks contemporêneos e estilosos! Combine com vestido, macacão, calça jeans e regata. Essa jaqueta vai dar um up no seu visual!', 89.99, 27, 65.6927, '$criado_em')");

    $database->exec("INSERT INTO produtos (id, titulo, descricao, preco, desconto, preco_final, criado_em)
                     VALUES (16, 'Casaco Azul com Botões e Cinto', 'Casaco feminino confeccionado em moletinho. Modelo com abertura frontal de botões e cinto no mesmo tecido. Para os dias frios de inverno nada melhor do que um casaco quente e confortável. Os casacos mais grossos dão sempre um ar mais elegante ao look básico do dia a dia! Use com uma calça jeans e nos pés, botas ou sapatilhas.', 49.99, 0, 49.99, '$criado_em')");

    // relacionamentos
    $database->exec("INSERT INTO categorias_produtos (id_categoria, id_produto) VALUES (3, 10)");
    $database->exec("INSERT INTO categorias_produtos (id_categoria, id_produto) VALUES (3, 11)");
    $database->exec("INSERT INTO categorias_produtos (id_categoria, id_produto) VALUES (3, 12)");
    $database->exec("INSERT INTO categorias_produtos (id_categoria, id_produto) VALUES (3, 13)");
    $database->exec("INSERT INTO categorias_produtos (id_categoria, id_produto) VALUES (3, 14)");
    $database->exec("INSERT INTO categorias_produtos (id_categoria, id_produto) VALUES (3, 15)");
    $database->exec("INSERT INTO categorias_produtos (id_categoria, id_produto) VALUES (3, 16)");

    // versionamento
    $database->exec("INSERT INTO versao (versao) VALUES (2)");
}
if ($versao < 3) {
    $database->exec("INSERT INTO configuracoes (chave, valor) VALUES ('produtos_home', '16, 12, 11, 4, 15, 6, 10, 7, 2')");

    // versionamento
    $database->exec("INSERT INTO versao (versao) VALUES (3)");
}
if ($versao < 4) {
    $database->exec("INSERT INTO codigos_promocionais (codigo, desconto, usado) VALUES ('UFUFEQ82', 10, 0)");
    $database->exec("INSERT INTO codigos_promocionais (codigo, desconto, usado) VALUES ('D9U91EF8', 10, 0)");
    $database->exec("INSERT INTO codigos_promocionais (codigo, desconto, usado) VALUES ('9UC1NE01', 10, 0)");
    $database->exec("INSERT INTO codigos_promocionais (codigo, desconto, usado) VALUES ('CIUQ9OEN', 10, 0)");
    $database->exec("INSERT INTO codigos_promocionais (codigo, desconto, usado) VALUES ('COQUC9UE', 10, 0)");
    $database->exec("INSERT INTO codigos_promocionais (codigo, desconto, usado) VALUES ('CONQCEO2', 10, 0)");

    // versionamento
    $database->exec("INSERT INTO versao (versao) VALUES (4)");
}
?>