<?php 
include_once "classes/Database.class.php";
include_once "classes/CRUD.class.php";

$pdo = Database::getInstance();  
$crud = Crud::getInstance($pdo, 'produto'); 

// Consulta os dados da categoria 
$sqlc        = "SELECT * FROM categoria"; 
$arrayParam = ""; 
$dcategoria = $crud->getSQLGeneric($sqlc, $arrayParam, TRUE);

// Consulta os dados da unidade 
$sqlu        = "SELECT * FROM unidade"; 
$arrayParam = ""; 
$dunidade   = $crud->getSQLGeneric($sqlu, $arrayParam, TRUE);
?>
<html>
    <head>  
        <title>Cadastro de Produtos</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/bootstrap.min.css">
    </head>
    <body>
    <div class="container">
        <form method="POST" enctype="multipart/form-data">
            <label>Categoria</label>
            <select name='categoria' class="form-control form-select col-lg-6">
                <option>Selecione</option>
                <?php foreach($dcategoria as $dc){ ?>
                <option value="<?php echo $dc->codigoCategoria; ?>"><?php echo $dc->descricaoCategoria; ?></option>
                <?php }?>
            </select>
            <label>Unidade</label>
            <select name='unidade' class="form-control form-select form-select-lg col-lg-6">
                <option>Selecione</option>
                <?php foreach($dunidade as $du){ ?>
                <option value="<?php echo $du->codigoUnidade; ?>"><?php echo $du->descricaoUnidade; ?></option>
                <?php }?>
                </select>               
            <label>Nome do Produto</label>
            <input type="text" class="form-control col-lg-6" name="nomeProduto">
            <label>Preço</label>
            <input type="text" class="form-control col-lg-6" name="preco">
            <label>Imagem</label>
            <input type="file" name="imagem" class="form-control col-lg-6"><br>
            <input type="submit" class="btn btn-primary" value="Cadastrar" name="btCadastrar">
        </form>
        </div>
 
<?php include_once "classes/fimhtml.php"; ?>
<?php 
 
 // validar os dados vindo do formulário
 if(isset($_POST['btCadastrar'])){

    $nomeProduto    = isset($_POST['nomeProduto']) ? $_POST['nomeProduto'] : null;
    $categoria      = isset($_POST['categoria']) ? $_POST['categoria'] : null;
    $unidade        = isset($_POST['unidade']) ? $_POST['unidade'] : null;
    $preco          = isset($_POST['preco']) ? $_POST['preco'] : null;

    $temp           = $_FILES['imagem']['tmp_name'];

    move_uploaded_file($temp, "img/".str_replace(" ","_",$nomeProduto).".jpg");

    // Inseri os dados do categoria
    $Produto = array(
        'nomeProduto' => $nomeProduto,
        'Categoria_codigoCategoria' => $categoria,
        'unidade' => $unidade,
        'preco' => $preco,
        'estoque' => 0,
        'imagem' => str_replace(" ","_",$nomeProduto).".jpg"   
    );  

    $retorno   = $crud->insert($Produto);
   
}
?>