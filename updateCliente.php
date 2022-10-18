<?php 
include_once "classes/Database.class.php";
include_once "classes/CRUD.class.php";

$pdo = Database::getInstance();  
$crud = Crud::getInstance($pdo, 'cliente');

$id = $_GET['id'];

// Consulta os dados da categoria com id informado 
$sql        = "SELECT * FROM cliente WHERE codigoCliente = ?";  
$arrayParam = array($id);  
$dados      = $crud->getSQLGeneric($sql, $arrayParam, FALSE);
?>
<html>
    <head>  
        <title>Alteração de Clientes</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/bootstrap.min.css">
    </head>
    <body>
    <div class="container">
        <form method="POST">
        <label>Nome Cliente</label>
            <input type="text" class="form-control col-lg-6" name="nome" value="<?php echo $dados->nomeCliente; ?>">
        <label>Usuário</label>
        <input type="text" class="form-control col-lg-6" name="usuario" value="<?php echo $dados->clienteUsuario; ?>">
        <label>Email</label>
        <input type="email" class="form-control col-lg-6" name="email" value="<?php echo $dados->email; ?>">
        <input type="submit" class="btn btn-primary" value="Alterar" name="btAlterar">
        </form>
        </div>
 
<?php include_once "classes/fimhtml.php"; ?>
<?php 

// validar os dados vindo do formulário
 if(isset($_POST['btAlterar'])){

    $nome       = isset($_POST['nome'])     ? $_POST['nome']    : null;
    $usuario    = isset($_POST['usuario'])  ? $_POST['usuario'] : null;
    $email      = isset($_POST['email'])    ? $_POST['email']   : null;

    // Editar os dados da produto com id ? 
    $Clientes = array(
        'nomeCliente'       => $nome,
        'clienteUsuario'    => $usuario,
        'email'             => $email);  
    $arrayCond = array('codigoCliente=' => $id);  
    $retorno   = $crud->update($Clientes, $arrayCond);
    header("Location: index.php");
 }
?>