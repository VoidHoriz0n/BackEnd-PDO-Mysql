<?php
session_start();
include_once "classes/Database.class.php";
include_once "classes/CRUD.class.php";
  
$pdo = Database::getInstance();  
$crud = Crud::getInstance($pdo, 'produto');  

// Consulta os dados da cliente
$sql        = "SELECT * FROM cliente"; 
$arrayParam = ""; 
$dados      = $crud->getSQLGeneric($sql, $arrayParam, TRUE);
?>
<html>
    <head>  
        <title>Consulta de Clientes</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/bootstrap.min.css">
    </head>
    <body>
        <div class="container ">
        <table class="table table-responsive justify-content-center">
        <thead>
            <tr class="table-primary">
                <th class="col-md-2" scope="col">Cód</th>
                <th scope="col">Nome</th>
                <th scope="col">Usuário</th>
                <th scope="col">Email</th>
                
                <?php if($_SESSION['nivel'] == 1){ ?>
                <th colspan="3" scope="col">Ações</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach($dados as $dc){ ?>
            <tr>
                <td><?php echo $dc->codigoCliente; ?></td>
                <td><?php echo $dc->nomeCliente; ?></td>
                <td><?php echo $dc->clienteUsuario; ?></td>
                <td><?php echo $dc->email; ?></td>
                <?php if($_SESSION['nivel'] == 1){ ?>
                <td><a class="btn btn-primary" href="updateCliente.php?id=<?php echo $dc->codigoCliente;?>">Altera</a></td>
                <td><a class="btn btn-danger" href="deleteCliente.php?id=<?php echo $dc->codigoCliente;?>" onclick="return confirm('Tem certeza que deseja deletar esse registro?');">Excluir</a></td>
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