<?php
session_start();
include_once "classes/Database.class.php";
include_once "classes/CRUD.class.php";
  
$pdo = Database::getInstance();  
$crud = Crud::getInstance($pdo, 'produto');  

// Consulta os dados da produto 
$sql        = "SELECT 
                    p.codigoProduto,
                    p.nomeProduto, 
                    c.descricaoCategoria,
                    u.descricaoUnidade,
                    p.preco,
                    p.estoque  
                    FROM produto as p
                    INNER JOIN categoria as c
                    ON p.Categoria_codigoCategoria = c.codigoCategoria
                    INNER JOIN unidade as u
                    ON p.unidade = u.codigoUnidade
                    ORDER BY p.nomeProduto"; 
$arrayParam = ""; 
$dados      = $crud->getSQLGeneric($sql, $arrayParam, TRUE);

?>
<html>
    <head>  
        <title>Consulta de Produtos</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/bootstrap.min.css">
    </head>
    <body>
        <div class="container ">
        <table class="table table-responsive justify-content-center">
        <thead>
            <tr class="table-primary">
                <th class="col-md-2" scope="col">Cód</th>
                <th scope="col">Descrição</th>
                <th scope="col">Categoria</th>
                <th scope="col">Unidade</th>
                <th scope="col">Preço</th>
                <th scope="col">Estoque</th>
                
                <?php if($_SESSION['nivel'] == 1){ ?>
                <th colspan="3" scope="col">Ações</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach($dados as $dp){ ?>
            <tr>
                <td><?php echo $dp->codigoProduto; ?></td>
                <td><?php echo $dp->nomeProduto; ?></td>
                <td><?php echo $dp->descricaoCategoria; ?></td>
                <td><?php echo $dp->descricaoUnidade; ?></td>
                <td><?php echo $dp->preco; ?></td>
                <td><?php echo $dp->estoque; ?></td>
                <?php if($_SESSION['nivel'] == 1){ ?>
                <td><a class="btn btn-primary" href="updateProduto.php?id=<?php echo $dp->codigoProduto;?>">Altera</a></td>
                <td><a class="btn btn-danger" href="deleteProduto.php?id=<?php echo $dp->codigoProduto;?>" onclick="return confirm('Tem certeza que deseja deletar esse registro?');">Excluir</a></td>
                <td><a class="btn btn-success" href="updateEstoque.php?id=<?php echo $dp->codigoProduto;?>">Altera Estoque</a></td>
                <?php } ?>
            <tr>
            <?php }?>
            <tr>
            <td><a class="btn btn-primary" href="index.php">Voltar</a></td>
            </tr>
        </tbody>
    </table>
    </div>
    <?php include_once "classes/fimhtml.php" ?>