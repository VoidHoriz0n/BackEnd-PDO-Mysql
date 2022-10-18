<?php 
include_once "classes/Database.class.php";
include_once "classes/CRUD.class.php";

$pdo = Database::getInstance();  
$crud = Crud::getInstance($pdo, 'cidade'); 

/*
constantes de configuração
*/

define("QTDE_REGISTROS", 11);
define("RANGE_PAGINAS", 1);

// recuperar o numero da pagina vinda pelo GET
$pagina_atual = (isset($_GET['pagina']) && is_numeric($_GET['pagina']) ? $_GET['pagina'] : 1);

// calcula a linha inicial da consulta
$linha_inicial = ($pagina_atual - 1) * QTDE_REGISTROS;

// Consulta os dados da categoria 
$sqlc        = "
        SELECT c.nome, e.uf FROM cidade as c
        INNER JOIN estado as e
        ON c.estado = e.id
        LIMIT {$linha_inicial}, ".QTDE_REGISTROS; 
$arrayParam = ""; 
$dcida = $crud->getSQLGeneric($sqlc, $arrayParam, TRUE);

$sqln       = "SELECT count(*) as total_registros FROM cidade";
$arrayParam = ""; 
$dnum = $crud->getSQLGeneric($sqln, $arrayParam, FALSE);

$primeira_pagina    = 1;

// calculando o numero da ultima pagina
$ultima_pagina      = ceil($dnum->total_registros / QTDE_REGISTROS);

// calcular qual será a pagina anterior em relação a pagina atual
$pagina_anterior    = ($pagina_atual > 1) ? $pagina_atual -1 : null ;

// calcula qual será a proxima pagina em relação a pagina atual
$proxima_pagina     = ($pagina_atual < $ultima_pagina) ? $pagina_atual + 1 : null;

// calcula qual é a pagina inicial do nosso intervalo
$intervalo_inicial  = (($pagina_atual - RANGE_PAGINAS) >=1) ? $pagina_atual - RANGE_PAGINAS : 1;

// calcula qual será a pagina final do intervalo
$intervalo_final    = (($pagina_atual + RANGE_PAGINAS) <= $ultima_pagina ) ? $pagina_atual + RANGE_PAGINAS : $ultima_pagina;

// Verificar se exibe o botão Primeiro e Proximo
$exibir_botao_inicio = ($intervalo_inicial < $pagina_atual) ? 'mostrar' : 'esconder';

// Verificar se exibe o botão Anterior e Ultimo
$exibir_botao_final = ($intervalo_inicial > $pagina_atual) ? 'mostrar' : 'esconder';

?>

<html>
    <head>
        <title>Listagem de Cidades - Paginada</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <style>
        .table{
            margin: auto;
            width: 50% !important;
        }
        </style>
    </head>
    <body>
    <div id="container-fluid">
        <div class="row">
            <div class="col-8">
            <?php if(!empty($dcida)){ ?>
                <table class="table table-bordered table-striped text-center">
                    <thead>
                        <tr class="active">
                            <th>Cidade</th>
                            <th>UF</th>
                        </tr>
                    </thead>
                    <?php foreach($dcida as $dc){ ?>
                    <tbody>
                        <tr>
                            <td><?=$dc->nome?></td>
                            <td><?=$dc->uf?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <nav class="navbar navbar-dark bg-light">
                    <a class="box-navegacao" <?=$exibir_botao_inicio?> href="listaCidades.php?pagina=<?=$primeira_pagina?>" title="Primeira Pagina">Primeira</a>
                    <a class="box-navegacao" <?=$exibir_botao_inicio?> href="listaCidades.php?pagina=<?=$pagina_anterior?>" title="Pagina Anterior">Anterior</a>

                    <?php 
                    // Loop montando a paginação central com numeros
                    for($i = $intervalo_inicial; $i <= $intervalo_final; $i++){
                        $destaque = ($i == $pagina_atual) ? 'destaque' : " ";
                    ?>
                    <a class="box-navegacao" <?=$destaque?> href="listaCidades.php?pagina=<?=$i?>"><?=$i?></a>
                    <?php } ?>

                    <a class="box-navegacao" <?=$exibir_botao_inicio?> href="listaCidades.php?pagina=<?=$proxima_pagina?>" title="Proxima Pagina">Proximo</a>
                    <a class="box-navegacao" <?=$exibir_botao_inicio?> href="listaCidades.php?pagina=<?=$ultima_pagina?>" title="Ultima Pagina">Ultima Pagina</a>
                </nav>
            <?php }else{?>
                <a class="bg-danger">Nenhum registro encontrado</a>
            <?php }?>
        </div></div>
    </div>
    </body>
</html>
