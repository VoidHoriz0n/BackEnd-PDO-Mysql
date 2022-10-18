<?php 
session_start();

if(!isset($_SESSION)){
	header('Location: loginCliente.php');
	
}else{
	$idCliente = $_SESSION['cliente'];
}

include_once "classes/Database.class.php";
include_once "classes/CRUD.class.php";
  
$pdo = Database::getInstance();  
$crud = Crud::getInstance($pdo, 'movimento');

// Consulta os dados da produto 
$sql        = "SELECT * FROM cliente WHERE codigoCliente = ?"; 
$arrayParam = array($idCliente); 
$clientes      = $crud->getSQLGeneric($sql, $arrayParam, FALSE);

if(!isset($_SESSION['carrinho'])){
	$_SESSION['carrinho'] = array();
} 

if(isset($_GET['ac'])){

	// adiciona ao carrinho

	if($_GET['ac'] == 'add'){
		$id = intval($_GET['id']);
		if(!isset($_SESSION['carrinho'][$id])){
			$_SESSION['carrinho'][$id] = 1;
		} else {
			$_SESSION['carrinho'][$id] += 1;
		}
	}

	if($_GET['ac'] == 'del'){
		$id = intval($_GET['id']);
		if(isset($_SESSION['carrinho'][$id])){
			unset($_SESSION['carrinho'][$id]);
		}
	} 

	if($_GET['ac'] == 'up' && count($_SESSION['carrinho']) != 0){
		if(is_array($_POST['prod'])){
			foreach($_POST['prod'] as $id => $qtd){
				$id = intval($id);
				$qtd = intval($qtd);
				if(!empty($qtd) || $qtd <> 0){
					$_SESSION['carrinho'][$id] = $qtd;
				}else{
					unset($_SESSION['carrinho'][$id]);
				}
			}
		}
	}
	header("Location: carrinho.php");
}
?>

<html>
<head>
    <title>Movimento</title>
    <meta charset="utf-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container w-100 p-3">
	<div class="row justify-content-md-center">
        <div class="bg-light">
		<h1>Carrinho de Compras</h1>

		<table class="table tabela">
		<tr>
			<td class="acao">Ação</td>
			<td>Produto</td>
			<td>Quant</td>
			<td>Preço</td>
			<td>SubTotal</td>			
		</tr>
		<form action="?ac=up" method="post">
			<?php 
			if(count($_SESSION['carrinho']) == 0){
				echo '<tr><td colspan="5">Não há produto no carrinho</td></tr>';
			} else {
				$total = 0;
				$i = 0;

				foreach($_SESSION['carrinho'] as $id => $qtd){
                    $sql= "SELECT * FROM produto WHERE codigoProduto = ?"; 
                    $arrayParam = array($id); 
                    $dados = $crud->getSQLGeneric($sql, $arrayParam, FALSE);

					$produto = $dados->nomeProduto;
					$preco = number_format($dados->preco, 2, ',', '.');
					$sub = number_format($dados->preco * $qtd, 2, ',', '.');
					$total += $dados->preco * $qtd;

					$_SESSION['valor_total'] = $total;

					$i++;
					echo '
					<tr>
						<td><a href="?ac=del&id='.$id.'"><img src="img/lixeira.png" width="20px" height="20px"></a></td>
						<td><b>'.$produto.'</b></td>
						<td><input type="text" size="3" name="prod['.$id.']" value="'.$qtd.'" /></td>
						<td>R$ '.$preco.'</td>
						<td>R$ '.$sub.'</td>
					</tr>';
				}
				$total = number_format($total, 2, ',', '.');

				echo '<tr>
				<td colspan=2><input class="btn btn-success col-12" type="submit" value="Atualizar Carrinho" /></td> </td>
				<td colspan="2" class="text-right font-weight-bold">Total</td><td class="font-weight-bold">R$ '.$total.'</td></tr>';
			} ?>
	</form>
	
</table>
<div class="row justify-content-md-center">
	<div class="col-6"><a class="btn btn-dark col-12" href="mostraProduto.php">Continuar Comprando</a></td>
</div>
<div class="col-6"><button type="button" class="btn btn-primary col-12" data-toggle="modal" data-target="#vendas">Fechar Venda</button></div>

</div>
<div class="modal fade" id="vendas" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
      		<div class="modal-header">
				<h5 class="modal-title">Finalizando a venda</h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      		</div>
      		<div class="modal-body">
        		<form method="post">
          			<div class="form-group">
            			<label class="col-form-label">Cliente:</label>
						<input type="text" name="cliente" value="<?php echo $clientes->nomeCliente;?>">
          			</div>
          			<div class="form-group">
						<?php $hoje = date('d/m/Y');?>
						<label class="col-form-label">Data:</label>
						<input type="text" value="<?php echo $hoje;?>" readonly="readonly">
          			</div>
					
        		
      		</div>
      		<div class="modal-footer">
        		<button type="submit" name="finalizaVenda" class="btn btn-primary">Fechar Venda</button>
      		</div>
			  </form>
    	</div>
  	</div>
</div>
</body>
</html>
<?php
if(isset($_POST['finalizaVenda'])){

	$Movimentos = array(
        'tipo' => "S",
		'cliente' => (int) $_SESSION['cliente'],
        'dataCompra' => date('Y-m-d'),
        'valorTotal' => $_SESSION['valor_total']   
    );  

    $movimento   = $crud->insert($Movimentos);

	$_SESSION['ultimoId'] = $movimento[1];
	var_dump($_SESSION);

	//inserindo os itens comprados 
	foreach($_SESSION['carrinho'] as $id => $qtd){
		
	$stm = $pdo->prepare("insert into itens (Venda_idVenda,Produto_codigoProduto,quantidade) values (?,?,?)");
	$stm->bindValue('1', $_SESSION["ultimoId"]);
	$stm->bindValue('2', $id);
	$stm->bindValue('3', $qtd);
	$stm->execute();


	unset($_SESSION['carrinho']);
	unset($_SESSION['valor_total']);

	header("Location: mostraProduto.php");

	}
}
?>