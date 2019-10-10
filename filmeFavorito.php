<?php
	include 'conexao.php';
	
	$id_cliente = $_GET['id_cliente'];

	$buscar_lista_filme = $pdo->prepare("SELECT * FROM filmefavorito INNER JOIN filme WHERE cliente_id=? 
	AND `filmefavorito`.`filme_id`=`filme`.`id_filme`");
	$buscar_lista_filme->execute(array($id_cliente));
	$res_buscar_lista_filme = $buscar_lista_filme->fetchAll();

	foreach ($res_buscar_lista_filme as $key => $value) {
		$id_filme = $value['filme_id'];

	}

	

?>
<!DOCTYPE html>
<html>
<head>
	<title>Locadora - Matusalém</title>
	<meta charset="utf-8">
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



<!--MOSTRAR FILMES FAVORITOS---------------------------------------------------------------------------------------------->
	<div class="container">
  		<form method="POST" enctype="multipart/form-data">
				<div class="form-row">
				    <div class="form-group col-md-6 lista">
				       	<label for="inputEmail4"><h3>Meus filmes favoritos</h3></label>
					</div>
				</div>
				<hr>
		</form>

		<table class="table">
			<thead>
			    <tr>
			      <th scope="col">Nome</th>
			    </tr>
			</thead>
			<tbody>
				<?php
					foreach ($res_buscar_lista_filme as $key => $value) {
						$id_filme = $value['filme_id'];
						$nome_filme = $value['nome_filme'];
				?>

			    <tr>
			      <td><?php echo $nome_filme; ?></td>
			      <td>
			      	<a href="filmeFavorito.php?pg=excluir&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Excluir</a>
			      	<a href="FilmePDF.php?id_filme=<?php echo $id_filme; ?>" class="btn btn-warning my-2" >Informações completas</a>
			      </td>
			     
			    </tr>
				<?php } ?>
			</tbody>
		</table>
	
<!--MOSTAR FILMES FAVORITOS---------------------------------------------------------------------------------------------->


<!--EXCLUIR FILMES DOS FAVORITOS---------------------------------------------------------------------------------------------->
	<?php
		if(@$_GET['pg'] == 'excluir'){
			$id_filme = $_GET['id_filme'];
			$id_cliente = $_GET['id_cliente'];

			$excluir_favoritos = $pdo->prepare("DELETE FROM filmefavorito WHERE filme_id=? AND cliente_id=?");
			$excluir_favoritos->execute(array($id_filme,$id_cliente));

			if($excluir_favoritos == true){
				echo "<script>window.alert('Filme removido dos favoritos');
					window.location.href = 'filmeFavorito.php?id_cliente=$id_cliente'</script>";
			}
		}

	?>
<!--EXCLUIR FILMES DOS FAVORITOS---------------------------------------------------------------------------------------------->

	</div>
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>