<?php
	include 'conexao.php';
	$id_cliente = $_GET['id_cliente'];
	

	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Locadora - Matusalém</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
	<?php
		if(@$_GET['pg']=='filme'){
	?>
	<!--NAVBAR----------------------------------------------------------------------------------------------------->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	  <a class="navbar-brand" href="index.php">MATUSALÈM</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>
	  <div class="collapse navbar-collapse" id="navbarNav">
	    <ul class="navbar-nav">
	      	<li class="nav-item">
	       	 <a class="nav-link" href="listaFilme.php?pg=listaFilmes&id_cliente=<?php echo $id_cliente; ?>">Voltar</a>
	      	</li>
	    </ul>
	  </div>
	</nav>
	<br>
<!--NAVBAR----------------------------------------------------------------------------------------------------->
	<?php } ?>

	<?php
		if(@$_GET['pg']=='serie'){
	?>
	<!--NAVBAR----------------------------------------------------------------------------------------------------->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	  <a class="navbar-brand" href="index.php">MATUSALÈM</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>
	  <div class="collapse navbar-collapse" id="navbarNav">
	    <ul class="navbar-nav">
	      	<li class="nav-item">
	       	 <a class="nav-link" href="listaSerie.php?pg=listaSeries&id_cliente=<?php echo $id_cliente; ?>">Voltar</a>
	      	</li>
	    </ul>
	  </div>
	</nav>
	<br>
<!--NAVBAR----------------------------------------------------------------------------------------------------->
	<?php } ?>




<div class="container">
	<?php
		if(@$_GET['pg']=='filme'){
			$id_filme = $_GET['id_filme'];
			

			$buscar_filme = $pdo->prepare("SELECT * FROM filme WHERE id_filme=?");
			$buscar_filme->execute(array($id_filme));
			$res_filme = $buscar_filme->fetchAll();

			foreach ($res_filme as $key => $value) {
				$nome_filme = $value['nome_filme'];
			}
	?>
	<h5 style="text-align: center;"><?php echo $nome_filme; ?></h5>
	<h3>O filme apareceria aqui...</h3>
	<?php  } ?>

	<?php
		if(@$_GET['pg']=='serie'){
			$id_serie = $_GET['id_serie'];
			$buscar_serie = $pdo->prepare("SELECT * FROM serie WHERE id_serie=?");
			$buscar_serie->execute(array($id_serie));
			$res_serie = $buscar_serie->fetchAll();

			foreach ($res_serie as $key => $value) {
				$nome_serie = $value['nome_serie'];
			}
	?>
	<h5 style="text-align: center;"><?php echo $nome_serie; ?></h5>
	<h3>A série apareceria aqui...</h3>
	<?php  } ?>

</div>


	
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>