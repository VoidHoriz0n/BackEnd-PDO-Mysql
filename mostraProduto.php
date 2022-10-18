<?php
session_start();
include_once "classes/Database.class.php";
include_once "classes/CRUD.class.php";
  
$pdo = Database::getInstance();  
$crud = Crud::getInstance($pdo, 'produto');  

// Consulta os dados da produto 
$sql        = "SELECT * FROM produto"; 
$arrayParam = ""; 
$dados      = $crud->getSQLGeneric($sql, $arrayParam, TRUE);
?>
<html>
    <head>  
        <title>Produtos</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <div class="row w-50 p-3">
                <div class="col justify-content-md-center bg-light">
                    <table class="table">
                        <tr class="table-primary">
                            <td> X </td>
                            <td>Nome Produto</td>
                            <td>Preço</td>
                            <td>Comprar</td>
                        </tr>
                        <?php foreach($dados as $dpr){ ?>
                        <tr class="bg-light">                                
                            <?php $codigo = $dpr->codigoProduto;?>

                            <td><img src="img/<?php echo $dpr->imagem;?>" width="50px" height="50px"></td>
                            <td><?php echo $dpr->nomeProduto; ?></td>
                            <td><?php echo "R$ ". number_format(($dpr->preco),2,',','.'); ?></td>
                            <td><a href="carrinho.php?ac=add&id=<?php echo $codigo;?>"><img src="img/carrinho.png" width="20px" height="20px"></a></td>
                        </tr>
                        <?php }?>
                        <tr>
                            <td colspan="4" class="justify-content-md-center"><center><a class="btn btn-primary" href="index.php">Voltar</a></center></center></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    <?php include_once "classes/fimhtml.php" ?>