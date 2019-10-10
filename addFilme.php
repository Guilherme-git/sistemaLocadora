<?php
	include 'conexao.php';
        

	$id_cliente = $_GET['id_cliente'];

	$selecionar_cliente = $pdo->prepare("SELECT * FROM cliente INNER JOIN plano WHERE id_cliente=?
	AND `cliente`.`plano_id` = `plano`.`id_plano`");
	$selecionar_cliente->execute(array($id_cliente));
	$res_selecionar_cliente = $selecionar_cliente->fetchAll();

	$sql_categoria = $pdo->prepare("SELECT * FROM categoria");
	$sql_categoria->execute();
	$res_categoria = $sql_categoria->fetchAll();

	$selecionar_lista_filme = $pdo->prepare("SELECT * FROM listafilme  WHERE cliente_id=?");
	$selecionar_lista_filme->execute(array($id_cliente));
	$res_selecionar_lista_filme = $selecionar_lista_filme->fetchAll();

	$selecionar_lista_serie = $pdo->prepare("SELECT * FROM listaserie WHERE cliente_id=?");
	$selecionar_lista_serie->execute(array($id_cliente));
	$res_selecionar_lista_serie = $selecionar_lista_serie->fetchAll();


	foreach ($res_selecionar_cliente as $key => $value) {
		$nome_plano = $value['nome_plano'];
	}

	
	if(isset($_POST['pesquisarFilmeLivre'])){
		$categoria = $_POST['categoria'];
		echo "<script>window.location.href = 'addFilme.php?pg=pesquisaFilmeLivre&id_categoria=$categoria&id_cliente=$id_cliente'</script>";

	}

	if(isset(($_POST['pesquisarTodosFilme']))){
		$categoria = $_POST['categoria'];
		echo "<script>window.location.href = 'addFilme.php?pg=pesquisaTodosFilme&id_categoria=$categoria&id_cliente=$id_cliente'</script>";
	}
	
	if(isset($_POST['pesquisarFilmes10'])){
		$categoria = $_POST['categoria'];
		echo "<script>window.location.href = 'addFilme.php?pg=pesquisaFilme10&id_categoria=$categoria&id_cliente=$id_cliente'</script>";
	}

	if(isset($_POST['pesquisarFilmes12'])){
		$categoria = $_POST['categoria'];
		echo "<script>window.location.href = 'addFilme.php?pg=pesquisaFilme12&id_categoria=$categoria&id_cliente=$id_cliente'</script>";
	}

	if(isset($_POST['pesquisarFilmes14'])){
		$categoria = $_POST['categoria'];
		echo "<script>window.location.href = 'addFilme.php?pg=pesquisaFilme14&id_categoria=$categoria&id_cliente=$id_cliente'</script>";
	}

	if(isset($_POST['pesquisarFilmes16'])){
		$categoria = $_POST['categoria'];
		echo "<script>window.location.href = 'addFilme.php?pg=pesquisaFilme16&id_categoria=$categoria&id_cliente=$id_cliente'</script>";
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

<div class="container">


<!--MOSTRANDO TODOS OS FILMES LIVRE----------------------------------------------------------------------------------------------------->
<?php 
	if(@$_GET['pg'] =='filmesLivre'){
	$selecionar_todos_filmes_Livre = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria  WHERE classificacao_filme ='Livre'
	AND `filme`.`categoria_id`=`categoria`.`id_categoria`");
	$selecionar_todos_filmes_Livre->execute();
	$res_selecionar_todos_filmes_Livre = $selecionar_todos_filmes_Livre->fetchAll();
		
?>
	 <form method="POST" enctype="multipart/form-data">
		<div class="form-row">
			<div class="form-group col-md-4">
				<label for="inputState">Pesquisar</label>
				<select id="inputState" class="form-control" name="categoria">
					<?php 
						foreach ($res_categoria as $key => $value) {
						$id_categoria = $value['id_categoria'];
						$nome_categoria = $value['nome_categoria'];
					?>
						<option value="<?php echo $id_categoria; ?>"><?php echo $nome_categoria; ?></option>
						<?php } ?>
				</select>
			</div> 
			<div class="form-group col-md-2 pesquisarFilme">
				<button type="submit" class="btn btn-success pesquisar" name="pesquisarFilmeLivre">Pesquisar</button>
			</div>
			<div class="form-group col-md-6 pesquisarFilme">
				<i>Lista de filmes recomendados de acordo com sua idade</i>
			</div>
		</div>
	</form>
	
	<table class="table">
		<thead>
			<tr>
				<th scope="col">Nome</th>
				<th scope="col">Categoria</th>
				<th scope="col">Classificação</th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ($res_selecionar_todos_filmes_Livre as $key => $value) {
					$id_filme = $value['id_filme'];
					$nome_filme = $value['nome_filme'];
					$classificacao_filme = $value['classificacao_filme'];
					$categoria_filme = $value['nome_categoria'];
			?>
			<tr>
				<td><?php echo $nome_filme; ?></td>
				<td><?php echo $categoria_filme; ?></td>
				<td><?php echo $classificacao_filme; ?></td>
				 <td>
				 	<a href="addFilme.php?pg=addLista&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addFilme.php?pg=favorito&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoFilmePDF.php?id_filme=<?php echo $id_filme; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			<?php } ?>
			 </tr>

		</tbody>
	</table>
	<?php } ?>
<!--MOSTRANDO TODOS OS FILMES LIVRES----------------------------------------------------------------------------------------------------->

<!--MOSTRANDO PESQUISA OS FILMES LIVRES----------------------------------------------------------------------------------------------------->
	<?php
		if(@$_GET['pg'] == 'pesquisaFilmeLivre'){
			$id_categoria = $_GET['id_categoria'];

			$pesquisa_filme_livre = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria WHERE classificacao_filme='Livre'
			AND categoria_id=? AND `filme`.`categoria_id` = `categoria`.`id_categoria`");
			$pesquisa_filme_livre->execute(array($id_categoria));

			$res_pesquisa_filme_livre = $pesquisa_filme_livre->fetchAll();
			
			if($res_pesquisa_filme_livre == null){
				echo "<script>window.alert('Não existe filmes nessa categoria');
				window.location.href = 'addFilme.php?pg=filmesLivre&id_cliente=$id_cliente'</script>";
			}else{
	?>

		 <form method="POST" enctype="multipart/form-data">
		<div class="form-row">
			<div class="form-group col-md-4">
				<label for="inputState">Pesquisar</label>
				<select id="inputState" class="form-control" name="categoria">
					<?php 
						foreach ($res_categoria as $key => $value) {
						$id_categoria = $value['id_categoria'];
						$nome_categoria = $value['nome_categoria'];
					?>
						<option value="<?php echo $id_categoria; ?>"><?php echo $nome_categoria; ?></option>
						<?php } ?>
				</select>
			</div> 
			<div class="form-group col-md-2 pesquisarFilme">
				<button type="submit" class="btn btn-success pesquisar" name="pesquisarFilmeLivre">Pesquisar</button>
			</div>
			<div class="form-group col-md-6 pesquisarFilme">
				<i>Lista de filmes recomendados de acordo com sua idade</i>
			</div>
		</div>
	</form>
	
	<table class="table">
		<thead>
			<tr>
				<th scope="col">Nome</th>
				<th scope="col">Categoria</th>
				<th scope="col">Classificação</th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ($res_pesquisa_filme_livre as $key => $value) {
					$id_filme = $value['id_filme'];
					$nome_filme = $value['nome_filme'];
					$classificacao_filme = $value['classificacao_filme'];
					$categoria_filme = $value['nome_categoria'];
			?>
			<tr>
				<td><?php echo $nome_filme; ?></td>
				<td><?php echo $categoria_filme; ?></td>
				<td><?php echo $classificacao_filme; ?></td>
				 <td>
				 	<a href="addFilme.php?pg=addLista&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addFilme.php?pg=favorito&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoFilmePDF.php?id_filme=<?php echo $id_filme; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			<?php } ?>
			 </tr>

		</tbody>
	</table>
	<?php } } ?>
<!--MOSTRANDO PESQUISA OS FILMES LIVRES----------------------------------------------------------------------------------------------------->







<!--MOSTRANDO TODOS OS FILMES----------------------------------------------------------------------------------------------------->
<?php 
	if(@$_GET['pg'] =='todosFilmes'){
	$selecionar_todos_filmes = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria ON `filme`.`categoria_id`=`categoria`.`id_categoria`");
	$selecionar_todos_filmes->execute();
	$res_selecionar_todos_filmes = $selecionar_todos_filmes->fetchAll();
		
?>
	 <form method="POST" enctype="multipart/form-data">
		<div class="form-row">
			<div class="form-group col-md-4">
				<label for="inputState">Pesquisar</label>
				<select id="inputState" class="form-control" name="categoria">
					<?php 
						foreach ($res_categoria as $key => $value) {
						$id_categoria = $value['id_categoria'];
						$nome_categoria = $value['nome_categoria'];
					?>
						<option value="<?php echo $id_categoria; ?>"><?php echo $nome_categoria; ?></option>
						<?php } ?>
				</select>
			</div> 
			<div class="form-group col-md-2 pesquisarFilme">
				<button type="submit" class="btn btn-success pesquisar" name="pesquisarTodosFilme">Pesquisar</button>
			</div>
		</div>
	</form>
	
	<table class="table">
		<thead>
			<tr>
				<th scope="col">Nome</th>
				<th scope="col">Categoria</th>
				<th scope="col">Classificação</th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ($res_selecionar_todos_filmes as $key => $value) {
					$id_filme = $value['id_filme'];
					$nome_filme = $value['nome_filme'];
					$classificacao_filme = $value['classificacao_filme'];
					$categoria_filme = $value['nome_categoria'];
			?>
			<tr>
				<td><?php echo $nome_filme; ?></td>
				<td><?php echo $categoria_filme; ?></td>
				<td><?php echo $classificacao_filme; ?></td>
				 <td>
				 	<a href="addFilme.php?pg=addLista&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addFilme.php?pg=favorito&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoFilmePDF.php?id_filme=<?php echo $id_filme; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			<?php } ?>
			 </tr>

		</tbody>
	</table>
	<?php } ?>
<!--MOSTRANDO TODOS OS FILMES----------------------------------------------------------------------------------------------------->

<!--MOSTRANDO PESQUISA TODOS OS FILMES----------------------------------------------------------------------------------------------------->
	<?php
		if(@$_GET['pg'] == 'pesquisaTodosFilme'){
			$id_categoria = $_GET['id_categoria'];

			$pesquisa_todos_filmes = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria WHERE categoria_id=?
			AND `filme`.`categoria_id`=`categoria`.`id_categoria`");
			$pesquisa_todos_filmes->execute(array($id_categoria));
			$res_pesquisa_todos_filmes = $pesquisa_todos_filmes->fetchAll();

			if($res_pesquisa_todos_filmes == null){
				echo "<script>window.alert('Não existe filmes nessa categoria');
				window.location.href = 'addFilme.php?pg=todosFilmes&id_cliente=$id_cliente'</script>";
			}else{
	?>
		<form method="POST" enctype="multipart/form-data">
		<div class="form-row">
			<div class="form-group col-md-4">
				<label for="inputState">Pesquisar</label>
				<select id="inputState" class="form-control" name="categoria">
					<?php 
						foreach ($res_categoria as $key => $value) {
						$id_categoria = $value['id_categoria'];
						$nome_categoria = $value['nome_categoria'];
					?>
						<option value="<?php echo $id_categoria; ?>"><?php echo $nome_categoria; ?></option>
						<?php } ?>
				</select>
			</div> 
			<div class="form-group col-md-2 pesquisarFilme">
				<button type="submit" class="btn btn-success pesquisar" name="pesquisarTodosFilme">Pesquisar</button>
			</div>
		</div>
	</form>
	
	<table class="table">
		<thead>
			<tr>
				<th scope="col">Nome</th>
				<th scope="col">Categoria</th>
				<th scope="col">Classificação</th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ($res_pesquisa_todos_filmes as $key => $value) {
					$id_filme = $value['id_filme'];
					$nome_filme = $value['nome_filme'];
					$classificacao_filme = $value['classificacao_filme'];
					$categoria_filme = $value['nome_categoria'];
			?>
			<tr>
				<td><?php echo $nome_filme; ?></td>
				<td><?php echo $categoria_filme; ?></td>
				<td><?php echo $classificacao_filme; ?></td>
				 <td>
				 	<a href="addFilme.php?pg=addLista&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addFilme.php?pg=favorito&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoFilmePDF.php?id_filme=<?php echo $id_filme; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			<?php } ?>
			 </tr>

		</tbody>
	</table>

	<?php } } ?>

<!--MOSTRANDO PESQUISA TODOS OS FILMES----------------------------------------------------------------------------------------------------->





<!--MOSTRANDO FILMES 10----------------------------------------------------------------------------------------------------->
	<?php
		if(@$_GET['pg'] == 'filmes10'){
	$selecionar_filmes_10 = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria WHERE classificacao_filme=10
	 AND `filme`.`categoria_id`=`categoria`.`id_categoria`");
	$selecionar_filmes_10->execute();
	$res_selecionar_filmes_10 = $selecionar_filmes_10->fetchAll();


	$selecionar_filmes_Livre = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria WHERE classificacao_filme='Livre'
	 AND `filme`.`categoria_id`=`categoria`.`id_categoria`");
	$selecionar_filmes_Livre->execute();
	$res_selecionar_filmes_Livre = $selecionar_filmes_Livre->fetchAll();
		
?>
	 <form method="POST" enctype="multipart/form-data">
		<div class="form-row">
			<div class="form-group col-md-4">
				<label for="inputState">Pesquisar</label>
				<select id="inputState" class="form-control" name="categoria">
					<?php 
						foreach ($res_categoria as $key => $value) {
						$id_categoria = $value['id_categoria'];
						$nome_categoria = $value['nome_categoria'];
					?>
						<option value="<?php echo $id_categoria; ?>"><?php echo $nome_categoria; ?></option>
						<?php } ?>
				</select>
			</div> 
			<div class="form-group col-md-2 pesquisarFilme">
				<button type="submit" class="btn btn-success pesquisar" name="pesquisarFilmes10">Pesquisar</button>
			</div>
			<div class="form-group col-md-6 pesquisarFilme">
				<i>Lista de filmes recomendados de acordo com sua idade</i>
			</div>
		</div>
	</form>
	
	<table class="table">
		<thead>
			<tr>
				<th scope="col">Nome</th>
				<th scope="col">Categoria</th>
				<th scope="col">Classificação</th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ($res_selecionar_filmes_Livre as $key => $value) {
					$id_filme = $value['id_filme'];
					$nome_filme = $value['nome_filme'];
					$classificacao_filme = $value['classificacao_filme'];
					$categoria_filme = $value['nome_categoria'];
			?>
			<tr>
				<td><?php echo $nome_filme; ?></td>
				<td><?php echo $categoria_filme; ?></td>
				<td><?php echo $classificacao_filme; ?></td>
				 <td>
				 	<a href="addFilme.php?pg=addLista&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addFilme.php?pg=favorito&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoFilmePDF.php?id_filme=<?php echo $id_filme; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_selecionar_filmes_10 as $key => $value) {
					$id_filme = $value['id_filme'];
					$nome_filme = $value['nome_filme'];
					$classificacao_filme = $value['classificacao_filme'];
					$categoria_filme = $value['nome_categoria'];
				
			?>
			<tr>
				<td><?php echo $nome_filme; ?></td>
				<td><?php echo $categoria_filme; ?></td>
				<td><?php echo $classificacao_filme; ?></td>
				 <td>
				 	<a href="addFilme.php?pg=addLista&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addFilme.php?pg=favorito&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoFilmePDF.php?id_filme=<?php echo $id_filme; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } ?>
<!--MOSTRANDO FILMES 10-------------------------------------------------------------------------------------------------->


<!--MOSTRANDO PESQUISA FILMES 10----------------------------------------------------------------------------------------------------->
	<?php
		if(@$_GET['pg'] == 'pesquisaFilme10'){
			$id_categoria = $_GET['id_categoria'];

			$pesquisa_filmes_10_Livre = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria WHERE categoria_id=? 
			AND classificacao_filme='Livre' AND `filme`.`categoria_id`=`categoria`.`id_categoria`");
			$pesquisa_filmes_10_Livre->execute(array($id_categoria));
			$res_pesquisa_filmes_10_Livre = $pesquisa_filmes_10_Livre->fetchAll();


			$pesquisa_filmes_10 = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria WHERE categoria_id=? 
			AND classificacao_filme=10 AND `filme`.`categoria_id`=`categoria`.`id_categoria`");
			$pesquisa_filmes_10->execute(array($id_categoria));
			$res_pesquisa_filmes_10 = $pesquisa_filmes_10->fetchAll();


			if($res_pesquisa_filmes_10_Livre == null && $res_pesquisa_filmes_10 == null){
				echo "<script>window.alert('Não existe filmes nessa categoria');
				window.location.href = 'addFilme.php?pg=filmes10&id_cliente=$id_cliente'</script>";
			}else{
	?>
		<form method="POST" enctype="multipart/form-data">
		<div class="form-row">
			<div class="form-group col-md-4">
				<label for="inputState">Pesquisar</label>
				<select id="inputState" class="form-control" name="categoria">
					<?php 
						foreach ($res_categoria as $key => $value) {
						$id_categoria = $value['id_categoria'];
						$nome_categoria = $value['nome_categoria'];
					?>
						<option value="<?php echo $id_categoria; ?>"><?php echo $nome_categoria; ?></option>
						<?php } ?>
				</select>
			</div> 
			<div class="form-group col-md-2 pesquisarFilme pesquisar">
				<button type="submit" class="btn btn-success" name="pesquisarFilmes10">Pesquisar</button>
			</div>
			<div class="form-group col-md-6 pesquisarFilme">
				<i>Lista de filmes recomendados de acordo com sua idade</i>
			</div>
		</div>
	</form>
	
	<table class="table">
		<thead>
			<tr>
				<th scope="col">Nome</th>
				<th scope="col">Categoria</th>
				<th scope="col">Classificação</th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ($res_pesquisa_filmes_10_Livre as $key => $value) {
					$id_filme = $value['id_filme'];
					$nome_filme_livre = $value['nome_filme'];
					$classificacao_filme_livre = $value['classificacao_filme'];
					$categoria_filme_livre = $value['nome_categoria'];
			?>
			<tr>
				<td><?php echo $nome_filme_livre; ?></td>
				<td><?php echo $categoria_filme_livre; ?></td>
				<td><?php echo $classificacao_filme_livre; ?></td>
				 <td>
				 	<a href="addFilme.php?pg=addLista&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addFilme.php?pg=favorito&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoFilmePDF.php?id_filme=<?php echo $id_filme; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_pesquisa_filmes_10 as $key => $value) {
					$id_filme = $value['id_filme'];
					$nome_filme = $value['nome_filme'];
					$classificacao_filme = $value['classificacao_filme'];
					$categoria_filme = $value['nome_categoria'];
				
			?>
			<tr>
				<td><?php echo $nome_filme; ?></td>
				<td><?php echo $categoria_filme; ?></td>
				<td><?php echo $classificacao_filme; ?></td>
				 <td>
				 	<a href="addFilme.php?pg=addLista&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addFilme.php?pg=favorito&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoFilmePDF.php?id_filme=<?php echo $id_filme; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } }?>
<!--MOSTRANDO PESQUISA FILMES 10----------------------------------------------------------------------------------------------------->







<!--MOSTRANDO FILMES 12----------------------------------------------------------------------------------------------------->
	<?php
		if(@$_GET['pg'] == 'filmes12'){
	$selecionar_filmes_10 = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria WHERE classificacao_filme=10
	 AND `filme`.`categoria_id`=`categoria`.`id_categoria`");
	$selecionar_filmes_10->execute();
	$res_selecionar_filmes_10 = $selecionar_filmes_10->fetchAll();


	$selecionar_filmes_Livre = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria WHERE classificacao_filme='Livre'
	 AND `filme`.`categoria_id`=`categoria`.`id_categoria`");
	$selecionar_filmes_Livre->execute();
	$res_selecionar_filmes_Livre = $selecionar_filmes_Livre->fetchAll();


	$selecionar_filmes_12 = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria WHERE classificacao_filme=12
	 AND `filme`.`categoria_id`=`categoria`.`id_categoria`");
	$selecionar_filmes_12->execute();
	$res_selecionar_filmes_12 = $selecionar_filmes_12->fetchAll();
		
?>
	 <form method="POST" enctype="multipart/form-data">
		<div class="form-row">
			<div class="form-group col-md-4">
				<label for="inputState">Pesquisar</label>
				<select id="inputState" class="form-control" name="categoria">
					<?php 
						foreach ($res_categoria as $key => $value) {
						$id_categoria = $value['id_categoria'];
						$nome_categoria = $value['nome_categoria'];
					?>
						<option value="<?php echo $id_categoria; ?>"><?php echo $nome_categoria; ?></option>
						<?php } ?>
				</select>
			</div> 
			<div class="form-group col-md-2 pesquisarFilme">
				<button type="submit" class="btn btn-success pesquisar" name="pesquisarFilmes12">Pesquisar</button>
			</div>
			<div class="form-group col-md-6 pesquisarFilme">
				<i>Lista de filmes recomendados de acordo com sua idade</i>
			</div>
		</div>
	</form>
	
	<table class="table">
		<thead>
			<tr>
				<th scope="col">Nome</th>
				<th scope="col">Categoria</th>
				<th scope="col">Classificação</th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ($res_selecionar_filmes_Livre as $key => $value) {
					$id_filme = $value['id_filme'];
					$nome_filme = $value['nome_filme'];
					$classificacao_filme = $value['classificacao_filme'];
					$categoria_filme = $value['nome_categoria'];
			?>
			<tr>
				<td><?php echo $nome_filme; ?></td>
				<td><?php echo $categoria_filme; ?></td>
				<td><?php echo $classificacao_filme; ?></td>
				 <td>
				 	<a href="addFilme.php?pg=addLista&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addFilme.php?pg=favorito&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoFilmePDF.php?id_filme=<?php echo $id_filme; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_selecionar_filmes_10 as $key => $value) {
					$id_filme = $value['id_filme'];
					$nome_filme = $value['nome_filme'];
					$classificacao_filme = $value['classificacao_filme'];
					$categoria_filme = $value['nome_categoria'];
				
			?>
			<tr>
				<td><?php echo $nome_filme; ?></td>
				<td><?php echo $categoria_filme; ?></td>
				<td><?php echo $classificacao_filme; ?></td>
				 <td>
				 	<a href="addFilme.php?pg=addLista&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addFilme.php?pg=favorito&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoFilmePDF.php?id_filme=<?php echo $id_filme; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_selecionar_filmes_12 as $key => $value) {
					$id_filme = $value['id_filme'];
					$nome_filme = $value['nome_filme'];
					$classificacao_filme = $value['classificacao_filme'];
					$categoria_filme = $value['nome_categoria'];
				
			?>
			<tr>
				<td><?php echo $nome_filme; ?></td>
				<td><?php echo $categoria_filme; ?></td>
				<td><?php echo $classificacao_filme; ?></td>
				 <td>
				 	<a href="addFilme.php?pg=addLista&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addFilme.php?pg=favorito&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoFilmePDF.php?id_filme=<?php echo $id_filme; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } ?>
<!--MOSTRANDO FILMES 12-------------------------------------------------------------------------------------------------->

<!--MOSTRANDO PESQUISA FILMES 12-------------------------------------------------------------------------------------------------->
	<?php
		if(@$_GET['pg'] == 'pesquisaFilme12'){
			$id_categoria = $_GET['id_categoria'];

			$pesquisa_filmes_12_Livre = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria WHERE categoria_id=? 
			AND classificacao_filme='Livre' AND `filme`.`categoria_id`=`categoria`.`id_categoria`");
			$pesquisa_filmes_12_Livre->execute(array($id_categoria));
			$res_pesquisa_filmes_12_Livre = $pesquisa_filmes_12_Livre->fetchAll();


			$pesquisa_filmes_12_10 = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria WHERE categoria_id=? 
			AND classificacao_filme=10 AND `filme`.`categoria_id`=`categoria`.`id_categoria`");
			$pesquisa_filmes_12_10->execute(array($id_categoria));
			$res_pesquisa_filmes_12_10 = $pesquisa_filmes_12_10->fetchAll();

			$pesquisa_filmes_12 = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria WHERE categoria_id=? 
			AND classificacao_filme=12 AND `filme`.`categoria_id`=`categoria`.`id_categoria`");
			$pesquisa_filmes_12->execute(array($id_categoria));
			$res_pesquisa_filmes_12 = $pesquisa_filmes_12->fetchAll();

			if($res_pesquisa_filmes_12_Livre == null && $res_pesquisa_filmes_12_10 == null && $res_pesquisa_filmes_12 == null){
				echo "<script>window.alert('Não existe filmes nessa categoria');
				window.location.href = 'addFilme.php?pg=filmes12&id_cliente=$id_cliente'</script>";
			}else{

	?>
		 <form method="POST" enctype="multipart/form-data">
		<div class="form-row">
			<div class="form-group col-md-4">
				<label for="inputState">Pesquisar</label>
				<select id="inputState" class="form-control" name="categoria">
					<?php 
						foreach ($res_categoria as $key => $value) {
						$id_categoria = $value['id_categoria'];
						$nome_categoria = $value['nome_categoria'];
					?>
						<option value="<?php echo $id_categoria; ?>"><?php echo $nome_categoria; ?></option>
						<?php } ?>
				</select>
			</div> 
			<div class="form-group col-md-2 pesquisarFilme">
				<button type="submit" class="btn btn-success pesquisar" name="pesquisarFilmes12">Pesquisar</button>
			</div>
			<div class="form-group col-md-6 pesquisarFilme">
				<i>Lista de filmes recomendados de acordo com sua idade</i>
			</div>
		</div>
	</form>
	
	<table class="table">
		<thead>
			<tr>
				<th scope="col">Nome</th>
				<th scope="col">Categoria</th>
				<th scope="col">Classificação</th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ($res_pesquisa_filmes_12_Livre as $key => $value) {
					$id_filme = $value['id_filme'];
					$nome_filme = $value['nome_filme'];
					$classificacao_filme = $value['classificacao_filme'];
					$categoria_filme = $value['nome_categoria'];
			?>
			<tr>
				<td><?php echo $nome_filme; ?></td>
				<td><?php echo $categoria_filme; ?></td>
				<td><?php echo $classificacao_filme; ?></td>
				 <td>
				 	<a href="addFilme.php?pg=addLista&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addFilme.php?pg=favorito&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoFilmePDF.php?id_filme=<?php echo $id_filme; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_pesquisa_filmes_12_10 as $key => $value) {
					$id_filme = $value['id_filme'];
					$nome_filme = $value['nome_filme'];
					$classificacao_filme = $value['classificacao_filme'];
					$categoria_filme = $value['nome_categoria'];
				
			?>
			<tr>
				<td><?php echo $nome_filme; ?></td>
				<td><?php echo $categoria_filme; ?></td>
				<td><?php echo $classificacao_filme; ?></td>
				 <td>
				 	<a href="addFilme.php?pg=addLista&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addFilme.php?pg=favorito&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoFilmePDF.php?id_filme=<?php echo $id_filme; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_pesquisa_filmes_12 as $key => $value) {
					$id_filme = $value['id_filme'];
					$nome_filme = $value['nome_filme'];
					$classificacao_filme = $value['classificacao_filme'];
					$categoria_filme = $value['nome_categoria'];
				
			?>
			<tr>
				<td><?php echo $nome_filme; ?></td>
				<td><?php echo $categoria_filme; ?></td>
				<td><?php echo $classificacao_filme; ?></td>
				 <td>
				 	<a href="addFilme.php?pg=addLista&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addFilme.php?pg=favorito&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoFilmePDF.php?id_filme=<?php echo $id_filme; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } }?>
<!--MOSTRANDO PESQUISA FILMES 12-------------------------------------------------------------------------------------------------->







<!--MOSTRANDO FILMES 14----------------------------------------------------------------------------------------------------->
	<?php
		if(@$_GET['pg'] == 'filmes14'){
	$selecionar_filmes_10 = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria WHERE classificacao_filme=10
	 AND `filme`.`categoria_id`=`categoria`.`id_categoria`");
	$selecionar_filmes_10->execute();
	$res_selecionar_filmes_10 = $selecionar_filmes_10->fetchAll();


	$selecionar_filmes_Livre = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria WHERE classificacao_filme='Livre'
	 AND `filme`.`categoria_id`=`categoria`.`id_categoria`");
	$selecionar_filmes_Livre->execute();
	$res_selecionar_filmes_Livre = $selecionar_filmes_Livre->fetchAll();


	$selecionar_filmes_12 = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria WHERE classificacao_filme=12
	 AND `filme`.`categoria_id`=`categoria`.`id_categoria`");
	$selecionar_filmes_12->execute();
	$res_selecionar_filmes_12 = $selecionar_filmes_12->fetchAll();

	$selecionar_filmes_14 = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria WHERE classificacao_filme=14
	 AND `filme`.`categoria_id`=`categoria`.`id_categoria`");
	$selecionar_filmes_14->execute();
	$res_selecionar_filmes_14 = $selecionar_filmes_14->fetchAll();
		
?>
	 <form method="POST" enctype="multipart/form-data">
		<div class="form-row">
			<div class="form-group col-md-4">
				<label for="inputState">Pesquisar</label>
				<select id="inputState" class="form-control" name="categoria">
					<?php 
						foreach ($res_categoria as $key => $value) {
						$id_categoria = $value['id_categoria'];
						$nome_categoria = $value['nome_categoria'];
					?>
						<option value="<?php echo $id_categoria; ?>"><?php echo $nome_categoria; ?></option>
						<?php } ?>
				</select>
			</div> 
			<div class="form-group col-md-2 pesquisarFilme">
				<button type="submit" class="btn btn-success pesquisar" name="pesquisarFilmes14">Pesquisar</button>
			</div>
			<div class="form-group col-md-6 pesquisarFilme">
				<i>Lista de filmes recomendados de acordo com sua idade</i>
			</div>
		</div>
	</form>
	
	<table class="table">
		<thead>
			<tr>
				<th scope="col">Nome</th>
				<th scope="col">Categoria</th>
				<th scope="col">Classificação</th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ($res_selecionar_filmes_Livre as $key => $value) {
					$id_filme = $value['id_filme'];
					$nome_filme = $value['nome_filme'];
					$classificacao_filme = $value['classificacao_filme'];
					$categoria_filme = $value['nome_categoria'];
			?>
			<tr>
				<td><?php echo $nome_filme; ?></td>
				<td><?php echo $categoria_filme; ?></td>
				<td><?php echo $classificacao_filme; ?></td>
				 <td>
				 	<a href="addFilme.php?pg=addLista&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addFilme.php?pg=favorito&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoFilmePDF.php?id_filme=<?php echo $id_filme; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_selecionar_filmes_10 as $key => $value) {
					$id_filme = $value['id_filme'];
					$nome_filme = $value['nome_filme'];
					$classificacao_filme = $value['classificacao_filme'];
					$categoria_filme = $value['nome_categoria'];
				
			?>
			<tr>
				<td><?php echo $nome_filme; ?></td>
				<td><?php echo $categoria_filme; ?></td>
				<td><?php echo $classificacao_filme; ?></td>
				 <td>
				 	<a href="addFilme.php?pg=addLista&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addFilme.php?pg=favorito&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoFilmePDF.php?id_filme=<?php echo $id_filme; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_selecionar_filmes_12 as $key => $value) {
					$id_filme = $value['id_filme'];
					$nome_filme = $value['nome_filme'];
					$classificacao_filme = $value['classificacao_filme'];
					$categoria_filme = $value['nome_categoria'];
				
			?>
			<tr>
				<td><?php echo $nome_filme; ?></td>
				<td><?php echo $categoria_filme; ?></td>
				<td><?php echo $classificacao_filme; ?></td>
				 <td>
				 	<a href="addFilme.php?pg=addLista&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addFilme.php?pg=favorito&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoFilmePDF.php?id_filme=<?php echo $id_filme; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_selecionar_filmes_14 as $key => $value) {
					$id_filme = $value['id_filme'];
					$nome_filme = $value['nome_filme'];
					$classificacao_filme = $value['classificacao_filme'];
					$categoria_filme = $value['nome_categoria'];
				
			?>
			<tr>
				<td><?php echo $nome_filme; ?></td>
				<td><?php echo $categoria_filme; ?></td>
				<td><?php echo $classificacao_filme; ?></td>
				 <td>
				 	<a href="addFilme.php?pg=addLista&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addFilme.php?pg=favorito&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoFilmePDF.php?id_filme=<?php echo $id_filme; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } ?>
<!--MOSTRANDO FILMES 14-------------------------------------------------------------------------------------------------->

<!--MOSTRANDO PESQUISA FILMES 14-------------------------------------------------------------------------------------------------->
	<?php
		if(@$_GET['pg'] == 'pesquisaFilme14'){
			$id_categoria = $_GET['id_categoria'];

			$pesquisa_filmes_14_Livre = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria WHERE categoria_id=? 
			AND classificacao_filme='Livre' AND `filme`.`categoria_id`=`categoria`.`id_categoria`");
			$pesquisa_filmes_14_Livre->execute(array($id_categoria));
			$res_pesquisa_filmes_14_Livre = $pesquisa_filmes_14_Livre->fetchAll();


			$pesquisa_filmes_14_10 = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria WHERE categoria_id=? 
			AND classificacao_filme=10 AND `filme`.`categoria_id`=`categoria`.`id_categoria`");
			$pesquisa_filmes_14_10->execute(array($id_categoria));
			$res_pesquisa_filmes_14_10 = $pesquisa_filmes_14_10->fetchAll();

			$pesquisa_filmes_14_12 = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria WHERE categoria_id=? 
			AND classificacao_filme=12 AND `filme`.`categoria_id`=`categoria`.`id_categoria`");
			$pesquisa_filmes_14_12->execute(array($id_categoria));
			$res_pesquisa_filmes_14_12 = $pesquisa_filmes_14_12->fetchAll();

			$pesquisa_filmes_14 = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria WHERE categoria_id=? 
			AND classificacao_filme=14 AND `filme`.`categoria_id`=`categoria`.`id_categoria`");
			$pesquisa_filmes_14->execute(array($id_categoria));
			$res_pesquisa_filmes_14 = $pesquisa_filmes_14->fetchAll();

			if($res_pesquisa_filmes_14_Livre == null && $res_pesquisa_filmes_14_10 == null && $res_pesquisa_filmes_14_12 == null
				&& $res_pesquisa_filmes_14 == null){
				echo "<script>window.alert('Não existe filmes nessa categoria');
				window.location.href = 'addFilme.php?pg=filmes14&id_cliente=$id_cliente'</script>";
			}else{
	?>
		 <form method="POST" enctype="multipart/form-data">
		<div class="form-row">
			<div class="form-group col-md-4">
				<label for="inputState">Pesquisar</label>
				<select id="inputState" class="form-control" name="categoria">
					<?php 
						foreach ($res_categoria as $key => $value) {
						$id_categoria = $value['id_categoria'];
						$nome_categoria = $value['nome_categoria'];
					?>
						<option value="<?php echo $id_categoria; ?>"><?php echo $nome_categoria; ?></option>
						<?php } ?>
				</select>
			</div> 
			<div class="form-group col-md-2 pesquisarFilme">
				<button type="submit" class="btn btn-success pesquisar" name="pesquisarFilmes14">Pesquisar</button>
			</div>
			<div class="form-group col-md-6 pesquisarFilme">
				<i>Lista de filmes recomendados de acordo com sua idade</i>
			</div>
		</div>
	</form>
	
	<table class="table">
		<thead>
			<tr>
				<th scope="col">Nome</th>
				<th scope="col">Categoria</th>
				<th scope="col">Classificação</th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ($res_pesquisa_filmes_14_Livre as $key => $value) {
					$id_filme = $value['id_filme'];
					$nome_filme = $value['nome_filme'];
					$classificacao_filme = $value['classificacao_filme'];
					$categoria_filme = $value['nome_categoria'];
			?>
			<tr>
				<td><?php echo $nome_filme; ?></td>
				<td><?php echo $categoria_filme; ?></td>
				<td><?php echo $classificacao_filme; ?></td>
				 <td>
				 	<a href="addFilme.php?pg=addLista&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addFilme.php?pg=favorito&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoFilmePDF.php?id_filme=<?php echo $id_filme; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_pesquisa_filmes_14_10 as $key => $value) {
					$id_filme = $value['id_filme'];
					$nome_filme = $value['nome_filme'];
					$classificacao_filme = $value['classificacao_filme'];
					$categoria_filme = $value['nome_categoria'];
				
			?>
			<tr>
				<td><?php echo $nome_filme; ?></td>
				<td><?php echo $categoria_filme; ?></td>
				<td><?php echo $classificacao_filme; ?></td>
				 <td>
				 	<a href="addFilme.php?pg=addLista&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addFilme.php?pg=favorito&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoFilmePDF.php?id_filme=<?php echo $id_filme; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_pesquisa_filmes_14_12 as $key => $value) {
					$id_filme = $value['id_filme'];
					$nome_filme = $value['nome_filme'];
					$classificacao_filme = $value['classificacao_filme'];
					$categoria_filme = $value['nome_categoria'];
				
			?>
			<tr>
				<td><?php echo $nome_filme; ?></td>
				<td><?php echo $categoria_filme; ?></td>
				<td><?php echo $classificacao_filme; ?></td>
				 <td>
				 	<a href="addFilme.php?pg=addLista&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addFilme.php?pg=favorito&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoFilmePDF.php?id_filme=<?php echo $id_filme; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_pesquisa_filmes_14 as $key => $value) {
					$id_filme = $value['id_filme'];
					$nome_filme = $value['nome_filme'];
					$classificacao_filme = $value['classificacao_filme'];
					$categoria_filme = $value['nome_categoria'];
				
			?>
			<tr>
				<td><?php echo $nome_filme; ?></td>
				<td><?php echo $categoria_filme; ?></td>
				<td><?php echo $classificacao_filme; ?></td>
				 <td>
				 	<a href="addFilme.php?pg=addFilme&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addFilme.php?pg=favorito&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoFilmePDF.php?id_filme=<?php echo $id_filme; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } } ?>
<!--MOSTRANDO PESQUISA FILMES 14-------------------------------------------------------------------------------------------------->










<!--MOSTRANDO FILMES 16----------------------------------------------------------------------------------------------------->
	<?php
		if(@$_GET['pg'] == 'filmes16'){

	$selecionar_filmes_Livre = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria WHERE classificacao_filme='Livre'
	 AND `filme`.`categoria_id`=`categoria`.`id_categoria`");
	$selecionar_filmes_Livre->execute();
	$res_selecionar_filmes_Livre = $selecionar_filmes_Livre->fetchAll();

	$selecionar_filmes_10 = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria WHERE classificacao_filme=10
	 AND `filme`.`categoria_id`=`categoria`.`id_categoria`");
	$selecionar_filmes_10->execute();
	$res_selecionar_filmes_10 = $selecionar_filmes_10->fetchAll();

	$selecionar_filmes_12 = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria WHERE classificacao_filme=12
	 AND `filme`.`categoria_id`=`categoria`.`id_categoria`");
	$selecionar_filmes_12->execute();
	$res_selecionar_filmes_12 = $selecionar_filmes_12->fetchAll();

	$selecionar_filmes_14 = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria WHERE classificacao_filme=14
	 AND `filme`.`categoria_id`=`categoria`.`id_categoria`");
	$selecionar_filmes_14->execute();
	$res_selecionar_filmes_14 = $selecionar_filmes_14->fetchAll();

	$selecionar_filmes_16 = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria WHERE classificacao_filme=16
	 AND `filme`.`categoria_id`=`categoria`.`id_categoria`");
	$selecionar_filmes_16->execute();
	$res_selecionar_filmes_16 = $selecionar_filmes_16->fetchAll();
		
?>
	 <form method="POST" enctype="multipart/form-data">
		<div class="form-row">
			<div class="form-group col-md-4">
				<label for="inputState">Pesquisar</label>
				<select id="inputState" class="form-control" name="categoria">
					<?php 
						foreach ($res_categoria as $key => $value) {
						$id_categoria = $value['id_categoria'];
						$nome_categoria = $value['nome_categoria'];
					?>
						<option value="<?php echo $id_categoria; ?>"><?php echo $nome_categoria; ?></option>
						<?php } ?>
				</select>
			</div> 
			<div class="form-group col-md-2 pesquisarFilme">
				<button type="submit" class="btn btn-success pesquisar" name="pesquisarFilmes16">Pesquisar</button>
			</div>
			<div class="form-group col-md-6 pesquisarFilme">
				<i>Lista de filmes recomendados de acordo com sua idade</i>
			</div>
		</div>
	</form>
	
	<table class="table">
		<thead>
			<tr>
				<th scope="col">Nome</th>
				<th scope="col">Categoria</th>
				<th scope="col">Classificação</th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ($res_selecionar_filmes_Livre as $key => $value) {
					$id_filme = $value['id_filme'];
					$nome_filme = $value['nome_filme'];
					$classificacao_filme = $value['classificacao_filme'];
					$categoria_filme = $value['nome_categoria'];
			?>
			<tr>
				<td><?php echo $nome_filme; ?></td>
				<td><?php echo $categoria_filme; ?></td>
				<td><?php echo $classificacao_filme; ?></td>
				 <td>
				 	<a href="addFilme.php?pg=addLista&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addFilme.php?pg=favorito&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoFilmePDF.php?id_filme=<?php echo $id_filme; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_selecionar_filmes_10 as $key => $value) {
					$id_filme = $value['id_filme'];
					$nome_filme = $value['nome_filme'];
					$classificacao_filme = $value['classificacao_filme'];
					$categoria_filme = $value['nome_categoria'];
				
			?>
			<tr>
				<td><?php echo $nome_filme; ?></td>
				<td><?php echo $categoria_filme; ?></td>
				<td><?php echo $classificacao_filme; ?></td>
				 <td>
				 	<a href="addFilme.php?pg=addLista&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addFilme.php?pg=favorito&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoFilmePDF.php?id_filme=<?php echo $id_filme; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_selecionar_filmes_12 as $key => $value) {
					$id_filme = $value['id_filme'];
					$nome_filme = $value['nome_filme'];
					$classificacao_filme = $value['classificacao_filme'];
					$categoria_filme = $value['nome_categoria'];
				
			?>
			<tr>
				<td><?php echo $nome_filme; ?></td>
				<td><?php echo $categoria_filme; ?></td>
				<td><?php echo $classificacao_filme; ?></td>
				 <td>
				 	<a href="addFilme.php?pg=addLista&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addFilme.php?pg=favorito&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoFilmePDF.php?id_filme=<?php echo $id_filme; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_selecionar_filmes_14 as $key => $value) {
					$id_filme = $value['id_filme'];
					$nome_filme = $value['nome_filme'];
					$classificacao_filme = $value['classificacao_filme'];
					$categoria_filme = $value['nome_categoria'];
				
			?>
			<tr>
				<td><?php echo $nome_filme; ?></td>
				<td><?php echo $categoria_filme; ?></td>
				<td><?php echo $classificacao_filme; ?></td>
				 <td>
				 	<a href="addFilme.php?pg=addLista&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addFilme.php?pg=favorito&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoFilmePDF.php?id_filme=<?php echo $id_filme; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_selecionar_filmes_16 as $key => $value) {
					$id_filme = $value['id_filme'];
					$nome_filme = $value['nome_filme'];
					$classificacao_filme = $value['classificacao_filme'];
					$categoria_filme = $value['nome_categoria'];
				
			?>
			<tr>
				<td><?php echo $nome_filme; ?></td>
				<td><?php echo $categoria_filme; ?></td>
				<td><?php echo $classificacao_filme; ?></td>
				 <td>
				 	<a href="addFilme.php?pg=addLista&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addFilme.php?pg=favorito&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoFilmePDF.php?id_filme=<?php echo $id_filme; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } ?>
<!--MOSTRANDO FILMES 16-------------------------------------------------------------------------------------------------->

<!--MOSTRANDO PESQUISA FILMES 16----------------------------------------------------------------------------------------------------->
	<?php
		if(@$_GET['pg'] == 'pesquisaFilme16'){
			$id_categoria = $_GET['id_categoria'];

			$pesquisa_filmes_16_Livre = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria WHERE categoria_id=? 
			AND classificacao_filme='Livre' AND `filme`.`categoria_id`=`categoria`.`id_categoria`");
			$pesquisa_filmes_16_Livre->execute(array($id_categoria));
			$res_pesquisa_filmes_16_Livre = $pesquisa_filmes_16_Livre->fetchAll();


			$pesquisa_filmes_16_10 = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria WHERE categoria_id=? 
			AND classificacao_filme=10 AND `filme`.`categoria_id`=`categoria`.`id_categoria`");
			$pesquisa_filmes_16_10->execute(array($id_categoria));
			$res_pesquisa_filmes_16_10 = $pesquisa_filmes_16_10->fetchAll();

			$pesquisa_filmes_16_12 = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria WHERE categoria_id=? 
			AND classificacao_filme=12 AND `filme`.`categoria_id`=`categoria`.`id_categoria`");
			$pesquisa_filmes_16_12->execute(array($id_categoria));
			$res_pesquisa_filmes_16_12 = $pesquisa_filmes_16_12->fetchAll();

			$pesquisa_filmes_16_14 = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria WHERE categoria_id=? 
			AND classificacao_filme=14 AND `filme`.`categoria_id`=`categoria`.`id_categoria`");
			$pesquisa_filmes_16_14->execute(array($id_categoria));
			$res_pesquisa_filmes_16_14 = $pesquisa_filmes_16_14->fetchAll();

			$pesquisa_filmes_16 = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria WHERE categoria_id=? 
			AND classificacao_filme=16 AND `filme`.`categoria_id`=`categoria`.`id_categoria`");
			$pesquisa_filmes_16->execute(array($id_categoria));
			$res_pesquisa_filmes_16 = $pesquisa_filmes_16->fetchAll();

			if($res_pesquisa_filmes_16_Livre == null && $res_pesquisa_filmes_16_10 == null && $res_pesquisa_filmes_16_12 == null
				&& $res_pesquisa_filmes_16_14 == null && $res_pesquisa_filmes_16 == null){
				echo "<script>window.alert('Não existe filmes nessa categoria');
				window.location.href = 'addFilme.php?pg=filmes16&id_cliente=$id_cliente'</script>";
			}else{
	?>
		 <form method="POST" enctype="multipart/form-data">
		<div class="form-row">
			<div class="form-group col-md-4">
				<label for="inputState">Pesquisar</label>
				<select id="inputState" class="form-control" name="categoria">
					<?php 
						foreach ($res_categoria as $key => $value) {
						$id_categoria = $value['id_categoria'];
						$nome_categoria = $value['nome_categoria'];
					?>
						<option value="<?php echo $id_categoria; ?>"><?php echo $nome_categoria; ?></option>
						<?php } ?>
				</select>
			</div> 
			<div class="form-group col-md-2 pesquisarFilme">
				<button type="submit" class="btn btn-success pesquisar" name="pesquisarFilmes14">Pesquisar</button>
			</div>
			<div class="form-group col-md-6 pesquisarFilme">
				<i>Lista de filmes recomendados de acordo com sua idade</i>
			</div>
		</div>
	</form>
	
	<table class="table">
		<thead>
			<tr>
				<th scope="col">Nome</th>
				<th scope="col">Categoria</th>
				<th scope="col">Classificação</th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ($res_pesquisa_filmes_16_Livre as $key => $value) {
					$id_filme = $value['id_filme'];
					$nome_filme = $value['nome_filme'];
					$classificacao_filme = $value['classificacao_filme'];
					$categoria_filme = $value['nome_categoria'];
			?>
			<tr>
				<td><?php echo $nome_filme; ?></td>
				<td><?php echo $categoria_filme; ?></td>
				<td><?php echo $classificacao_filme; ?></td>
				 <td>
				 	<a href="addFilme.php?pg=addLista&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addFilme.php?pg=favorito&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoFilmePDF.php?id_filme=<?php echo $id_filme; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_pesquisa_filmes_16_10 as $key => $value) {
					$id_filme = $value['id_filme'];
					$nome_filme = $value['nome_filme'];
					$classificacao_filme = $value['classificacao_filme'];
					$categoria_filme = $value['nome_categoria'];
				
			?>
			<tr>
				<td><?php echo $nome_filme; ?></td>
				<td><?php echo $categoria_filme; ?></td>
				<td><?php echo $classificacao_filme; ?></td>
				 <td>
				 	<a href="addFilme.php?pg=addLista&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addFilme.php?pg=favorito&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoFilmePDF.php?id_filme=<?php echo $id_filme; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_pesquisa_filmes_16_12 as $key => $value) {
					$id_filme = $value['id_filme'];
					$nome_filme = $value['nome_filme'];
					$classificacao_filme = $value['classificacao_filme'];
					$categoria_filme = $value['nome_categoria'];
				
			?>
			<tr>
				<td><?php echo $nome_filme; ?></td>
				<td><?php echo $categoria_filme; ?></td>
				<td><?php echo $classificacao_filme; ?></td>
				 <td>
				 	<a href="addFilme.php?pg=addLista&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addFilme.php?pg=favorito&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoFilmePDF.php?id_filme=<?php echo $id_filme; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_pesquisa_filmes_16_14 as $key => $value) {
					$id_filme = $value['id_filme'];
					$nome_filme = $value['nome_filme'];
					$classificacao_filme = $value['classificacao_filme'];
					$categoria_filme = $value['nome_categoria'];
				
			?>
			<tr>
				<td><?php echo $nome_filme; ?></td>
				<td><?php echo $categoria_filme; ?></td>
				<td><?php echo $classificacao_filme; ?></td>
				 <td>
				 	<a href="addFilme.php?pg=addLista&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addFilme.php?pg=favorito&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoFilmePDF.php?id_filme=<?php echo $id_filme; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_pesquisa_filmes_16 as $key => $value) {
					$id_filme = $value['id_filme'];
					$nome_filme = $value['nome_filme'];
					$classificacao_filme = $value['classificacao_filme'];
					$categoria_filme = $value['nome_categoria'];
				
			?>
			<tr>
				<td><?php echo $nome_filme; ?></td>
				<td><?php echo $categoria_filme; ?></td>
				<td><?php echo $classificacao_filme; ?></td>
				 <td>
				 	<a href="addFilme.php?pg=addLista&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addFilme.php?pg=favorito&id_filme=<?php echo $id_filme; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoFilmePDF.php?id_filme=<?php echo $id_filme; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>
		</tbody>
	</table>
<?php } } ?>
<!--MOSTRANDO PESQUISA FILMES 16----------------------------------------------------------------------------------------------------->




<!--ADICIONANDO FILME A LISTA----------------------------------------------------------------------------------------------------->
	<?php
		if(@$_GET['pg'] == 'addLista'){
			$id_filme = $_GET['id_filme'];
			$id_cliente = $_GET['id_cliente'];
			

			$quantidade_dados = count($res_selecionar_lista_filme) + count($res_selecionar_lista_serie);

			$lista_filme = $pdo->prepare("SELECT * FROM listafilme WHERE filme_id=? AND cliente_id=?");
			$lista_filme->execute(array($id_filme,$id_cliente));
			$res = $lista_filme->fetchAll();

			if($res == null){
				/* MODELO DE COMO FAZER PARA NÃO DEIXAR SALVAR MAIS DADOS NO BANCO CASO PASSE DO LIMITE DO PLANO DO CLIENTE*/
				if($nome_plano == 'Plano Basico'){
					if($quantidade_dados < 5){
						$salvar_filme_lista = $pdo->prepare("INSERT INTO listafilme (filme_id,cliente_id) VALUES (?,?) ");
						$salvar_filme_lista->execute(array($id_filme,$id_cliente));
						if($salvar_filme_lista == true){
							echo "<script>window.alert('Filme adicionado a lista');
							window.location.href = 'painelCliente.php?id_cliente=$id_cliente'</script>";
						}
					}else{
						echo "<script>window.alert('Você chegou no limite de filmes e séries adicionados, troque para o (Plano Platino ou Plano Ouro) ');window.location.href = 'painelCliente.php?id_cliente=$id_cliente'</script>";
					}
				}else if($nome_plano == 'Plano Platino'){
					if($quantidade_dados < 10){
						$salvar_filme_lista = $pdo->prepare("INSERT INTO listafilme (filme_id,cliente_id) VALUES (?,?) ");
						$salvar_filme_lista->execute(array($id_filme,$id_cliente));
						if($salvar_filme_lista == true){
							echo "<script>window.alert('Filme adicionado a lista');
							window.location.href = 'painelCliente.php?id_cliente=$id_cliente'</script>";
						}
					}else{
						echo "<script>window.alert('Você chegou no limite de filmes e séries adicionados, troque para o (Plano Ouro) ');
						window.location.href = 'painelCliente.php?id_cliente=$id_cliente'</script>";
					}

				}else if($nome_plano == 'Plano Ouro'){
					$salvar_filme_lista = $pdo->prepare("INSERT INTO listafilme (filme_id,cliente_id) VALUES (?,?) ");
					$salvar_filme_lista->execute(array($id_filme,$id_cliente));
					if($salvar_filme_lista == true){
							echo "<script>window.alert('Filme adicionado a lista');
							window.location.href = 'painelCliente.php?id_cliente=$id_cliente'</script>";
					}
				}
				
			}else{
				echo "<script>window.alert('Você já adicionou esse filme a sua lista');
					window.location.href = 'painelCliente.php?id_cliente=$id_cliente'</script>";	
			}
		}

	?>
<!--ADICIONANDO FILME A LISTA----------------------------------------------------------------------------------------------------->


<!--ADICIONANDO FILME A FAVORITOS----------------------------------------------------------------------------------------------------->
	<?php
		if(@$_GET['pg'] == 'favorito'){
			$id_cliente = $_GET['id_cliente'];
			$id_filme = $_GET['id_filme'];

			$filmes_favoritos = $pdo->prepare("SELECT * FROM filmefavorito WHERE filme_id=? AND cliente_id=?");
			$filmes_favoritos->execute(array($id_filme,$id_cliente));
			$res = $filmes_favoritos->fetchAll();

			if($res == null){
				$salvar_favorito = $pdo->prepare("INSERT INTO filmefavorito (filme_id,cliente_id) VALUES(?,?) ");
				$salvar_favorito->execute(array($id_filme,$id_cliente));

				if($salvar_favorito == true){
				echo "<script>window.alert('Filme adicionado aos favoritos');
						window.location.href = 'painelCliente.php?id_cliente=$id_cliente'</script>";
				}

			}else{
				echo "<script>window.alert('Você já adicionou esse filme aos favoritos');
					window.location.href = 'painelCliente.php?id_cliente=$id_cliente'</script>";
			}	
		}

	?>

<!--ADICIONANDO FILME A FAVORITOS----------------------------------------------------------------------------------------------------->





</div>

	
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>