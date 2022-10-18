<?php 
include_once "classes/Database.class.php";
include_once "classes/CRUD.class.php";

$pdo = Database::getInstance();  
$crud = Crud::getInstance($pdo, 'categoria');

$id = $_GET['id'];

 // Exclui o registro do usuário com id ? 

 $arrayCond = array('codigoCategoria=' => $id);  
 $retorno   = $crud->delete($arrayCond);  
 header('Refresh: 1; url=readCategoria.php');
?>