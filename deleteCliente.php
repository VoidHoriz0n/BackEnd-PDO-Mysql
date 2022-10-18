<?php 
include_once "classes/Database.class.php";
include_once "classes/CRUD.class.php";

$pdo = Database::getInstance();  
$crud = Crud::getInstance($pdo, 'cliente');

$id = $_GET['id'];

 // Exclui o registro do usuário com id ? 

 $arrayCond = array('codigoCliente=' => $id);  
 $retorno   = $crud->delete($arrayCond);  
 header('Refresh: 1; url=index.php');
?>