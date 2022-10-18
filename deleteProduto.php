<?php 
include_once "classes/Database.class.php";
include_once "classes/CRUD.class.php";

$pdo = Database::getInstance();  
$crud = Crud::getInstance($pdo, 'produto');

$id = $_GET['id'];

 // Exclui o registro do usuário com id ? 

 $arrayCond = array('codigoProduto=' => $id);  
 $retorno   = $crud->delete($arrayCond);  
 header('Refresh: 1; url=index.php');
?>