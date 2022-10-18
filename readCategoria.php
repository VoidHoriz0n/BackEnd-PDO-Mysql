<?php
session_start();
include_once "classes/Database.class.php";
include_once "classes/CRUD.class.php";
  
$pdo = Database::getInstance();  
 $crud = Crud::getInstance($pdo, 'categoria');  

// Consulta os dados da categoria 
$sql        = "SELECT * FROM categoria"; 
$arrayParam = ""; 
$dados      = $crud->getSQLGeneric($sql, $arrayParam, TRUE);
?>
<html>
    <head>  
        <title>Consulta de Categorias</title>
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
                <?php if($_SESSION['nivel'] == 1){ ?>
                <th colspan="2" scope="col">Ações</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach($dados as $d){ ?>
            <tr>
                <td><?php echo $d->codigoCategoria; ?></td>
                <td><?php echo $d->descricaoCategoria; ?></td>
                <?php if($_SESSION['nivel'] == 1){ ?>
                <td><a class="btn btn-primary" href="updateCategoria.php?id=<?php echo $d->codigoCategoria;?>">Altera</a></td>
                <td><a class="btn btn-danger" href="deleteCategoria.php?id=<?php echo $d->codigoCategoria;?>" onclick="return confirm('Tem certeza que deseja deletar esse registro?');">Excluir</a></td>
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