<?php 
session_start();

/*function __autoload($classe){
	require_once 'classes/'.$classe.'.class.php'; 
}*/
if($_SESSION['nivel'] == 1){
    echo "Você é administrador";
}else{
    echo "Entrada permitida somente a administradores";
    header('Refresh:10; url=login.php');
}
?>
<html>
    <head>  
        <title>Cadastro de Categorias</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/bootstrap.min.css">
    </head>
    <body>
    <div class="container">
        <a href="createCategoria.php">Cadastra Categoria</a><br>
        <a href="createProduto.php">Cadastra Produto</a><br>
        <a href="createCliente.php">Cadastra Cliente</a><br>
        <a href="readCategoria.php">Lista Categoria</a><br>
        <a href="readProduto.php">Lista Produto</a><br>
        <a href="readCliente.php">Lista Cliente</a><br>
    </div>
<?php include_once "classes/fimhtml.php" ?>