<?php 
include_once "classes/Database.class.php";
include_once "classes/CRUD.class.php";

$pdo = Database::getInstance();  
$crud = Crud::getInstance($pdo, 'cliente'); 

?>
<html>
    <head>  
        <title>Cadastro de Cliente</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/bootstrap.min.css">
    </head>
    <body>
    <div class="container">
        <form method="POST">
            <label>Nome</label>
            <input type="text" class="form-control col-lg-6" name="nome">
            <label>Usuário</label>
            <input type="text" class="form-control col-lg-6" name="usuario">
            <label>Email</label>
            <input type="email" class="form-control col-lg-6" name="email">
            <label>Senha</label>
            <input type="password" class="form-control col-lg-6" name="senha">
            <input type="submit" class="btn btn-primary" value="Cadastrar" name="btCadastrar">
        </form>
        </div>
 
<?php include_once "classes/fimhtml.php"; ?>
<?php 
 
 // validar os dados vindo do formulário
 if(isset($_POST['btCadastrar'])){

    $nome      = isset($_POST['nome'])      ? $_POST['nome']    : null;
    $usuario   = isset($_POST['usuario'])   ? $_POST['usuario'] : null;
    $email     = isset($_POST['email'])     ? $_POST['email']   : null;
    $senha     = isset($_POST['senha'])     ? $_POST['senha']   : null;
    
    // Inseri os dados do categoria
    $Cliente = array(
        'nomeCliente'       => $nome,
        'clienteUsuario'    => $usuario,
        'email'             => $email,
        'senha'             => $senha
    );  
    $retorno   = $crud->insert($Cliente);
 }
?>