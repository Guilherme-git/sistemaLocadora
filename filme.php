<?php 
	include 'conexao.php';

	$bsucar_todos_filmes = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria ON `filme`.`categoria_id` = `categoria`.`id_categoria`");
	$bsucar_todos_filmes->execute();
	$res_buscar_todos_filmes = $bsucar_todos_filmes->fetchAll();


	$buscar_todas_categorias = $pdo->prepare("SELECT * FROM categoria");
	$buscar_todas_categorias->execute();
	$res_buscar_todas_categorias = $buscar_todas_categorias->fetchAll();

	if(isset($_POST['pesquisar'])){
		$categoria = $_POST['categoria'];

		echo "<script>window.location.href = 'filme.php?pg=pesquisa&id_categoria=$categoria'</script>";
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
	       	 <a class="nav-link" href="index.php">Início</a>
	      	</li>
	      	<li class="nav-item active">
	        	<a class="nav-link" href="filme.php?pg=listaFilmes">Filmes</a>
	      	</li>
	     	 <li class="nav-item ">
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

	
<!--MOSTRAR FILMES---------------------------------------------------------------------------------------------->
<div class="container">
<?php
	if(@$_GET['pg'] == 'listaFilmes'){
?>
	
		<form method="POST" enctype="multipart/form-data">
				<div class="form-row">
				    <div class="form-group col-md-6 lista">
				        <label for="inputEmail4"><h3>Lista de Filmes</h3></label>
					</div>

				    <div class="form-group col-md-4">
				      <label for="inputState">Pesquisar</label>
				      	<select id="inputState" class="form-control" name="categoria">
				      		 <?php 
					      		foreach ($res_buscar_todas_categorias as $key => $value) {
					      			$id_categoria = $value['id_categoria'];
					      			$nome_categoria = $value['nome_categoria'];
				      		?>
					        <option value="<?php echo $id_categoria; ?>"><?php echo $nome_categoria; ?></option>
					    	<?php } ?>
				      	</select>
				    </div>

				    <div class="form-group col-md-2 pesquisarSerie">
				      	<button type="submit" class="btn btn-dark pesquisar" name="pesquisar">Pesquisar</button>
					</div>
				</div>
				<hr>
		</form>

		<table class="table">
			<thead>
			    <tr>
			      <th scope="col">Nome</th>
			      <th scope="col">Classificação</th>
			      <th scope="col">Categoria</th>
			    </tr>
			</thead>
			<tbody>
				<?php
					foreach ($res_buscar_todos_filmes as $key => $value) {
						$nome_filme = $value['nome_filme'];
						$classificacao_filme = $value['classificacao_filme'];
						$categoria_filme = $value['nome_categoria'];
				?>
			    <tr>
			      <td><?php echo $nome_filme; ?></td>
			      <td><?php echo $classificacao_filme; ?></td>
			      <td><?php echo $categoria_filme; ?></td>
			    </tr>
				<?php } ?>
			</tbody>
		</table>
	
<?php } ?>
<!--MOSTRAR FILMES---------------------------------------------------------------------------------------------->


<!--PESQUISAR FILMES---------------------------------------------------------------------------------------------->
<?php
	if(@$_GET['pg'] == 'pesquisa'){
		$id_categoria = $_GET['id_categoria'];

		$pesquisar_filme_categoria = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria WHERE categoria_id=? 
		AND `filme`.`categoria_id` = `categoria`.`id_categoria`");
		$pesquisar_filme_categoria->execute(array($id_categoria));

		$res_pesquisar_filme_categoria = $pesquisar_filme_categoria->fetchAll();

		foreach ($res_pesquisar_filme_categoria as $key => $value) {
				$id_categoria = $value['id_categoria'];
				$nome_categoria = $value['nome_categoria'];
		}

		if($res_pesquisar_filme_categoria == null){
			echo "<script>window.alert('Não existe filmes nessa categoria');
				window.location.href = 'filme.php?pg=listaFilmes'</script>";
		}else{
?>
		<form method="POST" enctype="multipart/form-data">
				<div class="form-row">
				    <div class="form-group col-md-6 lista">
				        <label for="inputEmail4"><h3>Lista de Filmes de <?php echo $nome_categoria; ?></h3></label>
					</div>

				    <div class="form-group col-md-4">
				      <label for="inputState">Pesquisar</label>
				      	<select id="inputState" class="form-control" name="categoria">
				      		 <?php 
					      		foreach ($res_buscar_todas_categorias as $key => $value) {
					      			$id_categoria = $value['id_categoria'];
					      			$nome_categoria = $value['nome_categoria'];
				      		?>
					        <option value="<?php echo $id_categoria; ?>"><?php echo $nome_categoria; ?></option>
					    	<?php } ?>
				      	</select>
				    </div>

				    <div class="form-group col-md-2 pesquisarFilme">
				      	<button type="submit" class="btn btn-dark pesquisar" name="pesquisar">Pesquisar</button>
					</div>
				</div>
				<hr>
			</form>

				<table class="table">
					<thead>
					    <tr>
					      <th scope="col">Nome</th>
					      <th scope="col">Classificação</th>
					      <th scope="col">Categoria</th>
					    </tr>
					</thead>
					<tbody>
						<?php
							foreach ($res_pesquisar_filme_categoria as $key => $value) {
								$nome_filme = $value['nome_filme'];
								$categoria_filme = $value['nome_categoria'];
								$classificacao_filme = $value['classificacao_filme'];
							
						?>			
					    <tr>
					      <td><?php echo $nome_filme; ?></td>
					      <td><?php echo $classificacao_filme; ?></td>
					      <td><?php echo $categoria_filme; ?></td>
					    </tr>
						<?php } ?>
					</tbody>
				</table>
<?php } } ?>
<!--PESQUISAR FILMES---------------------------------------------------------------------------------------------->
</div>
	
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>