<?php
	include 'conexao.php';
	
	$id_cliente = $_GET['id_cliente'];

	$buscar_lista_serie = $pdo->prepare("SELECT * FROM listaserie INNER JOIN serie WHERE cliente_id=? 
	AND `listaserie`.`serie_id`=`serie`.`id_serie`");
	$buscar_lista_serie->execute(array($id_cliente));
	$res_buscar_lista_serie = $buscar_lista_serie->fetchAll();

	foreach ($res_buscar_lista_serie as $key => $value) {
		$id_filme = $value['serie_id'];

	}

	

?>
<!DOCTYPE html>
<html>
<head>
	<title>Locadora - Matusalém</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/myStyle.css">
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



<!--MOSTRAR LIStA DE FILMES---------------------------------------------------------------------------------------------->
	<div class="container">
		<?php 
			if(@$_GET['pg'] == 'listaSeries'){
		?>
  		<form method="POST" enctype="multipart/form-data">
				<div class="form-row">
				    <div class="form-group col-md-6 lista">
				       	<label for="inputEmail4"><h3>Sua lista de séries</h3></label>
					</div>
				</div>
				<hr>
		</form>

		<table class="table">
			<thead>
			    <tr>
			      <th scope="col">Nome</th>
			      <th scope="col">Opnião</th>
			    </tr>
			</thead>
			<tbody>
				<?php
					foreach ($res_buscar_lista_serie as $key => $value) {
						$id_serie = $value['serie_id'];
						$nome_serie = $value['nome_serie'];
						$bom_ruim = $value['bom_ruim'];
				?>

			    <tr>
			      <td><?php echo $nome_serie; ?></td>
			      <td><?php echo $bom_ruim; ?></td>
			      <td><a href="video.php?pg=serie&id_cliente=<?php echo $id_cliente; ?>&id_serie=<?php echo $id_serie; ?>" class="btn btn-danger my-2" >Assistir</a>
			      	<a href="listaSerie.php?pg=opniao&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Opnião</a>
			      	<a href="SeriePDF.php?id_serie=<?php echo $id_serie; ?>" class="btn btn-warning my-2" >Informações completas</a>
			      </td>
			     
			    </tr>
				<?php } ?>
			</tbody>
		</table>
	<?php } ?>
<!--MOSTAR LIStA DE FILMES---------------------------------------------------------------------------------------------->



<!--OPNIAO FILMES---------------------------------------------------------------------------------------------->
	<?php
		if(@$_GET['pg'] == 'opniao'){

		if(isset($_POST['enviar'])){
		$opniao = $_POST['opniao'];
		$id_serie = $_GET['id_serie'];

		$salvar_opniao_filme = $pdo->prepare("UPDATE listaSerie SET bom_ruim=? WHERE serie_id=?");
		$salvar_opniao_filme->execute(array($opniao,$id_serie));

				if($salvar_opniao_filme == true){
					echo "<script language = 'javascript'> window.alert('Opnião Salva');
					window.location.href = 'listaSerie.php?pg=listaSeries&id_cliente=$id_cliente'</script>";
				}
		}

	?>
	<form method="POST" enctype="multipart/form-data">
		<div class="form-row">
			<div class="form-group col-md-1">
				<label for="inputState">Votar</label>
				<select id="inputState" class="form-control" required name="opniao">
					<option value="Bom">Bom</option>
					<option value="Ruim">Ruim</option>
				</select>
			</div>
			<div class="form-group col-md-4  pesquisarFilme">
				<button type="submit" class="btn btn-success enviarOpniao" name="enviar">Enviar</button>
			</div>
			
		</div>				
	</form>

<?php } ?>
	
<!--OPNIAO FILMES---------------------------------------------------------------------------------------------->
	</div>
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>