<?php 
session_start();
?>
<html>
<head>
    <title>..: Login :..</title>
    <meta charset="utf-8">
</head>
<body>
<form method="POST">
  <div class="form-group">
    <label>Usuário</label>
    <input type="text" class="form-control" name="usuario">
  </div>
  <div class="form-group">
    <label>Senha</label>
    <input type="password" name="senha" class="form-control">
  </div>
  <button type="submit" name="btnLogar" class="btn btn-primary">Enviar</button>
</form>
</body>
</html>

<?php 
include_once "classes/Database.class.php";
include_once "classes/CRUD.class.php";

$pdo = Database::getInstance();  
$crud = Crud::getInstance($pdo, 'usuario');

if(isset($_POST['btnLogar'])){

    $usuario    = (isset($_POST['usuario'])) ? $_POST['usuario'] : null;
    $senha      = (isset($_POST['senha'])) ? $_POST['senha'] : null;

    // Consulta os dados da categoria com id informado 
    $sql        = "SELECT * FROM usuario WHERE usuario = ? AND senha = ?";  
    $arrayParam = array($usuario,$senha);  
    $dados      = $crud->getSQLGeneric($sql, $arrayParam, FALSE);
    
    if($dados){
        $_SESSION['cliente']    = $dados->codigoCliente;
        $_SESSION['usuario']    = $dados->usuario;
        $_SESSION['nivel']      = $dados->nivel;
        $_SESSION['nome']       = $dados->nome;
        header('Refresh:1; url=painel.php');
    }else{
        echo "Usuário ou senha inválidos";
        header('Refresh:1; url=login.php');
    }
}
?>