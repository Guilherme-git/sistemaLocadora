<?php
	include 'conexao.php';

	if(isset($_POST['salvar'])){
		$nome_cliente = $_POST['nome'];
		$senha_cliente = $_POST['senha'];
		$endereco_cliente = $_POST['endereco'];
		$email_cliente = $_POST['email'];
		$cidade_cliente = $_POST['cidade'];
		$nacimento_cliente = $_POST['nacimento'];
		$telefone_cliente = $_POST['telefone'];

		$plano = $_POST['plano'];

		$titular_cartao = $_POST['titular'];
		$numero_cartao = $_POST['numero'];
		$codigo_cartao = $_POST['codigo'];
		$validade_cartao = $_POST['validade'];

		
				$select_cartao = $pdo->prepare("SELECT * FROM cartao WHERE titular_cartao=? AND codigo_cartao=? AND numero_cartao=? 
					AND validade_cartao=?");
				$select_cartao->execute(array($titular_cartao,$codigo_cartao,$numero_cartao,$validade_cartao));
				$res_select_cartao = $select_cartao->fetchAll();

					if($res_select_cartao == null){
						$salvar_cliente = $pdo->prepare("INSERT INTO cliente (nome_cliente,senha_cliente,endereco_cliente,email_cliente,
						cidade_cliente,nacimento_cliente,telefone_cliente,plano_id) VALUES(?,?,?,?,?,?,?,?) ");
						$salvar_cliente->execute(array($nome_cliente,$senha_cliente,$endereco_cliente,$email_cliente,$cidade_cliente,
						$nacimento_cliente,$telefone_cliente,$plano));

						if($salvar_cliente == true){
							echo "<script language='javascript'>window.alert('Cliente Salvo com sucesso');</script>";
							$select_cliente = $pdo->prepare("SELECT * FROM cliente WHERE nome_cliente=? AND senha_cliente=? 
							AND email_cliente=? AND nacimento_cliente=?");
							$select_cliente->execute(array($nome_cliente,$senha_cliente,$email_cliente,$nacimento_cliente));
							$res_select_cliente = $select_cliente->fetchAll();
							foreach ($res_select_cliente as $key => $value) {
								$id_cliente = $value['id_cliente'];

							$salvar_cartao = $pdo->prepare("INSERT INTO cartao (titular_cartao,numero_cartao,codigo_cartao,validade_cartao,cliente_id) VALUES(?,?,?,?,?)");
							$salvar_cartao->execute(array($titular_cartao,$numero_cartao,$codigo_cartao,$validade_cartao,$id_cliente));
							}
						}
					}else{
							echo "<script language='javascript'>window.alert('Já existe este cartão cadastrado no sistema');</script>";

					}
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
	       	 <a class="nav-link" href="index.php">Início</a>
	      	</li>
	      	<li class="nav-item">
	        	<a class="nav-link" href="filme.php?pg=listaFilmes">Filmes</a>
	      	</li>
	     	 <li class="nav-item">
	        	<a class="nav-link" href="serie.php?pg=listaSerie">Séries</a>
	      	</li>
	      	<li class="nav-item active">
	        	<a class="nav-link" href="#">Cadastrar</a>
	     	 </li>
	       <li class="nav-item ">
	        	<a class="nav-link" href="login.php">Login</a>
	      	</li>
	    </ul>
	  </div>
	</nav>
	<br>
<!--NAVBAR----------------------------------------------------------------------------------------------------->
		<div class="container">
			<h3>Cadastro de Clientes</h3>
			<hr>
			<form method="POST" enctype="multipart/form-data">
				<div class="form-row">
				    <div class="form-group col-md-6">
				      <label for="inputEmail4">Nome</label>
				      <input type="text" class="form-control" id="inputEmail4" placeholder="Seu nome" name="nome" required="">
				    </div>
				    <div class="form-group col-md-6">
				      <label for="inputPassword4">Senha</label>
				      <input type="password" class="form-control" id="inputPassword4" placeholder="Sua senha" name="senha" required="">
				    </div>
				</div>

				<div class="form-row">
				    <div class="form-group col-md-10">
				      <label for="inputEmail4">Endereço</label>
				      <input type="text" class="form-control" id="inputEmail4" placeholder="Seu endereço" name="endereco" required="">
				    </div>
				    <div class="form-group col-md-2">
						<label for="inputState">Planos</label>
				      	<select id="inputState" class="form-control" name="plano">
					        <option value="1">Plano Básico</option>
					        <option value="2" >Plano Platino</option>
					        <option value="3" >Plano Ouro</option>
				      	</select>
				    </div>
				</div>
				<div class="form-group">
				    <label for="inputAddress2">Email</label>
				    <input type="email" class="form-control" id="inputAddress2" placeholder="Seu email" name="email" required="">
				</div>

				<div class="form-row">
				    <div class="form-group col-md-6">
				      <label for="inputCity">Cidade</label>
				      <input type="text" class="form-control" id="inputCity" placeholder="Sua cidade" name="cidade" required="">
				    </div>
				    <div class="form-group col-md-4">
				      <label for="inputState">Nacimento</label>
				      <input type="date" class="form-control" id="inputCity" placeholder="Sua cidade" name="nacimento" required="">
				    </div>
				    <div class="form-group col-md-2">
				      <label for="inputZip">Telefone</label>
				      <input type="text" class="form-control" id="inputZip" name="telefone" placeholder="Seu telelefone" required="">
				    </div>
				</div>

				<div class="form-row">
				    <div class="form-group col-md-6">
				      <label for="inputEmail4">Titular do cartão</label>
				      <input type="text" class="form-control" id="inputEmail4" placeholder="Titular do cartão" name="titular" required="">
				    </div>
				    <div class="form-group col-md-6">
				      <label for="inputPassword4">Número do cartão</label>
				      <input type="texte" class="form-control" id="inputPassword4" placeholder="Número do cartão" name="numero" required="">
				    </div>
				</div>

				<div class="form-row">
				    <div class="form-group col-md-6">
				      <label for="inputEmail4">Código de segurança</label>
				      <input type="text" class="form-control" id="inputEmail4" placeholder="Digite o código do cartão" name="codigo" required="">
				    </div>
				    <div class="form-group col-md-6">
				      <label for="inputPassword4">Validade do cartão</label>
				      <input type="texte" class="form-control" id="inputPassword4" placeholder="Validade do cartão" name="validade" required="">
				    </div>
				</div>
				
		  		<button type="submit" class="btn btn-primary" name="salvar">Salvar</button>
			</form>
		</div>
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>