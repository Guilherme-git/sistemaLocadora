<?php
	include 'conexao.php';

	if (isset($_POST['entrar'])) {
		$email = $_POST['email'];
		$senha = $_POST['senha'];
		
		$sql_login = $pdo->prepare("SELECT * FROM admin WHERE email_admin=? AND senha_admin=?");
		$sql_login->execute(array($email,$senha));
		$res = $sql_login->fetchAll();
		if($res == null){
			
		}else{
			
			foreach ($res as $key => $value) {
				$id_admin = $value['id_admin'];
				header("Location: painelAdmin.php?id_Admin=$id_admin");
			}
		}
	
			
		$sql_cliente = $pdo->prepare("SELECT * FROM cliente WHERE email_cliente=? AND senha_cliente=?");
		$sql_cliente->execute(array($email,$senha));
		$res_sql_cliente = $sql_cliente->fetchAll();
		if($res_sql_cliente == null){
			echo "<script>window.alert('Você não está cadastrado');window.location.href = 'cadastroCliente.php'</script>";
		}else{
			foreach ($res_sql_cliente as $key => $value) {
				$id_cliente = $value['id_cliente'];
				header("Location: painelCliente.php?id_cliente=$id_cliente");
			}
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
	      	<li class="nav-item">
	        	<a class="nav-link" href="cadastroCliente.php">Cadastrar</a>
	     	 </li>
	       <li class="nav-item active">
	        	<a class="nav-link" href="#">Login</a>
	      	</li>
	    </ul>
	  </div>
	</nav>
	<br>
<!--NAVBAR----------------------------------------------------------------------------------------------------->
<!--LOGIN------------------------------------------------------------------------------------------------------>
	<div class="container login">
  		<form method="POST" enctype="multipart/form-data">
			<div class="form-group">
			    <label for="exampleInputEmail1">EMAIL</label>
			    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" placeholder="Digite seu email" required>
			</div>
			<div class="form-group">
			    <label for="exampleInputPassword1">SENHA</label>
			    <input type="password" class="form-control" id="exampleInputPassword1" name="senha" placeholder="Digite sua senha" required>
			</div>
			<button type="submit" class="btn btn-dark" name="entrar">Entrar</button>
		</form>
	</div>
<!--LOGIN------------------------------------------------------------------------------------------------------>


	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>