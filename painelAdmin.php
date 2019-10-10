<?php
	include 'conexao.php';


	$id_Admin = @$_GET['id_Admin'];
	


	$sql_admin = $pdo->prepare("SELECT * FROM admin WHERE id_admin=?");
	$sql_admin->execute(array($id_Admin));
	$res = $sql_admin->fetchAll();
	foreach ($res as $key => $value) {
		$nome_admin = $value['nome_admin'];
	}


	$sql_categoria = $pdo->prepare("SELECT * FROM categoria");
	$sql_categoria->execute();
	$res_categoria = $sql_categoria->fetchAll();
	
	$buscar_filme = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria ON `filme`.`categoria_id` = `categoria`.`id_categoria`");
	$buscar_filme->execute();
	$res_busca_filme = $buscar_filme->fetchAll();

	if(isset($_POST['salvarFilme'])){
		$nome_filme = $_POST['nome'];
		$categoria_filme = $_POST['categoria'];
		$classificacao_filme = $_POST['classificacao'];
		$descricao_filme = $_POST['descricao'];

		$salvar_filme = $pdo->prepare("INSERT INTO filme (nome_filme,classificacao_filme,descricao_filme,categoria_id) VALUES(?,?,?,?) ");
		$salvar_filme->execute(array($nome_filme,$classificacao_filme,$descricao_filme,$categoria_filme));

		if($salvar_filme == true){
			echo "<script language='javascript'>window.alert('$nome_filme salvo com sucesso');
			window.location.href = 'painelAdmin.php?id_Admin=$id_Admin'</script>";
		}
	}
	
	if(isset($_POST['editaFilme'])){

		$id_filme = $_GET['id_filme'];
		$nome_filme = $_POST['nome'];
		$categoria_filme = $_POST['categoria'];
		$classificacao_filme = $_POST['classificacao'];

		$edita_filme = $pdo->prepare("UPDATE filme SET nome_filme=?, classificacao_filme=?, categoria_id=? 
		WHERE id_filme=?");
		$edita_filme->execute(array($nome_filme,$classificacao_filme,$categoria_filme,$id_filme));

		if($edita_filme == true){
			echo "<script language = 'javascript'> window.alert('Filme alterado com sucesso');
			window.location.href = 'painelAdmin.php?pg=listaFilme&id_Admin=$id_Admin'</script>";
		}else{
			echo "<script language = 'javascript'> window.alert('Erro ao alterar filme');</script>";
		}
	}
		
	if (isset($_POST['salvarSerie'])) {
		$nome_serie = $_POST['nome'];
		$categoria_serie = $_POST['categoria'];
		$classificacao_serie = $_POST['classificacao'];
		$descricao_serie = $_POST['descricao'];

		$salva_serie = $pdo->prepare("INSERT INTO serie (nome_serie,classificacao_serie,descricao_serie,categoria_id) 
			VALUES(?,?,?,?)");
		$salva_serie->execute(array($nome_serie,$classificacao_serie,$descricao_serie,$categoria_serie));
		if($salva_serie == true){
			echo "<script language='javascript'>window.alert('$nome_serie salvo com sucesso');
			window.location.href = 'painelAdmin.php?id_Admin=$id_Admin'</script>";
		}
	}

	$busca_serie = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria ON `serie`.`categoria_id` = 
		`categoria`.`id_categoria`");
	$busca_serie->execute();
	$res_busca_serie = $busca_serie->fetchAll();

	if(isset($_POST['editaSerie'])){
		$id_serie = $_GET['id_Serie'];
		$nome_serie = $_POST['nome'];
		$categoria_serie = $_POST['categoria'];
		$classificacao_serie = $_POST['classificacao'];

		$edita_serie = $pdo->prepare("UPDATE serie SET nome_serie=?, classificacao_serie=?, categoria_id=? 
			WHERE id_serie=?");
		$edita_serie->execute(array($nome_serie,$classificacao_serie,$categoria_serie,$id_serie));
		if($edita_serie == true){
			echo "<script language = 'javascript'> window.alert('Serie alterada com sucesso');
			window.location.href = 'painelAdmin.php?pg=listaSerie&id_Admin=$id_Admin'</script>";
		}
	}

	if(isset($_POST['pesquisar'])){
		$categoria = $_POST['categoria'];

		echo "<script>window.location.href = 'painelAdmin.php?pg=pesquisa&id_categoria=$categoria&id_Admin=$id_Admin'</script>";
	}

	if(isset($_POST['pesquisarSerie'])){
		$categoria = $_POST['categoria'];
		echo "<script>window.location.href = 'painelAdmin.php?pg=pesquisaSerie&id_categoria=$categoria&id_Admin=$id_Admin'</script>";
	}

	if(isset($_POST['salvarCategoria'])){
		$nome_categoria = $_POST['nome'];
		$salvar_categoria = $pdo->prepare("INSERT INTO categoria (nome_categoria) VALUES(?)");
		$salvar_categoria->execute(array($nome_categoria));

		if($salvar_categoria == true){
			echo "<script>window.alert('Nova categoria salva com sucesso');
			window.location.href = 'painelAdmin.php?id_Admin=$id_Admin'</script>";
		}
	}

	$buscar_cliente = $pdo->prepare("SELECT * FROM cliente INNER JOIN plano ON `cliente`.`plano_id` = `plano`.`id_plano`");
	$buscar_cliente->execute();
	$res_buscar_cliente = $buscar_cliente->fetchAll();


?>
<!DOCTYPE html>
<html>
<head>
	<title>Painel Administrador</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/myStyle.css">
	<title>Locadora - Matuzalém</title>
</head>
<body>
	<!--NAVBAR----------------------------------------------------------------------------------------------------->
	<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
	  <a class="navbar-brand" href="index.php">MATUSALÈM</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>
	  <div class="collapse navbar-collapse" id="navbarNav">
	    <ul class="navbar-nav">
	      	<li class="nav-item">
	        	<a class="nav-link" href="painelAdmin.php?pg=filme&id_Admin=<?php echo $id_Admin; ?>">Adicionar Filmes</a>
	      	</li>
	     	 <li class="nav-item">
	        	<a class="nav-link" href="painelAdmin.php?pg=serie&id_Admin=<?php echo $id_Admin; ?>">Adicionar Séries</a>
	      	</li>
	      	<li class="nav-item">
	        	<a class="nav-link" href="" data-toggle="modal" data-target="#exampleModal">Adicionar Categorias</a>
	     	 </li>
	     	  <li class="nav-item">
	        	<a class="nav-link" href="painelAdmin.php?pg=cliente&id_Admin=<?php echo $id_Admin; ?>">Clientes</a>
	      	</li>
	       <li class="nav-item">
	        	<a class="nav-link" href="index.php">Sair</a>
	      	</li>
	    </ul>
	  </div>
	</nav>
	<br>
<!--NAVBAR----------------------------------------------------------------------------------------------------->


<!-- MODAl SALVAR CATEGORIA---------------------------------------------------------------------------------------- -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Adicionar uma categoria de filmes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        	<form method="POST" enctype="multipart/form-data">
			<div class="form-group">
				<label for="inputCity">Nome</label>
				<input type="text" class="form-control" id="inputCity" required name="nome" placeholder="Digite aqui o nome da categoria">
			</div>
		</div>
      	<div class="modal-footer">
      		<button type="submit" class="btn btn-success" name="salvarCategoria">Salvar</button>
      		</form>
        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
        </div>
      
    </div>
  </div>
</div>
<!-- MODAl SALVAR CATEGORIA---------------------------------------------------------------------------------------- -->



	<div class="container">
		<div class="list-group">
			<a href="painelAdmin.php?pg=listaFilme&id_Admin=<?php echo $id_Admin; ?>" class="list-group-item list-group-item-action">Listar todos os filmes</a>
			<a href="painelAdmin.php?pg=listaSerie&id_Admin=<?php echo $id_Admin; ?>" class="list-group-item list-group-item-action">Listar todas as séries</a>
		</div>

 		<p class="font-weight-bold"><i><h1>Bem Vindo <?php echo $nome_admin; ?></h1></i></p>
 		<span class="font-weight-bold text-primary"><i>Administrador(a)</i></span>	
 		<hr>


 		<!--ADICIONAR FILMES------------------------------------------------------------------------------------->
 			<?php
 				if(@$_GET['pg'] == 'filme'){
 			?>
 				<div class="alert alert-dark" role="alert">
  					Adicionar Filme
				</div>

 				<form method="POST" enctype="multipart/form-data">
					<div class="form-row">
					    <div class="form-group col-md-5">
						    <label for="inputCity">Nome</label>
						    <input type="text" class="form-control" id="inputCity" required name="nome">
					    </div>

					    <div class="form-group col-md-3">
						    <label for="inputState">Categoria</label>
						    <select id="inputState" class="form-control" required name="categoria">
						    	<?php 
						    		foreach ($res_categoria as $key => $value) {
						    			$id_categoria = $value['id_categoria'];
						    			$nome_categoria = $value['nome_categoria'];
						    	?>
						    	<option value="<?php echo $id_categoria; ?>"><?php echo $nome_categoria; ?></option>
						    	<?php  } ?>
						     </select>
					    </div>
					    
					   <div class="form-group col-md-4">
						    <label for="inputState">Classificação</label>
						    <select id="inputState" class="form-control" required name="classificacao">
						    	<option></option>
						    	<option value="Livre">Livre para todos os publicos</option>
						        <option value="10">Proibido para menores de 10 anos</option>
						        <option value="12">Proibido para menores de 12 anos</option>
						        <option value="14">Proibido para menores de 14 anos</option>
						        <option value="16">Proibido para menores de 16 anos</option>
						        <option value="18">Proibido para menores de 18 anos</option>
						        </select>
						    </div>
					</div>

					<div class="form-group">
					    <label for="exampleFormControlTextarea1">Uma breve descrição do filme</label>
					    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" required name="descricao"></textarea>
  					</div>
						<button type="submit" class="btn btn-success" name="salvarFilme">Salvar</button>
				</form>
			<?php } ?>
 		<!--ADICIONAR FILMES------------------------------------------------------------------------------------->


 		<!--LISTAR FILMES------------------------------------------------------------------------------------->
 			<?php if(@$_GET['pg'] == 'listaFilme'){
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
				      	<button type="submit" class="btn btn-dark pesquisar" name="pesquisar">Pesquisar</button>
					</div>

					 <div class="form-group col-md-2 baixarLista">
				      	<a href="FilmesPDF.php" class="btn btn-success my-2 BaixarLista" >Baixar lista</a>
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
						foreach ($res_busca_filme as $key => $value) {
							$id_filme = $value['id_filme'];
							$nome_filme = $value['nome_filme'];
							$classificacao_filme = $value['classificacao_filme'];
							$categoria_filme = $value['nome_categoria'];
					?>
				    <tr>
				      <td><?php echo $nome_filme; ?></td>
				      <td><?php echo $categoria_filme; ?></td>
				      <td><?php echo $classificacao_filme; ?></td>
				      <td><a href="painelAdmin.php?pg=editaFilme&id_filme=<?php echo $id_filme; ?>&id_Admin=<?php echo $id_Admin; ?>" class="btn btn-danger my-2" >Editar</a>
				      <a href="painelAdmin.php?pg=excluiFilme&id_filme=<?php echo $id_filme; ?>&id_Admin=<?php echo $id_Admin; ?>" class="btn btn-info my-2" >Excluir</a>
				      </td>

				    </tr>
				<?php } ?>
				</tbody>
			</table>
		<?php } ?>
 		<!--LISTAR FILMES---------------------------------------------------------------------------------------->


 		<!--PESQUISAR FILMES---------------------------------------------------------------------------------------->
 			<?php
 				if(@$_GET['pg'] == 'pesquisa'){
 					$id_categoria = $_GET['id_categoria'];


				$pesquisar_filme_categoria = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria WHERE categoria_id=? 
					AND `filme`.`categoria_id` = `categoria`.`id_categoria`");
				$pesquisar_filme_categoria->execute(array($id_categoria));
				$res_pesquisar_filme_categoria = $pesquisar_filme_categoria->fetchAll();

		
				if($res_pesquisar_filme_categoria == null){
					echo "<script>window.alert('Não existe filmes nessa categoria');
					window.location.href = 'painelAdmin.php?pg=listaFilme&id_Admin=$id_Admin'</script>";
				}else {
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
				      	<button type="submit" class="btn btn-dark pesquisar" name="pesquisar">Pesquisar</button>
					</div>
				</div>
				<hr>
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
						foreach ($res_pesquisar_filme_categoria as $key => $value) {
							$id_filme = $value['id_filme'];
							$nome_filme = $value['nome_filme'];
							$classificacao_filme = $value['classificacao_filme'];
							$categoria_filme = $value['nome_categoria'];
					?>
				    <tr>
				      <td><?php echo $nome_filme; ?></td>
				      <td><?php echo $categoria_filme; ?></td>
				      <td><?php echo $classificacao_filme; ?></td>
				      <td><a href="painelAdmin.php?pg=editaFilme&id_filme=<?php echo $id_filme; ?>&id_Admin=<?php echo $id_Admin; ?>" class="btn btn-danger my-2" >Editar</a>
				      <a href="painelAdmin.php?pg=excluiFilme&id_filme=<?php echo $id_filme; ?>&id_Admin=<?php echo $id_Admin; ?>" class="btn btn-info my-2" >Excluir</a>
				      </td>

				    </tr>
				<?php } ?>
				</tbody>
			</table>
 			<?php } } ?>
 		<!--PESQUISAR FILMES---------------------------------------------------------------------------------------->


		<!--EDITAR FILMES---------------------------------------------------------------------------------------->
		<?php 
			if(@$_GET['pg'] == 'editaFilme'){
				$id_filme  = $_GET['id_filme'];
				$busca_filme = $pdo->prepare("SELECT * FROM filme INNER JOIN categoria WHERE id_filme = ? 
				AND `filme`.`categoria_id` = `categoria`.`id_categoria`");
				$busca_filme->execute(array($id_filme));
				$res_busca_filme = $busca_filme->fetchAll();
				foreach ($res_busca_filme as $key => $value) {
					$nome_filme = $value['nome_filme'];
					$categoria_filme = $value['nome_categoria'];
					$classificacao_filme = $value['classificacao_filme'];
					$descricao_filme = $value['descricao_filme'];
					$id_categoria = $value['id_categoria'];
				}
						 

		?>
				<div class="alert alert-dark" role="alert">
  					Editar Filme
				</div>

 				<form method="POST" enctype="multipart/form-data">
					<div class="form-row">
					    <div class="form-group col-md-5">
						    <label for="inputCity">Nome</label>
						    <input type="text" class="form-control" id="inputCity" required name="nome" value="<?php echo $nome_filme; ?>">
					    </div>

					    <div class="form-group col-md-3">
						    <label for="inputState">Categoria</label>
						    <select id="inputState" class="form-control" required name="categoria">
						    <?php 
						    	foreach ($res_busca_filme as $key => $value) {
									$nome_filme = $value['nome_filme'];
									$categoria_filme = $value['nome_categoria'];
									$classificacao_filme = $value['classificacao_filme'];
									$descricao_filme = $value['descricao_filme'];
									$id_categoria = $value['id_categoria'];
								?>
						   
						    	<option value="<?php echo $id_categoria; ?>">Atual - <?php echo $categoria_filme ?></option>
						    <?php } ?>
						    	<option>---------------------------------</option>
						    	<?php 
						    		foreach ($res_categoria as $key => $value) {
						    			$id_categoria = $value['id_categoria'];
						    			$nome_categoria = $value['nome_categoria'];
						    	?>
						    	<option value="<?php echo $id_categoria; ?>"><?php echo $nome_categoria; ?></option>
						    <?php } ?>
						     </select>
					    </div>
					    
					   <div class="form-group col-md-4">
						    <label for="inputState">Classificação</label>
						    <select id="inputState" class="form-control" required name="classificacao">
						    	<?php 
						    	foreach ($res_busca_filme as $key => $value) {
									$nome_filme = $value['nome_filme'];
									$categoria_filme = $value['nome_categoria'];
									$classificacao_filme = $value['classificacao_filme'];
									$descricao_filme = $value['descricao_filme'];
									$id_categoria = $value['id_categoria'];
								?>
						    	<option value="<?php echo $classificacao_filme; ?>">Atual - <?php echo $classificacao_filme ?>
						    	</option>
						    	<?php } ?>
						    	<option>--------------------------</option>
						    	<option value="Livre">Livre para todos os publicos</option>
						        <option value="10">Proibido para menores de 10 anos</option>
						        <option value="12">Proibido para menores de 12 anos</option>
						        <option value="14">Proibido para menores de 14 anos</option>
						        <option value="16">Proibido para menores de 16 anos</option>
						        <option value="18">Proibido para menores de 18 anos</option>
						        </select>
						    </div>
					</div>
						<button type="submit" class="btn btn-success" name="editaFilme">Salvar</button>
				</form>
		<?php } ?>
		<!--EDITAR FILMES---------------------------------------------------------------------------------------->


		<!--EXCLUIR FILMES---------------------------------------------------------------------------------------->
			<?php
				if(@$_GET['pg'] == 'excluiFilme'){
					$id_filme = $_GET['id_filme'];	
					
					$deleta_filme_lista = $pdo->prepare("DELETE FROM listafilme WHERE filme_id=?");
					$deleta_filme_lista->execute(array($id_filme));

					$deleta_filme_favorito = $pdo->prepare("DELETE FROM filmefavorito WHERE filme_id=?");
					$deleta_filme_favorito->execute(array($id_filme));

					if($deleta_filme_lista == true && $deleta_filme_favorito == true){
						$deleta_filme = $pdo->prepare("DELETE FROM filme WHERE id_filme=?");
						$deleta_filme->execute(array($id_filme));

						
						if($deleta_filme == true ){
							echo "<script language = 'javascript'> window.alert('Filme excluido com sucesso');
							window.location.href = 'painelAdmin.php?pg=listaFilme&id_Admin=$id_Admin'</script>";
						}
					}
					
					
				}
			?>
		<!--EXCLUIR FILMES---------------------------------------------------------------------------------------->










 		<!--ADICIONAR SERIES------------------------------------------------------------------------------------->
 			<?php
 				if(@$_GET['pg'] == 'serie'){
 			?>
 				<div class="alert alert-dark" role="alert">
  					Adicionar Série
				</div>

					<form method="POST" enctype="multipart/form-data">

					<div class="form-row">
					    <div class="form-group col-md-5">
						    <label for="inputCity">Nome</label>
						    <input type="text" class="form-control" id="inputCity" required name="nome">
					    </div>

					    <div class="form-group col-md-3">
						    <label for="inputState">Categoria</label>
						    <select id="inputState" class="form-control" required name="categoria">	
						    	<?php
						    		foreach ($res_categoria as $key => $value) {
						    			$id_categoria = $value['id_categoria'];
						    			$nome_categoria = $value['nome_categoria'];						
						    	?>
						    	<option value="<?php echo $id_categoria; ?>"><?php echo $nome_categoria; ?></option>
						    <?php } ?>
						     </select>
					    </div>
					    
					   <div class="form-group col-md-4">
						    <label for="inputState">Classificação</label>
						    <select id="inputState" class="form-control" required name="classificacao">
						    	<option></option>
						    	<option value="Livre">Livre para todos os publicos</option>
						        <option value="10">Proibido para menores de 10 anos</option>
						        <option value="12">Proibido para menores de 12 anos</option>
						        <option value="14">Proibido para menores de 14 anos</option>
						        <option value="16">Proibido para menores de 16 anos</option>
						        <option value="18">Proibido para menores de 18 anos</option>
						        </select>
						    </div>
					</div>

					<div class="form-group">
					    <label for="exampleFormControlTextarea1">Uma breve descrição da Série</label>
					    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" required name="descricao"></textarea>
  					</div>
						<button type="submit" class="btn btn-success" name="salvarSerie">Salvar</button>
				</form>
 			<?php } ?>
 		<!--ADICIONAR SERIES------------------------------------------------------------------------------------->


 		<!--LISTAR SERIES----------------------------------------------------------------------------------------->
 			<?php
 				if(@$_GET['pg'] == 'listaSerie'){
 			?>
 			<div class="form-row">   
				<div class="form-group col-md-4">
					<form method="POST" enctype="multipart/form-data">
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
				      	<button type="submit" class="btn btn-dark pesquisar" name="pesquisarSerie">Pesquisar</button>
					</div>

					 <div class="form-group col-md-2 baixarLista">
				      	<a href="SeriesPDF.php" class="btn btn-success my-2 BaixarLista" >Baixar lista</a>
					</div>
				</form>

				</div>

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
						foreach ($res_busca_serie as $key => $value) {
							$id_serie = $value['id_serie'];
							$nome_serie = $value['nome_serie'];
							$categoria_serie = $value['nome_categoria'];
							$classificacao_serie = $value['classificacao_serie'];
						
					?>
				    <tr>
				      <td><?php echo $nome_serie; ?></td>
				      <td><?php echo $categoria_serie ?></td>
				      <td><?php echo $classificacao_serie;  ?></td>
				      <td><a href="painelAdmin.php?pg=editaSerie&id_Serie=<?php echo $id_serie; ?>&id_Admin=<?php echo $id_Admin; ?>" class="btn btn-danger my-2" >Editar</a>
				      <a href="painelAdmin.php?pg=excluiSerie&id_Serie=<?php echo $id_serie; ?>&id_Admin=<?php echo $id_Admin; ?>" class="btn btn-info my-2" >Excluir</a>
				      </td>
				    </tr>
				<?php } ?>
				</tbody>
			</table>
 			<?php } ?>

 		<!--LISTAR SERIES----------------------------------------------------------------------------------------->


 		<!--PESQUISAR SERIES---------------------------------------------------------------------------------------->
 			<?php
 				if(@$_GET['pg'] == 'pesquisaSerie'){
 					$id_categoria = $_GET['id_categoria'];


				$pesquisar_serie_categoria = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria WHERE categoria_id=? 
					AND `serie`.`categoria_id` = `categoria`.`id_categoria`");
				$pesquisar_serie_categoria->execute(array($id_categoria));

				$res_pesquisar_serie_categoria = $pesquisar_serie_categoria->fetchAll();

		
				if($res_pesquisar_serie_categoria == null){
					echo "<script>window.alert('Não existe séries nessa categoria');
					window.location.href = 'painelAdmin.php?pg=listaSerie&id_Admin=$id_Admin'</script>";
				}else {
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
				      	<button type="submit" class="btn btn-dark pesquisar" name="pesquisar">Pesquisar</button>
					</div>
				</div>
				<hr>
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
						foreach ($res_pesquisar_serie_categoria as $key => $value) {
							$id_serie = $value['id_serie'];
							$nome_serie = $value['nome_serie'];
							$classificacao_serie = $value['classificacao_serie'];
							$categoria_serie = $value['nome_categoria'];
					?>
				    <tr>
				      <td><?php echo $nome_serie; ?></td>
				      <td><?php echo $categoria_serie; ?></td>
				      <td><?php echo $classificacao_serie; ?></td>
				      <td><a href="painelAdmin.php?pg=editaSerie&id_Serie=<?php echo $id_serie; ?>&id_Admin=<?php echo $id_Admin; ?>" class="btn btn-danger my-2" >Editar</a>
				      <a href="painelAdmin.php?pg=excluiSerie&id_Serie=<?php echo $id_serie; ?>&id_Admin=<?php echo $id_Admin; ?>" class="btn btn-info my-2" >Excluir</a>
				      </td>

				    </tr>
				<?php } ?>
				</tbody>
			</table>
 			<?php } } ?>
 		<!--PESQUISAR SERIES---------------------------------------------------------------------------------------->


 		<!--EDITAR SERIES----------------------------------------------------------------------------------------->
 			<?php 
 				if(@$_GET['pg'] == 'editaSerie'){
 					$id_serie = $_GET['id_Serie'];
 					$edita_serie = $pdo->prepare("SELECT * FROM serie INNER JOIN categoria WHERE id_serie=? AND `serie`.`categoria_id` = `categoria`.`id_categoria`");
 					$edita_serie->execute(array($id_serie));
 					$res_edita_serie = $edita_serie->fetchAll();
 					foreach ($res_edita_serie as $key => $value) {
 						$nome_serie = $value['nome_serie'];
 					}
 			?>
 						<div class="alert alert-dark" role="alert">
  					Editar Serie
				</div>

 				<form method="POST" enctype="multipart/form-data">
					<div class="form-row">
					    <div class="form-group col-md-5">
						    <label for="inputCity">Nome</label>
						    <input type="text" class="form-control" id="inputCity" required name="nome" value="<?php echo $nome_serie; ?>">
					    </div>

					    <div class="form-group col-md-3">
						    <label for="inputState">Categoria</label>
						    <select id="inputState" class="form-control" required name="categoria">
						    <?php 
						    	foreach ($res_edita_serie as $key => $value) {
									$nome_serie = $value['nome_serie'];
									$categoria_serie = $value['nome_categoria'];
									$classificacao_serie = $value['classificacao_serie'];
									$descricao_serie = $value['descricao_serie'];
									$id_categoria = $value['id_categoria'];
								?>
						   
						    	<option value="<?php echo $id_categoria; ?>">Atual - <?php echo $categoria_serie ?></option>
						    <?php } ?>
						    	<option>---------------------------------</option>
						    	<?php 
						    		foreach ($res_categoria as $key => $value) {
						    			$id_categoria = $value['id_categoria'];
						    			$nome_categoria = $value['nome_categoria'];
						    	?>
						    	<option value="<?php echo $id_categoria; ?>"><?php echo $nome_categoria; ?></option>
						    <?php } ?>
						     </select>
					    </div>
					    
					   <div class="form-group col-md-4">
						    <label for="inputState">Classificação</label>
						    <select id="inputState" class="form-control" required name="classificacao">
						    	<?php 
						    	foreach ($res_edita_serie as $key => $value) {
									$nome_serie = $value['nome_serie'];
									$categoria_serie = $value['nome_categoria'];
									$classificacao_serie = $value['classificacao_serie'];
									$id_categoria = $value['id_categoria'];
								?>
						    	<option value="<?php echo $classificacao_serie; ?>">
						    		Atual - <?php echo $classificacao_serie; ?></option>
						    	<?php } ?>
						    	<option>--------------------------</option>
						    	<option value="Livre">Livre para todos os publicos</option>
						        <option value="10">Proibido para menores de 10 anos</option>
						        <option value="12">Proibido para menores de 12 anos</option>
						        <option value="14">Proibido para menores de 14 anos</option>
						        <option value="16">Proibido para menores de 16 anos</option>
						        <option value="18">Proibido para menores de 18 anos</option>
						        </select>
						    </div>
					</div>
						<button type="submit" class="btn btn-success" name="editaSerie">Salvar</button>
				</form>
 			<?php } ?> 
		<!--EDITAR SERIES----------------------------------------------------------------------------------------->

		<!--EXCLUIR SERIES----------------------------------------------------------------------------------------->
			<?php
				if(@$_GET['pg'] == 'excluiSerie'){
					$id_serie = $_GET['id_Serie'];	
					
					$deleta_serie_lista = $pdo->prepare("DELETE FROM listaserie WHERE serie_id=?");
					$deleta_serie_lista->execute(array($id_serie));

					$deleta_serie_favorito = $pdo->prepare("DELETE FROM seriefavorita WHERE serie_id=?");
					$deleta_serie_favorito->execute(array($id_serie));

					if($deleta_serie_lista == true && $deleta_serie_favorito == true){
						$deleta_serie = $pdo->prepare("DELETE FROM serie WHERE id_serie=?");
						$deleta_serie->execute(array($id_serie));

						if($deleta_serie == true){
							echo "<script language = 'javascript'> window.alert('Serie excluida com sucesso');
							window.location.href = 'painelAdmin.php?pg=listaSerie&id_Admin=$id_Admin'</script>";
						}
					}
				}

			?>
		<!--EXCLUIR SERIES----------------------------------------------------------------------------------------->










 		<!--MOSTRAR CLIENTES------------------------------------------------------------------------------------->
 			<?php
 				if(@$_GET['pg'] == 'cliente'){
 			?>
 				<div class="alert alert-dark" role="alert">
  					Clientes cadastrados
				</div>
				<div class="form-row">
					    <div class="form-group col-md-5">
						    <a href="clientesPDF.php" class="btn btn-success my-2" >Baixar lista</a>
					    </div>		   
				</div>

 			<table class="table">
				<thead>
				    <tr>
				      <th scope="col">Nome</th>
				      <th scope="col">Telefone</th>
				      <th scope="col">Email</th>
				      <th scope="col">Plano</d>
				    </tr>
				</thead>
				<tbody>
					<?php 
						foreach ($res_buscar_cliente as $key => $value) {
							$id_cliente = $value['id_cliente'];
							$nome_cliente = $value['nome_cliente'];
							$telefone_cliente = $value['telefone_cliente'];
							$email_cliente = $value['email_cliente'];
							$plano_cliente = $value['nome_plano'];
					?>
				    <tr>
				      <td><?php echo $nome_cliente; ?></td>
				      <td><?php echo $telefone_cliente; ?></td>
				      <td><?php echo $email_cliente; ?></td>
				      <td><?php echo $plano_cliente; ?></td>
				      <td>
				      <a href="painelAdmin.php?pg=excluir_cliente&id_cliente=<?php echo $id_cliente ?>&id_admin=<?php echo $id_Admin; ?>" class="btn btn-info my-2" >Excluir</a>
				      <a href="gerarPDF.php?id_cliente=<?php echo $id_cliente; ?>" class="btn btn-warning my-2">Informações</a>
				      </td>
				    </tr>
					<?php } ?>
				</tbody>
			</table>
 			<?php } ?>
 		<!--MOSTRAR CLIENTES------------------------------------------------------------------------------------->
		
		<!--EXCLUIR CLIENTES------------------------------------------------------------------------------------->
			<?php
				if(@$_GET['pg'] == 'excluir_cliente'){
					$id_cliente = $_GET['id_cliente'];
					$id_admin = $_GET['id_admin'];

					$excluir_cartao = $pdo->prepare("DELETE FROM cartao WHERE cliente_id=?");
					$excluir_cartao->execute(array($id_cliente));

					$deleta_serie_lista = $pdo->prepare("DELETE FROM listaserie WHERE cliente_id=?");
					$deleta_serie_lista->execute(array($id_cliente));

					$deleta_serie_favorito = $pdo->prepare("DELETE FROM seriefavorita WHERE cliente_id=?");
					$deleta_serie_favorito->execute(array($id_cliente));

					$deleta_filme_lista = $pdo->prepare("DELETE FROM listafilme WHERE cliente_id=?");
					$deleta_filme_lista->execute(array($id_cliente));

					$deleta_filme_favorito = $pdo->prepare("DELETE FROM filmefavorito WHERE cliente_id=?");
					$deleta_filme_favorito->execute(array($id_cliente));
					
						if($excluir_cartao == true && $deleta_serie_lista == true && $deleta_serie_favorito == true && $deleta_filme_lista == true && $deleta_filme_favorito == true){
							$excluir_cliente = $pdo->prepare("DELETE FROM cliente WHERE id_cliente=?");
							$excluir_cliente->execute(array($id_cliente));

							if($excluir_cliente == true){
							echo "<script>
						window.location.href = 'painelAdmin.php?pg=cliente&id_Admin=$id_admin'</script>";
						}
					}
				}
			?>
		<!--EXCLUIR CLIENTES------------------------------------------------------------------------------------->


	</div>

	 
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>