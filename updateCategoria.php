<?php 
include_once "classes/Database.class.php";
include_once "classes/CRUD.class.php";

$pdo = Database::getInstance();  
$crud = Crud::getInstance($pdo, 'categoria');

$id = $_GET['id'];

// Consulta os dados da categoria com id informado 
$sql        = "SELECT * FROM categoria WHERE codigoCategoria = ?";  
$arrayParam = array($id);  
$dados      = $crud->getSQLGeneric($sql, $arrayParam, FALSE);

?>



<html>
    <head>  
        <title>Alteração de Categorias</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/bootstrap.min.css">
    </head>
    <body>
    <div class="container">
        <form method="POST">
            <label>Descrição</label>
            <input type="text" class="form-control col-lg-6" name="descricaoCategoria" value="<?php echo $dados->descricaoCategoria; ?>">
            <input type="submit" class="btn btn-primary" value="Alterar" name="btAlterar">
        </form>
        </div>
 
<?php include_once "classes/fimhtml.php"; ?>
<?php 

// validar os dados vindo do formulário
 if(isset($_POST['btAlterar'])){

    $descricao = isset($_POST['descricaoCategoria']) ? $_POST['descricaoCategoria'] : null;

    if(empty($descricao)){ 
        echo "Campo obrigatório de preenchimento";
        header("Refresh: 1; url=readCategoria.php");
        exit;
    }

    // Editar os dados da categoria com id ? 
    $Categoria = array('descricaoCategoria' => $descricao);  
    $arrayCond = array('codigoCategoria=' => $id);  
    $retorno   = $crud->update($Categoria, $arrayCond);
    header("Location: readCategoria.php");
 }
?>