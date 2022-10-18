<?php 
session_start();

include_once "classes/Database.class.php";
include_once "classes/CRUD.class.php";

if(CRUD::checaCliente()){
    include_once("mostraProduto.php");
}else{
    include_once("loginCliente.php");
}
?>
<html>
<head>
    <title>..: Login - Cliente :..</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
</head>
<body>
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-4 bg-light">
        <h2 class="center">Login</h2>
            <form method="POST">
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" class="form-control" name="email">
                </div>
                <div class="form-group">
                    <label>Senha</label>
                    <input type="password" name="senha" class="form-control">
                </div>
                <button type="submit" name="btnLogar" class="btn btn-primary">Logar</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>

<?php 

$pdo = Database::getInstance();  
$crud = Crud::getInstance($pdo, 'cliente');

if(isset($_POST['btnLogar'])){

    $cliente    = (isset($_POST['email'])) ? $_POST['email'] : null;
    $senha      = (isset($_POST['senha'])) ? $_POST['senha'] : null;

    // Consulta os dados da categoria com id informado 
    $sql        = "SELECT * FROM cliente WHERE email = ? AND senha = ?";  
    $arrayParam = array($cliente,$senha);  
    $clientes   = $crud->getSQLGeneric($sql, $arrayParam, FALSE);
    
    if($clientes){
        $_SESSION['cliente']    = $clientes->codigoCliente;
        $_SESSION['nome']       = $clientes->nomeCliente;
        $_SESSION['nivel']      = 0;
        header('Refresh:5; url=mostraProduto.php');
    }else{
        echo "Cliente ou senha inválidos";
        header('Refresh:1; url=loginCliente.php');
    }
}
?>