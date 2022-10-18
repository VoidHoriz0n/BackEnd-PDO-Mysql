<?php 
include_once "classes/Database.class.php";
include_once "classes/CRUD.class.php";

$pdo = Database::getInstance();  
$crud = Crud::getInstance($pdo, 'produto');

$id = $_GET['id'];

// Consulta os dados da categoria com id informado 
$sql        = "SELECT * FROM produto WHERE codigoProduto = ?";  
$arrayParam = array($id);  
$dados      = $crud->getSQLGeneric($sql, $arrayParam, FALSE);
?>
<html>
    <head>  
        <title>Alteração de Estoque do Produto</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/bootstrap.min.css">
    </head>
    <body>
    <div class="container">
        <form method="POST">
        <label>Nome Produto</label>
            <input type="text" class="form-control col-lg-6" name="nomeProduto" readonly="readonly" value="<?php echo $dados->nomeProduto; ?>">
        <label>Estoque</label>
        <input type="text" class="form-control col-lg-6" name="estoque" value="<?php echo $dados->estoque; ?>">
        <input type="submit" class="btn btn-primary" value="Alterar" name="btAlterar">
        </form>
    </div>
 
<?php include_once "classes/fimhtml.php"; ?>
<?php 

// validar os dados vindo do formulário
 if(isset($_POST['btAlterar'])){

    $estoque    = isset($_POST['estoque']) ? $_POST['estoque'] : null;

    // Editar os dados da produto com id ? 
    $Estoques = array( 'estoque' => $estoque);  
    $arrayCond = array('codigoProduto=' => $id);  
    $retorno   = $crud->update($Estoques, $arrayCond);
    header("Location: readProduto.php");
 }
?>