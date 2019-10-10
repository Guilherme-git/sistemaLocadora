<?php
	require_once 'conexao.php';

	$buscarFilme = $pdo->prepare("SELECT * FROM filme");
	$buscarFilme->execute();
	$quantidadeFilme = $buscarFilme->fetchAll();

	$buscarSerie = $pdo->prepare("SELECT * FROM serie");
	$buscarSerie->execute();
	$quantidadeSerie = $buscarSerie->fetchAll();

	$quantidadeTOTAL = $quantidadeFilme + $quantidadeSerie;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Locadora - Matusalém</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/bootstrap.min.css">
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
	       	 <a class="nav-link active" href="index.php">Início</a>
	      	</li>
	      	<li class="nav-item">
	        	<a class="nav-link" href="filme.php?pg=listaFilmes">Filmes</a>
	      	</li>
	     	 <li class="nav-item">
	        	<a class="nav-link" href="serie.php?pg=listaSerie">Séries</a>
	      	</li>
	      	<li class="nav-item">
	        	<a class="nav-link" href="cadastroCliente.php">Cadastrar</a>
	     	 </li>
	       <li class="nav-item">
	        	<a class="nav-link" href="login.php">Login</a>
	      	</li>
	    </ul>
	  </div>
	</nav>
	<br>
<!--NAVBAR----------------------------------------------------------------------------------------------------->
	<div class="container-fluid">
		<div class="jumbotron">
			<h1 class="display-4">Número de filmes e séries registrados é <?php echo count($quantidadeTOTAL); ?></h1>
		</div>
	</div>

	
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>