<?php 
include_once "classes/Database.class.php";
include_once "classes/CRUD.class.php";

$pdo = Database::getInstance();  
$crud = Crud::getInstance($pdo, 'movimento'); 

$sqlp = "SELECT * FROM piloto";
$arrayParam = ""; 
$lpiloto = $crud->getSQLGeneric($sqlp, $arrayParam, TRUE);

?>
<!DOCTYPE html>
<html lang="pt_br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Movimento por Data</title>
</head>
<body>
    <form method="post" action="relatorioPilotoData.php">
        <label>Data Inicial:</label>
        <input type="date" name="dtInicial" required="required"><br>
        <label>Data Final:</label>
        <input type="date" name="dtFinal"><br>
        <label>Cod. ANAC:</label>
        <input type="text" name="piloto"><br>
        <input type="submit" value="Buscar Data" name="buscaData">
    </form>
</body>
</html>
