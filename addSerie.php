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

	
	if(isset($_POST['pesquisarSerieLivre'])){
		$categoria = $_POST['categoria'];
		echo "<script>window.location.href = 'addSerie.php?pg=pesquisaSerieLivre&id_categoria=$categoria&id_cliente=$id_cliente'</script>";

	}

	if(isset(($_POST['pesquisarTodasSerie']))){
		$categoria = $_POST['categoria'];
		echo "<script>window.location.href = 'addSerie.php?pg=pesquisaTodasSerie&id_categoria=$categoria&id_cliente=$id_cliente'</script>";
	}
	
	if(isset($_POST['pesquisarSerie10'])){
		$categoria = $_POST['categoria'];
		echo "<script>window.location.href = 'addSerie.php?pg=pesquisaSerie10&id_categoria=$categoria&id_cliente=$id_cliente'</script>";
	}

	if(isset($_POST['pesquisarSerie12'])){
		$categoria = $_POST['categoria'];
		echo "<script>window.location.href = 'addSerie.php?pg=pesquisaSerie12&id_categoria=$categoria&id_cliente=$id_cliente'</script>";
	}

	if(isset($_POST['pesquisarSerie14'])){
		$categoria = $_POST['categoria'];
		echo "<script>window.location.href = 'addSerie.php?pg=pesquisaSerie14&id_categoria=$categoria&id_cliente=$id_cliente'</script>";
	}

	if(isset($_POST['pesquisarSerie16'])){
		$categoria = $_POST['categoria'];
		echo "<script>window.location.href = 'addSerie.php?pg=pesquisaSerie16&id_categoria=$categoria&id_cliente=$id_cliente'</script>";
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
	if(@$_GET['pg'] =='seriesLivre'){
	$selecionar_todos_series_Livre = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria  WHERE classificacao_serie ='Livre'
	AND `serie`.`categoria_id`=`categoria`.`id_categoria`");
	$selecionar_todos_series_Livre->execute();
	$res_selecionar_todos_series_Livre = $selecionar_todos_series_Livre->fetchAll();
		
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
				<button type="submit" class="btn btn-success pesquisar" name="pesquisarSerieLivre">Pesquisar</button>
			</div>
			<div class="form-group col-md-6 pesquisarFilme">
				<i>Lista de series recomendados de acordo com sua idade</i>
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
				foreach ($res_selecionar_todos_series_Livre as $key => $value) {
					$id_serie = $value['id_serie'];
					$nome_serie = $value['nome_serie'];
					$classificacao_serie = $value['classificacao_serie'];
					$categoria_serie = $value['nome_categoria'];
			?>
			<tr>
				<td><?php echo $nome_serie; ?></td>
				<td><?php echo $categoria_serie; ?></td>
				<td><?php echo $classificacao_serie; ?></td>
				 <td>
				 	<a href="addSerie.php?pg=addLista&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addSerie.php?pg=favorito&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoSeriePDF.php?id_serie=<?php echo $id_serie; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			<?php } ?>
			 </tr>

		</tbody>
	</table>
	<?php } ?>
<!--MOSTRANDO TODOS OS SERIES LIVRES----------------------------------------------------------------------------------------------------->

<!--MOSTRANDO PESQUISA OS FILMES LIVRES----------------------------------------------------------------------------------------------------->
	<?php
		if(@$_GET['pg'] == 'pesquisaSerieLivre'){
			$id_categoria = $_GET['id_categoria'];

			$pesquisa_serie_livre = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria WHERE classificacao_serie='Livre'
			AND categoria_id=? AND `serie`.`categoria_id` = `categoria`.`id_categoria`");
			$pesquisa_serie_livre->execute(array($id_categoria));

			$res_pesquisa_serie_livre = $pesquisa_serie_livre->fetchAll();

			if($res_pesquisa_filme_livre == null){
				echo "<script>window.alert('Não existe series nessa categoria');
				window.location.href = 'addSerie.php?pg=seriesLivre&id_cliente=$id_cliente'</script>";
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
				<button type="submit" class="btn btn-success pesquisar" name="pesquisarSerieLivre">Pesquisar</button>
			</div>
			<div class="form-group col-md-6 pesquisarFilme">
				<i>Lista de series recomendados de acordo com sua idade</i>
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
				foreach ($res_pesquisa_serie_livre as $key => $value) {
					$id_serie = $value['id_serie'];
					$nome_serie = $value['nome_serie'];
					$classificacao_serie = $value['classificacao_serie'];
					$categoria_serie = $value['nome_categoria'];
			?>
			<tr>
				
				<td><?php echo $nome_serie; ?></td>
				<td><?php echo $categoria_serie; ?></td>
				<td><?php echo $classificacao_serie; ?></td>
				<td>
				 	<a href="addSerie.php?pg=addLista&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addSerie.php?pg=favorito&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoSeriePDF.php?id_serie=<?php echo $id_serie; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			<?php } ?>
			 </tr>

		</tbody>
	</table>
	<?php } } ?>
<!--MOSTRANDO PESQUISA OS FILMES LIVRES----------------------------------------------------------------------------------------------------->







<!--MOSTRANDO TODOS OS FILMES----------------------------------------------------------------------------------------------------->
<?php 
	if(@$_GET['pg'] =='todasSeries'){
	$selecionar_todos_series = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria ON `serie`.`categoria_id`=`categoria`.`id_categoria`");
	$selecionar_todos_series->execute();
	$res_selecionar_todos_series = $selecionar_todos_series->fetchAll();
		
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
				<button type="submit" class="btn btn-success pesquisar" name="pesquisarTodasSerie">Pesquisar</button>
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
				foreach ($res_selecionar_todos_series as $key => $value) {
					$id_serie = $value['id_serie'];
					$nome_serie = $value['nome_serie'];
					$classificacao_serie = $value['classificacao_serie'];
					$categoria_serie = $value['nome_categoria'];
			?>
			<tr>
				
				<td><?php echo $nome_serie; ?></td>
				<td><?php echo $categoria_serie; ?></td>
				<td><?php echo $classificacao_serie; ?></td>
				<td>
				 	<a href="addSerie.php?pg=addLista&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addSerie.php?pg=favorito&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoSeriePDF.php?id_serie=<?php echo $id_serie; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			<?php } ?>
			 </tr>

		</tbody>
	</table>
	<?php } ?>
<!--MOSTRANDO TODOS OS SERIES----------------------------------------------------------------------------------------------------->

<!--MOSTRANDO PESQUISA TODOS OS FILMES----------------------------------------------------------------------------------------------------->
	<?php
		if(@$_GET['pg'] == 'pesquisaTodasSerie'){
			$id_categoria = $_GET['id_categoria'];

			$pesquisa_todos_series = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria WHERE categoria_id=?
			AND `serie`.`categoria_id`=`categoria`.`id_categoria`");
			$pesquisa_todos_series->execute(array($id_categoria));
			$res_pesquisa_todos_series = $pesquisa_todos_series->fetchAll();

			if($res_pesquisa_todos_series == null){
				echo "<script>window.alert('Não existe series nessa categoria');
				window.location.href = 'addSerie.php?pg=todasSeries&id_cliente=$id_cliente'</script>";
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
				<button type="submit" class="btn btn-success pesquisar" name="pesquisarTodasSerie">Pesquisar</button>
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
				foreach ($res_pesquisa_todos_series as $key => $value) {
					$id_serie = $value['id_serie'];
					$nome_serie = $value['nome_serie'];
					$classificacao_serie = $value['classificacao_serie'];
					$categoria_serie = $value['nome_categoria'];
			?>
			<tr>
				
				<td><?php echo $nome_serie; ?></td>
				<td><?php echo $categoria_serie; ?></td>
				<td><?php echo $classificacao_serie; ?></td>
				<td>
				 	<a href="addSerie.php?pg=addLista&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addSerie.php?pg=favorito&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoSeriePDF.php?id_serie=<?php echo $id_serie; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			<?php } ?>
			 </tr>

		</tbody>
	</table>

	<?php } } ?>

<!--MOSTRANDO PESQUISA TODOS OS SERIES----------------------------------------------------------------------------------------------------->





<!--MOSTRANDO SERIES 10----------------------------------------------------------------------------------------------------->
	<?php
		if(@$_GET['pg'] == 'series10'){
	$selecionar_series_10 = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria WHERE classificacao_serie=10
	 AND `serie`.`categoria_id`=`categoria`.`id_categoria`");
	$selecionar_series_10->execute();
	$res_selecionar_series_10 = $selecionar_series_10->fetchAll();


	$selecionar_series_Livre = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria WHERE classificacao_serie='Livre'
	 AND `serie`.`categoria_id`=`categoria`.`id_categoria`");
	$selecionar_series_Livre->execute();
	$res_selecionar_series_Livre = $selecionar_series_Livre->fetchAll();
		
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
				<button type="submit" class="btn btn-success pesquisar" name="pesquisarSerie10">Pesquisar</button>
			</div>
			<div class="form-group col-md-6 pesquisarFilme">
				<i>Lista de series recomendados de acordo com sua idade</i>
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
				foreach ($res_selecionar_series_Livre as $key => $value) {
					$id_serie = $value['id_serie'];
					$nome_serie = $value['nome_serie'];
					$classificacao_serie = $value['classificacao_serie'];
					$categoria_serie = $value['nome_categoria'];
			?>
			<tr>
				
				<td><?php echo $nome_serie; ?></td>
				<td><?php echo $categoria_serie; ?></td>
				<td><?php echo $classificacao_serie; ?></td>
				<td>
				 	<a href="addSerie.php?pg=addLista&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addSerie.php?pg=favorito&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoSeriePDF.php?id_serie=<?php echo $id_serie; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_selecionar_series_10 as $key => $value) {
					$id_serie = $value['id_serie'];
					$nome_serie = $value['nome_serie'];
					$classificacao_serie = $value['classificacao_serie'];
					$categoria_serie = $value['nome_categoria'];
				
			?>
			<tr>
				
				<td><?php echo $nome_serie; ?></td>
				<td><?php echo $categoria_serie; ?></td>
				<td><?php echo $classificacao_serie; ?></td>
				<td>
				 	<a href="addSerie.php?pg=addLista&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addSerie.php?pg=favorito&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoSeriePDF.php?id_serie=<?php echo $id_serie; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } ?>
<!--MOSTRANDO SERIES 10-------------------------------------------------------------------------------------------------->


<!--MOSTRANDO PESQUISA SERIES 10----------------------------------------------------------------------------------------------------->
	<?php
		if(@$_GET['pg'] == 'pesquisaSerie10'){
			$id_categoria = $_GET['id_categoria'];

			$pesquisa_series_10_Livre = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria WHERE categoria_id=? 
			AND classificacao_serie='Livre' AND `serie`.`categoria_id`=`categoria`.`id_categoria`");
			$pesquisa_series_10_Livre->execute(array($id_categoria));
			$res_pesquisa_series_10_Livre = $pesquisa_series_10_Livre->fetchAll();


			$pesquisa_series_10 = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria WHERE categoria_id=? 
			AND classificacao_serie=10 AND `serie`.`categoria_id`=`categoria`.`id_categoria`");
			$pesquisa_series_10->execute(array($id_categoria));
			$res_pesquisa_series_10 = $pesquisa_series_10->fetchAll();


			if($res_pesquisa_series_10_Livre == null && $res_pesquisa_series_10 == null){
				echo "<script>window.alert('Não existe series nessa categoria');
				window.location.href = 'addSerie.php?pg=series10&id_cliente=$id_cliente'</script>";
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
				<button type="submit" class="btn btn-success pesquisar" name="pesquisarSerie10">Pesquisar</button>
			</div>
			<div class="form-group col-md-6 pesquisarFilme">
				<i>Lista de series recomendados de acordo com sua idade</i>
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
				foreach ($res_pesquisa_series_10_Livre as $key => $value) {
					$id_serie = $value['id_serie'];
					$nome_serie = $value['nome_serie'];
					$classificacao_serie = $value['classificacao_serie'];
					$categoria_serie = $value['nome_categoria'];
			?>
			<tr>
				<td><?php echo $nome_filme_livre; ?></td>
				<td><?php echo $categoria_filme_livre; ?></td>
				<td><?php echo $classificacao_filme_livre; ?></td>
				<td>
				 	<a href="addSerie.php?pg=addLista&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addSerie.php?pg=favorito&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoSeriePDF.php?id_serie=<?php echo $id_serie; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_pesquisa_series_10 as $key => $value) {
					$id_serie = $value['id_serie'];
					$nome_serie = $value['nome_serie'];
					$classificacao_serie = $value['classificacao_serie'];
					$categoria_serie = $value['nome_categoria'];
				
			?>
			<tr>
				
				<td><?php echo $nome_serie; ?></td>
				<td><?php echo $categoria_serie; ?></td>
				<td><?php echo $classificacao_serie; ?></td>
				<td>
				 	<a href="addSerie.php?pg=addLista&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addSerie.php?pg=favorito&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoSeriePDF.php?id_serie=<?php echo $id_serie; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } }?>
<!--MOSTRANDO PESQUISA SERIES 10----------------------------------------------------------------------------------------------------->







<!--MOSTRANDO SERIES 12----------------------------------------------------------------------------------------------------->
	<?php
		if(@$_GET['pg'] == 'series12'){
	$selecionar_series_10 = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria WHERE classificacao_serie=10
	 AND `serie`.`categoria_id`=`categoria`.`id_categoria`");
	$selecionar_series_10->execute();
	$res_selecionar_series_10 = $selecionar_series_10->fetchAll();


	$selecionar_series_Livre = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria WHERE classificacao_serie='Livre'
	 AND `serie`.`categoria_id`=`categoria`.`id_categoria`");
	$selecionar_series_Livre->execute();
	$res_selecionar_series_Livre = $selecionar_series_Livre->fetchAll();


	$selecionar_series_12 = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria WHERE classificacao_serie=12
	 AND `serie`.`categoria_id`=`categoria`.`id_categoria`");
	$selecionar_series_12->execute();
	$res_selecionar_series_12 = $selecionar_series_12->fetchAll();
		
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
				<button type="submit" class="btn btn-success pesquisar" name="pesquisarSerie12">Pesquisar</button>
			</div>
			<div class="form-group col-md-6 pesquisarFilme">
				<i>Lista de series recomendados de acordo com sua idade</i>
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
				foreach ($res_selecionar_series_Livre as $key => $value) {
					$id_serie = $value['id_serie'];
					$nome_serie = $value['nome_serie'];
					$classificacao_serie = $value['classificacao_serie'];
					$categoria_serie = $value['nome_categoria'];
			?>
			<tr>
				
				<td><?php echo $nome_serie; ?></td>
				<td><?php echo $categoria_serie; ?></td>
				<td><?php echo $classificacao_serie; ?></td>
				<td>
				 	<a href="addSerie.php?pg=addLista&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addSerie.php?pg=favorito&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoSeriePDF.php?id_serie=<?php echo $id_serie; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_selecionar_series_10 as $key => $value) {
					$id_serie = $value['id_serie'];
					$nome_serie = $value['nome_serie'];
					$classificacao_serie = $value['classificacao_serie'];
					$categoria_serie = $value['nome_categoria'];
				
			?>
			<tr>
				
				<td><?php echo $nome_serie; ?></td>
				<td><?php echo $categoria_serie; ?></td>
				<td><?php echo $classificacao_serie; ?></td>
				<td>
				 	<a href="addSerie.php?pg=addLista&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addSerie.php?pg=favorito&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoSeriePDF.php?id_serie=<?php echo $id_serie; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_selecionar_series_12 as $key => $value) {
					$id_serie = $value['id_serie'];
					$nome_serie = $value['nome_serie'];
					$classificacao_serie = $value['classificacao_serie'];
					$categoria_serie = $value['nome_categoria'];
				
			?>
			<tr>
				
				<td><?php echo $nome_serie; ?></td>
				<td><?php echo $categoria_serie; ?></td>
				<td><?php echo $classificacao_serie; ?></td>
				<td>
				 	<a href="addSerie.php?pg=addLista&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addSerie.php?pg=favorito&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoSeriePDF.php?id_serie=<?php echo $id_serie; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } ?>
<!--MOSTRANDO SERIES 12-------------------------------------------------------------------------------------------------->

<!--MOSTRANDO PESQUISA SERIES 12-------------------------------------------------------------------------------------------------->
	<?php
		if(@$_GET['pg'] == 'pesquisaSerie12'){
			$id_categoria = $_GET['id_categoria'];

			$pesquisa_series_12_Livre = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria WHERE categoria_id=? 
			AND classificacao_serie='Livre' AND `serie`.`categoria_id`=`categoria`.`id_categoria`");
			$pesquisa_series_12_Livre->execute(array($id_categoria));
			$res_pesquisa_series_12_Livre = $pesquisa_series_12_Livre->fetchAll();


			$pesquisa_series_12_10 = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria WHERE categoria_id=? 
			AND classificacao_serie=10 AND `serie`.`categoria_id`=`categoria`.`id_categoria`");
			$pesquisa_series_12_10->execute(array($id_categoria));
			$res_pesquisa_series_12_10 = $pesquisa_series_12_10->fetchAll();

			$pesquisa_series_12 = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria WHERE categoria_id=? 
			AND classificacao_serie=12 AND `serie`.`categoria_id`=`categoria`.`id_categoria`");
			$pesquisa_series_12->execute(array($id_categoria));
			$res_pesquisa_series_12 = $pesquisa_series_12->fetchAll();

			if($res_pesquisa_series_12_Livre == null && $res_pesquisa_series_12_10 == null && $res_pesquisa_series_12 == null){
				echo "<script>window.alert('Não existe series nessa categoria');
				window.location.href = 'addSerie.php?pg=series12&id_cliente=$id_cliente'</script>";
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
				<button type="submit" class="btn btn-success pesquisar" name="pesquisarSerie12">Pesquisar</button>
			</div>
			<div class="form-group col-md-6 pesquisarFilme">
				<i>Lista de series recomendados de acordo com sua idade</i>
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
					$id_serie = $value['id_serie'];
					$nome_serie = $value['nome_serie'];
					$classificacao_serie = $value['classificacao_serie'];
					$categoria_serie = $value['nome_categoria'];
			?>
			<tr>
				
				<td><?php echo $nome_serie; ?></td>
				<td><?php echo $categoria_serie; ?></td>
				<td><?php echo $classificacao_serie; ?></td>
				<td>
				 	<a href="addSerie.php?pg=addLista&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addSerie.php?pg=favorito&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoSeriePDF.php?id_serie=<?php echo $id_serie; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_pesquisa_filmes_12_10 as $key => $value) {
					$id_serie = $value['id_serie'];
					$nome_serie = $value['nome_serie'];
					$classificacao_serie = $value['classificacao_serie'];
					$categoria_serie = $value['nome_categoria'];
				
			?>
			<tr>
				
				<td><?php echo $nome_serie; ?></td>
				<td><?php echo $categoria_serie; ?></td>
				<td><?php echo $classificacao_serie; ?></td>
				<td>
				 	<a href="addSerie.php?pg=addLista&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addSerie.php?pg=favorito&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoSeriePDF.php?id_serie=<?php echo $id_serie; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_pesquisa_filmes_12 as $key => $value) {
					$id_serie = $value['id_serie'];
					$nome_serie = $value['nome_serie'];
					$classificacao_serie = $value['classificacao_serie'];
					$categoria_serie = $value['nome_categoria'];
				
			?>
			<tr>
				
				<td><?php echo $nome_serie; ?></td>
				<td><?php echo $categoria_serie; ?></td>
				<td><?php echo $classificacao_serie; ?></td>
				<td>
				 	<a href="addSerie.php?pg=addLista&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addSerie.php?pg=favorito&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoSeriePDF.php?id_serie=<?php echo $id_serie; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } }?>
<!--MOSTRANDO PESQUISA SERIES 12-------------------------------------------------------------------------------------------------->







<!--MOSTRANDO SERIES 14----------------------------------------------------------------------------------------------------->
	<?php
		if(@$_GET['pg'] == 'series14'){
	$selecionar_series_10 = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria WHERE classificacao_serie=10
	 AND `serie`.`categoria_id`=`categoria`.`id_categoria`");
	$selecionar_series_10->execute();
	$res_selecionar_series_10 = $selecionar_series_10->fetchAll();


	$selecionar_series_Livre = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria WHERE classificacao_serie='Livre'
	 AND `serie`.`categoria_id`=`categoria`.`id_categoria`");
	$selecionar_series_Livre->execute();
	$res_selecionar_series_Livre = $selecionar_series_Livre->fetchAll();


	$selecionar_series_12 = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria WHERE classificacao_serie=12
	 AND `serie`.`categoria_id`=`categoria`.`id_categoria`");
	$selecionar_series_12->execute();
	$res_selecionar_series_12 = $selecionar_series_12->fetchAll();

	$selecionar_series_14 = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria WHERE classificacao_serie=14
	 AND `serie`.`categoria_id`=`categoria`.`id_categoria`");
	$selecionar_series_14->execute();
	$res_selecionar_series_14 = $selecionar_series_14->fetchAll();
		
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
				<button type="submit" class="btn btn-success pesquisar" name="pesquisarSerie14">Pesquisar</button>
			</div>
			<div class="form-group col-md-6 pesquisarFilme">
				<i>Lista de series recomendados de acordo com sua idade</i>
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
				foreach ($res_selecionar_series_Livre as $key => $value) {
					$id_serie = $value['id_serie'];
					$nome_serie = $value['nome_serie'];
					$classificacao_serie = $value['classificacao_serie'];
					$categoria_serie = $value['nome_categoria'];
			?>
			<tr>
				
				<td><?php echo $nome_serie; ?></td>
				<td><?php echo $categoria_serie; ?></td>
				<td><?php echo $classificacao_serie; ?></td>
				<td>
				 	<a href="addSerie.php?pg=addLista&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addSerie.php?pg=favorito&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoSeriePDF.php?id_serie=<?php echo $id_serie; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_selecionar_series_10 as $key => $value) {
					$id_serie = $value['id_serie'];
					$nome_serie = $value['nome_serie'];
					$classificacao_serie = $value['classificacao_serie'];
					$categoria_serie = $value['nome_categoria'];
				
			?>
			<tr>
				
				<td><?php echo $nome_serie; ?></td>
				<td><?php echo $categoria_serie; ?></td>
				<td><?php echo $classificacao_serie; ?></td>
				<td>
				 	<a href="addSerie.php?pg=addLista&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addSerie.php?pg=favorito&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoSeriePDF.php?id_serie=<?php echo $id_serie; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_selecionar_series_12 as $key => $value) {
					$id_serie = $value['id_serie'];
					$nome_serie = $value['nome_serie'];
					$classificacao_serie = $value['classificacao_serie'];
					$categoria_serie = $value['nome_categoria'];
				
			?>
			<tr>
				
				<td><?php echo $nome_serie; ?></td>
				<td><?php echo $categoria_serie; ?></td>
				<td><?php echo $classificacao_serie; ?></td>
				<td>
				 	<a href="addSerie.php?pg=addLista&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addSerie.php?pg=favorito&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoSeriePDF.php?id_serie=<?php echo $id_serie; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_selecionar_series_14 as $key => $value) {
					$id_serie = $value['id_serie'];
					$nome_serie = $value['nome_serie'];
					$classificacao_serie = $value['classificacao_serie'];
					$categoria_serie = $value['nome_categoria'];
				
			?>
			<tr>
				
				<td><?php echo $nome_serie; ?></td>
				<td><?php echo $categoria_serie; ?></td>
				<td><?php echo $classificacao_serie; ?></td>
				<td>
				 	<a href="addSerie.php?pg=addLista&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addSerie.php?pg=favorito&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoSeriePDF.php?id_serie=<?php echo $id_serie; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } ?>
<!--MOSTRANDO SERIES 14-------------------------------------------------------------------------------------------------->

<!--MOSTRANDO PESQUISA SERIES 14-------------------------------------------------------------------------------------------------->
	<?php
		if(@$_GET['pg'] == 'pesquisaSerie14'){
			$id_categoria = $_GET['id_categoria'];

			$pesquisa_series_14_Livre = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria WHERE categoria_id=? 
			AND classificacao_serie='Livre' AND `serie`.`categoria_id`=`categoria`.`id_categoria`");
			$pesquisa_series_14_Livre->execute(array($id_categoria));
			$res_pesquisa_series_14_Livre = $pesquisa_series_14_Livre->fetchAll();


			$pesquisa_series_14_10 = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria WHERE categoria_id=? 
			AND classificacao_serie=10 AND `serie`.`categoria_id`=`categoria`.`id_categoria`");
			$pesquisa_series_14_10->execute(array($id_categoria));
			$res_pesquisa_series_14_10 = $pesquisa_series_14_10->fetchAll();

			$pesquisa_series_14_12 = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria WHERE categoria_id=? 
			AND classificacao_serie=12 AND `serie`.`categoria_id`=`categoria`.`id_categoria`");
			$pesquisa_series_14_12->execute(array($id_categoria));
			$res_pesquisa_series_14_12 = $pesquisa_series_14_12->fetchAll();

			$pesquisa_series_14 = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria WHERE categoria_id=? 
			AND classificacao_serie=14 AND `serie`.`categoria_id`=`categoria`.`id_categoria`");
			$pesquisa_series_14->execute(array($id_categoria));
			$res_pesquisa_series_14 = $pesquisa_series_14->fetchAll();

			if($res_pesquisa_series_14_Livre == null && $res_pesquisa_series_14_10 == null && $res_pesquisa_series_14_12 == null
				&& $res_pesquisa_series_14 == null){
				echo "<script>window.alert('Não existe series nessa categoria');
				window.location.href = 'addSerie.php?pg=series14&id_cliente=$id_cliente'</script>";
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
				<button type="submit" class="btn btn-success pesquisar" name="pesquisarSerie14">Pesquisar</button>
			</div>
			<div class="form-group col-md-6 pesquisarFilme">
				<i>Lista de series recomendados de acordo com sua idade</i>
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
				foreach ($res_pesquisa_series_14_Livre as $key => $value) {
					$id_serie = $value['id_serie'];
					$nome_serie = $value['nome_serie'];
					$classificacao_serie = $value['classificacao_serie'];
					$categoria_serie = $value['nome_categoria'];
			?>
			<tr>
				
				<td><?php echo $nome_serie; ?></td>
				<td><?php echo $categoria_serie; ?></td>
				<td><?php echo $classificacao_serie; ?></td>
				<td>
				 	<a href="addSerie.php?pg=addLista&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addSerie.php?pg=favorito&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoSeriePDF.php?id_serie=<?php echo $id_serie; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_pesquisa_series_14_10 as $key => $value) {
					$id_serie = $value['id_serie'];
					$nome_serie = $value['nome_serie'];
					$classificacao_serie = $value['classificacao_serie'];
					$categoria_serie = $value['nome_categoria'];
				
			?>
			<tr>
				
				<td><?php echo $nome_serie; ?></td>
				<td><?php echo $categoria_serie; ?></td>
				<td><?php echo $classificacao_serie; ?></td>
				<td>
				 	<a href="addSerie.php?pg=addLista&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addSerie.php?pg=favorito&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoSeriePDF.php?id_serie=<?php echo $id_serie; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_pesquisa_series_14_12 as $key => $value) {
					$id_serie = $value['id_serie'];
					$nome_serie = $value['nome_serie'];
					$classificacao_serie = $value['classificacao_serie'];
					$categoria_serie = $value['nome_categoria'];
				
			?>
			<tr>
				
				<td><?php echo $nome_serie; ?></td>
				<td><?php echo $categoria_serie; ?></td>
				<td><?php echo $classificacao_serie; ?></td>
				<td>
				 	<a href="addSerie.php?pg=addLista&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addSerie.php?pg=favorito&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoSeriePDF.php?id_serie=<?php echo $id_serie; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_pesquisa_series_14 as $key => $value) {
					$id_serie = $value['id_serie'];
					$nome_serie = $value['nome_serie'];
					$classificacao_serie = $value['classificacao_serie'];
					$categoria_serie = $value['nome_categoria'];
				
			?>
			<tr>
				
				<td><?php echo $nome_serie; ?></td>
				<td><?php echo $categoria_serie; ?></td>
				<td><?php echo $classificacao_serie; ?></td>
				 <td>
				 	<a href="addSerie.php?pg=addSerie&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addSerie.php?pg=favorito&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoSeriePDF.php?id_serie=<?php echo $id_serie; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } } ?>
<!--MOSTRANDO PESQUISA SERIES 14-------------------------------------------------------------------------------------------------->










<!--MOSTRANDO SERIES 16----------------------------------------------------------------------------------------------------->
	<?php
		if(@$_GET['pg'] == 'series16'){

	$selecionar_series_Livre = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria WHERE classificacao_serie='Livre'
	 AND `serie`.`categoria_id`=`categoria`.`id_categoria`");
	$selecionar_series_Livre->execute();
	$res_selecionar_series_Livre = $selecionar_series_Livre->fetchAll();

	$selecionar_series_10 = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria WHERE classificacao_serie=10
	 AND `serie`.`categoria_id`=`categoria`.`id_categoria`");
	$selecionar_series_10->execute();
	$res_selecionar_series_10 = $selecionar_series_10->fetchAll();

	$selecionar_series_12 = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria WHERE classificacao_serie=12
	 AND `serie`.`categoria_id`=`categoria`.`id_categoria`");
	$selecionar_series_12->execute();
	$res_selecionar_series_12 = $selecionar_series_12->fetchAll();

	$selecionar_series_14 = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria WHERE classificacao_serie=14
	 AND `serie`.`categoria_id`=`categoria`.`id_categoria`");
	$selecionar_series_14->execute();
	$res_selecionar_series_14 = $selecionar_series_14->fetchAll();

	$selecionar_series_16 = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria WHERE classificacao_serie=16
	 AND `serie`.`categoria_id`=`categoria`.`id_categoria`");
	$selecionar_series_16->execute();
	$res_selecionar_series_16 = $selecionar_series_16->fetchAll();
		
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
				<button type="submit" class="btn btn-success pesquisar" name="pesquisarSerie16">Pesquisar</button>
			</div>
			<div class="form-group col-md-6 pesquisarFilme">
				<i>Lista de series recomendados de acordo com sua idade</i>
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
				foreach ($res_selecionar_series_Livre as $key => $value) {
					$id_serie = $value['id_serie'];
					$nome_serie = $value['nome_serie'];
					$classificacao_serie = $value['classificacao_serie'];
					$categoria_serie = $value['nome_categoria'];
			?>
			<tr>
				
				<td><?php echo $nome_serie; ?></td>
				<td><?php echo $categoria_serie; ?></td>
				<td><?php echo $classificacao_serie; ?></td>
				<td>
				 	<a href="addSerie.php?pg=addLista&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addSerie.php?pg=favorito&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoSeriePDF.php?id_serie=<?php echo $id_serie; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_selecionar_series_10 as $key => $value) {
					$id_serie = $value['id_serie'];
					$nome_serie = $value['nome_serie'];
					$classificacao_serie = $value['classificacao_serie'];
					$categoria_serie = $value['nome_categoria'];
				
			?>
			<tr>
				
				<td><?php echo $nome_serie; ?></td>
				<td><?php echo $categoria_serie; ?></td>
				<td><?php echo $classificacao_serie; ?></td>
				<td>
				 	<a href="addSerie.php?pg=addLista&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addSerie.php?pg=favorito&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoSeriePDF.php?id_serie=<?php echo $id_serie; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_selecionar_series_12 as $key => $value) {
					$id_serie = $value['id_serie'];
					$nome_serie = $value['nome_serie'];
					$classificacao_serie = $value['classificacao_serie'];
					$categoria_serie = $value['nome_categoria'];
				
			?>
			<tr>
				
				<td><?php echo $nome_serie; ?></td>
				<td><?php echo $categoria_serie; ?></td>
				<td><?php echo $classificacao_serie; ?></td>
				<td>
				 	<a href="addSerie.php?pg=addLista&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addSerie.php?pg=favorito&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoSeriePDF.php?id_serie=<?php echo $id_serie; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_selecionar_series_14 as $key => $value) {
					$id_serie = $value['id_serie'];
					$nome_serie = $value['nome_serie'];
					$classificacao_serie = $value['classificacao_serie'];
					$categoria_serie = $value['nome_categoria'];
				
			?>
			<tr>
				
				<td><?php echo $nome_serie; ?></td>
				<td><?php echo $categoria_serie; ?></td>
				<td><?php echo $classificacao_serie; ?></td>
				<td>
				 	<a href="addSerie.php?pg=addLista&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addSerie.php?pg=favorito&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoSeriePDF.php?id_serie=<?php echo $id_serie; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_selecionar_series_16 as $key => $value) {
					$id_serie = $value['id_serie'];
					$nome_serie = $value['nome_serie'];
					$classificacao_serie = $value['classificacao_serie'];
					$categoria_serie = $value['nome_categoria'];
				
			?>
			<tr>
				
				<td><?php echo $nome_serie; ?></td>
				<td><?php echo $categoria_serie; ?></td>
				<td><?php echo $classificacao_serie; ?></td>
				<td>
				 	<a href="addSerie.php?pg=addLista&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addSerie.php?pg=favorito&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoSeriePDF.php?id_serie=<?php echo $id_serie; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } ?>
<!--MOSTRANDO SERIES 16-------------------------------------------------------------------------------------------------->

<!--MOSTRANDO PESQUISA SERIES 16----------------------------------------------------------------------------------------------------->
	<?php
		if(@$_GET['pg'] == 'pesquisaSerie16'){
			$id_categoria = $_GET['id_categoria'];

			$pesquisa_series_16_Livre = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria WHERE categoria_id=? 
			AND classificacao_serie='Livre' AND `serie`.`categoria_id`=`categoria`.`id_categoria`");
			$pesquisa_series_16_Livre->execute(array($id_categoria));
			$res_pesquisa_series_16_Livre = $pesquisa_series_16_Livre->fetchAll();


			$pesquisa_series_16_10 = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria WHERE categoria_id=? 
			AND classificacao_serie=10 AND `serie`.`categoria_id`=`categoria`.`id_categoria`");
			$pesquisa_series_16_10->execute(array($id_categoria));
			$res_pesquisa_series_16_10 = $pesquisa_series_16_10->fetchAll();

			$pesquisa_series_16_12 = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria WHERE categoria_id=? 
			AND classificacao_serie=12 AND `serie`.`categoria_id`=`categoria`.`id_categoria`");
			$pesquisa_series_16_12->execute(array($id_categoria));
			$res_pesquisa_series_16_12 = $pesquisa_series_16_12->fetchAll();

			$pesquisa_series_16_14 = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria WHERE categoria_id=? 
			AND classificacao_serie=14 AND `serie`.`categoria_id`=`categoria`.`id_categoria`");
			$pesquisa_series_16_14->execute(array($id_categoria));
			$res_pesquisa_series_16_14 = $pesquisa_series_16_14->fetchAll();

			$pesquisa_series_16 = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria WHERE categoria_id=? 
			AND classificacao_serie=16 AND `serie`.`categoria_id`=`categoria`.`id_categoria`");
			$pesquisa_series_16->execute(array($id_categoria));
			$res_pesquisa_series_16 = $pesquisa_series_16->fetchAll();

			if($res_pesquisa_series_16_Livre == null && $res_pesquisa_series_16_10 == null && $res_pesquisa_series_16_12 == null
				&& $res_pesquisa_series_16_14 == null && $res_pesquisa_series_16 == null){
				echo "<script>window.alert('Não existe series nessa categoria');
				window.location.href = 'addSerie.php?pg=series16&id_cliente=$id_cliente'</script>";
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
				<button type="submit" class="btn btn-success pesquisar" name="pesquisarSerie16">Pesquisar</button>
			</div>
			<div class="form-group col-md-6 pesquisarFilme">
				<i>Lista de series recomendados de acordo com sua idade</i>
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
				foreach ($res_pesquisa_series_16_Livre as $key => $value) {
					$id_serie = $value['id_serie'];
					$nome_serie = $value['nome_serie'];
					$classificacao_serie = $value['classificacao_serie'];
					$categoria_serie = $value['nome_categoria'];
			?>
			<tr>
				
				<td><?php echo $nome_serie; ?></td>
				<td><?php echo $categoria_serie; ?></td>
				<td><?php echo $classificacao_serie; ?></td>
				<td>
				 	<a href="addSerie.php?pg=addLista&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addSerie.php?pg=favorito&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoSeriePDF.php?id_serie=<?php echo $id_serie; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_pesquisa_series_16_10 as $key => $value) {
					$id_serie = $value['id_serie'];
					$nome_serie = $value['nome_serie'];
					$classificacao_serie = $value['classificacao_serie'];
					$categoria_serie = $value['nome_categoria'];
				
			?>
			<tr>
				
				<td><?php echo $nome_serie; ?></td>
				<td><?php echo $categoria_serie; ?></td>
				<td><?php echo $classificacao_serie; ?></td>
				<td>
				 	<a href="addSerie.php?pg=addLista&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addSerie.php?pg=favorito&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoSeriePDF.php?id_serie=<?php echo $id_serie; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_pesquisa_series_16_12 as $key => $value) {
					$id_serie = $value['id_serie'];
					$nome_serie = $value['nome_serie'];
					$classificacao_serie = $value['classificacao_serie'];
					$categoria_serie = $value['nome_categoria'];
				
			?>
			<tr>
				
				<td><?php echo $nome_serie; ?></td>
				<td><?php echo $categoria_serie; ?></td>
				<td><?php echo $classificacao_serie; ?></td>
				<td>
				 	<a href="addSerie.php?pg=addLista&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addSerie.php?pg=favorito&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoSeriePDF.php?id_serie=<?php echo $id_serie; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_pesquisa_series_16_14 as $key => $value) {
					$id_serie = $value['id_serie'];
					$nome_serie = $value['nome_serie'];
					$classificacao_serie = $value['classificacao_serie'];
					$categoria_serie = $value['nome_categoria'];
				
			?>
			<tr>
				
				<td><?php echo $nome_serie; ?></td>
				<td><?php echo $categoria_serie; ?></td>
				<td><?php echo $classificacao_serie; ?></td>
				<td>
				 	<a href="addSerie.php?pg=addLista&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addSerie.php?pg=favorito&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoSeriePDF.php?id_serie=<?php echo $id_serie; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>

			<?php 
				foreach ($res_pesquisa_series_16 as $key => $value) {
					$id_serie = $value['id_serie'];
					$nome_serie = $value['nome_serie'];
					$classificacao_serie = $value['classificacao_serie'];
					$categoria_serie = $value['nome_categoria'];
				
			?>
			<tr>
				<td><?php echo $nome_serie; ?></td>
				<td><?php echo $categoria_serie; ?></td>
				<td><?php echo $classificacao_serie; ?></td>
				<td>
				 	<a href="addSerie.php?pg=addLista&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-danger my-2" >Adicionar a lista</a>
					<a href="addSerie.php?pg=favorito&id_serie=<?php echo $id_serie; ?>&id_cliente=<?php echo $id_cliente; ?>" class="btn btn-info my-2" >Adicionar a favoritos</a>
					<a href="informacaoSeriePDF.php?id_serie=<?php echo $id_serie; ?>" class="btn btn-warning my-2" >Descrição completa</a>
				</td>
			
			 </tr>
			<?php } ?>
		</tbody>
	</table>
<?php } } ?>
<!--MOSTRANDO PESQUISA SERIES 16----------------------------------------------------------------------------------------------------->




<!--ADICIONANDO SERIE A LISTA----------------------------------------------------------------------------------------------------->
	<?php
		if(@$_GET['pg'] == 'addLista'){
			$id_serie = $_GET['id_serie'];
			$id_cliente = $_GET['id_cliente'];
			

			$quantidade_dados = count($res_selecionar_lista_filme) + count($res_selecionar_lista_serie);

			$lista_serie = $pdo->prepare("SELECT * FROM listaserie WHERE serie_id=? AND cliente_id=?");
			$lista_serie->execute(array($id_serie,$id_cliente));
			$res = $lista_serie->fetchAll();


			if($res == null){
				/* MODELO DE COMO FAZER PARA NÃO DEIXAR SALVAR MAIS DADOS NO BANCO CASO PASSE DO LIMITE DO PLANO DO CLIENTE*/
				if($nome_plano == 'Plano Basico'){
					if($quantidade_dados < 5){
						$salvar_filme_lista = $pdo->prepare("INSERT INTO listaserie (serie_id,cliente_id) VALUES (?,?) ");
						$salvar_filme_lista->execute(array($id_serie,$id_cliente));
						if($salvar_filme_lista == true){
							echo "<script>window.alert('Série adicionada a lista');
							window.location.href = 'painelCliente.php?id_cliente=$id_cliente'</script>";
						}
					}else{
						echo "<script>window.alert('Você chegou no limite de filmes e séries adicionados, troque para o (Plano Platino ou Plano Ouro) ');window.location.href = 'painelCliente.php?id_cliente=$id_cliente'</script>";
					}
				}else if($nome_plano == 'Plano Platino'){
					if($quantidade_dados < 10){
						$salvar_filme_lista = $pdo->prepare("INSERT INTO listaserie (serie_id,cliente_id) VALUES (?,?) ");
						$salvar_filme_lista->execute(array($id_serie,$id_cliente));
						if($salvar_filme_lista == true){
							echo "<script>window.alert('Série adicionada a lista');
							window.location.href = 'painelCliente.php?id_cliente=$id_cliente'</script>";
						}
					}else{
						echo "<script>window.alert('Você chegou no limite de filmes e séries adicionados, troque para o (Plano Ouro) ');
						window.location.href = 'painelCliente.php?id_cliente=$id_cliente'</script>";
					}

				}else if($nome_plano == 'Plano Ouro'){
					$salvar_filme_lista = $pdo->prepare("INSERT INTO listaserie (serie_id,cliente_id) VALUES (?,?) ");
					$salvar_filme_lista->execute(array($id_serie,$id_cliente));
					if($salvar_filme_lista == true){
							echo "<script>window.alert('Série adicionada a lista');
							window.location.href = 'painelCliente.php?id_cliente=$id_cliente'</script>";
					}
				}
			}else{
				echo "<script>window.alert('Você já adicionou essa série a sua lista');
					window.location.href = 'painelCliente.php?id_cliente=$id_cliente'</script>";
				
			}
		}

	?>
<!--ADICIONANDO SERIE A LISTA----------------------------------------------------------------------------------------------------->


<!--ADICIONANDO SERIE A FAVORITOS----------------------------------------------------------------------------------------------------->
	<?php
		if(@$_GET['pg'] == 'favorito'){
			$id_cliente = $_GET['id_cliente'];
			$id_serie = $_GET['id_serie'];

			$series_favoritos = $pdo->prepare("SELECT * FROM seriefavorita WHERE serie_id=? AND cliente_id=?");
			$series_favoritos->execute(array($id_serie,$id_cliente));
			$res = $series_favoritos->fetchAll();

			if($res == null){
				$salvar_favorito = $pdo->prepare("INSERT INTO seriefavorita (serie_id,cliente_id) VALUES(?,?) ");
				$salvar_favorito->execute(array($id_serie,$id_cliente));

				if($salvar_favorito == true){
					echo "<script>window.alert('Série adicionada aos favoritos');
							window.location.href = 'painelCliente.php?id_cliente=$id_cliente'</script>";
				}
			}else{
				echo "<script>window.alert('Você já adicionou essa série aos favoritos');
					window.location.href = 'painelCliente.php?id_cliente=$id_cliente'</script>";
			}
		}

	?>

<!--ADICIONANDO SERIE A FAVORITOS----------------------------------------------------------------------------------------------------->





</div>

	
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>