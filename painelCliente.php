<?php
 	include 'conexao.php';

 	$id_cliente = $_GET['id_cliente'];

 	$select_cliente = $pdo->prepare("SELECT * FROM cliente WHERE id_cliente=?");
 	$select_cliente->execute(array($id_cliente));
 	$res = $select_cliente->fetchAll();

 	foreach ($res as $key => $value) {
 		$nome_cliente = $value['nome_cliente'];
 	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Locadora - Matusalém</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/bootstrap.min.css">
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
	       	 	<a class="nav-link active" href="painelCliente.php?id_cliente=<?php echo $id_cliente; ?>">Início</a>
	      	</li>
	      	<li class="nav-item">
	       	 	<a class="nav-link" href="editarConta.php?id_cliente=<?php echo $id_cliente; ?>">Conta</a>
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
	<p class="font-weight-bold"><i><h1>Bem Vindo <?php echo $nome_cliente; ?></h1></i></p>
 		<span class="font-weight-bold text-primary"><i>Cliente</i></span>	
 		<hr>


	<div class="alert alert-light" role="alert">
 		<a href="entrarUsuario.php?id_cliente=<?php echo $id_cliente ?>" class="alert-link">Entrar como usuário</a>
	</div>

	<div class="alert alert-primary" role="alert">
 		<a href="painelCliente.php?pg=idadeCliente_filme&id_cliente=<?php echo $id_cliente; ?>" class="alert-link">Adicionar Filme</a>
	</div>

	<div class="alert alert-danger" role="alert">
 		<a href="painelCliente.php?pg=idadeCliente_serie&id_cliente=<?php echo $id_cliente; ?>" class="alert-link">Adicionar Série</a>
	</div>

	<div class="alert alert-warning" role="alert">
 		<a href="addUsuario.php?id_cliente=<?php echo $id_cliente ?>" class="alert-link">Adicionar Usuários</a> - <strong><i>Você so poderá adicinar 5 usuários</i></strong> 
	</div>
	<hr>
	<div class="alert alert-primary" role="alert">
 		<a href="listaFilme.php?pg=listaFilmes&id_cliente=<?php echo $id_cliente; ?>" class="alert-link">Minha lista de filmes</a>
	</div>

	<div class="alert alert-danger" role="alert">
 		<a href="listaSerie.php?pg=listaSeries&id_cliente=<?php echo $id_cliente; ?>" class="alert-link">Minha lista de Séries</a>
	</div>

	<div class="alert alert-primary" role="alert">
 		<a href="filmeFavorito.php?id_cliente=<?php echo $id_cliente; ?>" class="alert-link">Filmes Favoritos</a>
	</div>

	<div class="alert alert-danger" role="alert">
 		<a href="serieFavorita.php?id_cliente=<?php echo $id_cliente; ?>" class="alert-link">Séries Favoritas</a>
	</div>


<div>	
<?php 
	if(@$_GET['pg'] == 'idadeCliente_filme'){

		$data_atual_PC = date("Y");

		$selecionar_cliente = $pdo->prepare("SELECT * FROM cliente WHERE id_cliente=?");
		$selecionar_cliente->execute(array($id_cliente));

		$res_selecionar_cliente = $selecionar_cliente->fetchAll();
	
		foreach ($res_selecionar_cliente as $key => $value) {
			$data_formatada_banco = date("Y",strtotime($value['nacimento_cliente']));
		}

		$idade_cliente = $data_atual_PC - $data_formatada_banco;

		if($idade_cliente >= 18){
			echo "<script>;window.location.href = 'addFilme.php?pg=todosFilmes&id_cliente=$id_cliente'</script>";
		}else if($idade_cliente == 10){
			echo "<script>;window.location.href = 'addFilme.php?pg=filmes10&id_cliente=$id_cliente'</script>";
		}else if($idade_cliente == 11){
			echo "<script>;window.location.href = 'addFilme.php?pg=filmes10&id_cliente=$id_cliente'</script>";
		}else if($idade_cliente == 12){
			echo "<script>;window.location.href = 'addFilme.php?pg=filmes12&id_cliente=$id_cliente'</script>";
		}else if($idade_cliente == 13){
			echo "<script>;window.location.href = 'addFilme.php?pg=filmes12&id_cliente=$id_cliente'</script>";
		}else if($idade_cliente == 14){
			echo "<script>;window.location.href = 'addFilme.php?pg=filmes14&id_cliente=$id_cliente'</script>";
		}else if($idade_cliente == 15){
			echo "<script>;window.location.href = 'addFilme.php?pg=filmes14&id_cliente=$id_cliente'</script>";
		}else if($idade_cliente == 16){
			echo "<script>;window.location.href = 'addFilme.php?pg=filmes16&id_cliente=$id_cliente'</script>";
		}else if($idade_cliente == 17){
			echo "<script>;window.location.href = 'addFilme.php?pg=filmes16&id_cliente=$id_cliente'</script>";
		}else{
			echo "<script>;window.location.href = 'addFilme.php?pg=filmesLivre&id_cliente=$id_cliente'</script>";
		}
	}

?>

<?php 
	if(@$_GET['pg'] == 'idadeCliente_serie'){

		$data_atual_PC = date("Y");

		$selecionar_cliente = $pdo->prepare("SELECT * FROM cliente WHERE id_cliente=?");
		$selecionar_cliente->execute(array($id_cliente));

		$res_selecionar_cliente = $selecionar_cliente->fetchAll();
	
		foreach ($res_selecionar_cliente as $key => $value) {
			$data_formatada_banco = date("Y",strtotime($value['nacimento_cliente']));
		}

		$idade_cliente = $data_atual_PC - $data_formatada_banco;

		if($idade_cliente >= 18){
			echo "<script>;window.location.href = 'addSerie.php?pg=todasSeries&id_cliente=$id_cliente'</script>";
		}else if($idade_cliente == 10){
			echo "<script>;window.location.href = 'addSerie.php?pg=series10&id_cliente=$id_cliente'</script>";
		}else if($idade_cliente == 11){
			echo "<script>;window.location.href = 'addSerie.php?pg=series10&id_cliente=$id_cliente'</script>";
		}else if($idade_cliente == 12){
			echo "<script>;window.location.href = 'addSerie.php?pg=series12&id_cliente=$id_cliente'</script>";
		}else if($idade_cliente == 13){
			echo "<script>;window.location.href = 'addSerie.php?pg=series12&id_cliente=$id_cliente'</script>";
		}else if($idade_cliente == 14){
			echo "<script>;window.location.href = 'addSerie.php?pg=series14&id_cliente=$id_cliente'</script>";
		}else if($idade_cliente == 15){
			echo "<script>;window.location.href = 'addSerie.php?pg=series14&id_cliente=$id_cliente'</script>";
		}else if($idade_cliente == 16){
			echo "<script>;window.location.href = 'addSerie.php?pg=series16&id_cliente=$id_cliente'</script>";
		}else if($idade_cliente == 17){
			echo "<script>;window.location.href = 'addSerie.php?pg=series16&id_cliente=$id_cliente'</script>";
		}else if($idade_cliente < 10){
			echo "<script>;window.location.href = 'addSerie.php?pg=seriesLivre&id_cliente=$id_cliente'</script>";
		}
	}

?>
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>