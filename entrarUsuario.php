<?php
	include 'conexao.php';
    $id_cliente = $_GET['id_cliente'];
    
	$sql = $pdo->prepare("SELECT * FROM usuario WHERE cliente_id=?");
	$sql->execute(array($id_cliente));
	$res= $sql->fetchAll();
	
   
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Locadora - Matuzalém</title>
</head>
<body>
	<!--NAVBAR----------------------------------------------------------------------------------------------------->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<a class="navbar-brand" href="index.php">MATUSALÈM</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav">
				<li class="nav-item">
				<a class="nav-link" href="painelCliente.php?id_cliente=<?php echo $id_cliente; ?>">Início</a>
				</li>
			<li class="nav-item">
					<a class="nav-link" href="login.php">Sair</a>
				</li>
			</ul>
		</div>
		</nav>
		<br>
	<!--NAVBAR----------------------------------------------------------------------------------------------------->

	<div class="container">
	<h3>Seus usuários</h3>
	<br>
		<table class="table">
			<tbody>
			<?php
				foreach ($res as $key => $value) {
					$id_usuario = $value['id_usuario'];
					$nome_usuario = $value['nome_usuario'];
			?>
				<tr>
					<td><?php echo $nome_usuario; ?></td>
					<td><a href="" class="btn btn-success " >Entar</a>
					<a href="entrarUsuario.php?pg=remover&id_usuario=<?php echo $id_usuario; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger " >Remover</a></td>
				</tr>
				<?php } ?>
			</tbody>
			</table>
		</div>

	<?php 
		if(@$_GET['pg'] == 'remover'){
			$id_usuario = $_GET['id_usuario'];
			$id_cliente = $_GET['id_cliente'];

			$remover = $pdo->prepare("DELETE FROM usuario WHERE id_usuario=?");
			$remover->execute(array($id_usuario));

			if($remover == true){
				echo "<script>window.location.href = 'entrarUsuario.php?id_cliente=$id_cliente'</script>";

				
			}
		}
	?>
	
</div>
</body>
</html>
