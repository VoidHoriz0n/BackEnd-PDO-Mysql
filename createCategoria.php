<?php 
session_start();
?>
<html>
    <head>  
        <title>Cadastro de Categorias</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/bootstrap.min.css">
    </head>
    <body>
    <div class="container">
        <?php echo $_SESSION['nome']." - nivel ".$_SESSION['nivel']; ?>
        <form method="POST">
            <label>Descrição</label>
            <input type="text" class="form-control col-lg-6" name="descricaoCategoria">
            <input type="submit" class="btn btn-primary" value="Cadastrar" name="btCadastrar">
        </form>
        </div>
 
<?php include_once "classes/fimhtml.php"; ?>
<?php 
include_once "classes/Database.class.php";
include_once "classes/CRUD.class.php";

// Consumindo métodos do CRUD genérico 
 
 // Atribui uma conexão PDO   
$pdo = Database::getInstance();  
 
 // Atribui uma instância da classe Crud, passando como parâmetro a conexão PDO e o nome da tabela  
 $crud = Crud::getInstance($pdo, 'categoria');  
 
 // validar os dados vindo do formulário
 if(isset($_POST['btCadastrar'])){

    $descricao = isset($_POST['descricaoCategoria']) ? $_POST['descricaoCategoria'] : null;

    if(empty($descricao)){ echo "Campo obrigatório de preenchimento";exit;}

    // Inseri os dados do usuário
    $Categoria = array('descricaoCategoria' => $descricao);  
    $retorno   = $crud->insert($Categoria);
 }
?>