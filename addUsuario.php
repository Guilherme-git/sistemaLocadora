<?php
    include 'conexao.php';
    
    $id_cliente = $_GET['id_cliente'];

    if(isset($_POST['salvar'])){
        $sql = $pdo->prepare("SELECT * FROM usuario WHERE cliente_id=?");
        $sql->execute(array($id_cliente));
        $res = $sql->fetchAll();
        if(count($res)<4){
           $nome_usuario = addslashes($_POST['nome']);
           $nacimento_usuario = addslashes($_POST['nacimento']);
           
           $salvar = $pdo->prepare("INSERT INTO usuario(nome_usuario,nacimento_usuario,cliente_id) VALUES(?,?,?)");
           $salvar->execute(array($nome_usuario,$nacimento_usuario,$id_cliente));
           if($salvar == true){
               echo "<script language='javascript'>window.alert('Usuário $nome_usuario salvo com sucesso');</script>";
           }
        }
        else if(count($res)>=4){
            echo "<script>window.alert('Você já chegou no limite de usuários cadastrados');
					window.location.href = 'painelCliente.php?id_cliente=$id_cliente'</script>";
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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

<div class="container">
			<h3>Cadastrar Usuário</h3>
			<hr>
			<form method="POST" enctype="multipart/form-data">
				<div class="form-row">
				    <div class="form-group col-md-6">
				      <label for="inputEmail4">Nome</label>
				      <input type="text" class="form-control" id="inputEmail4" placeholder="Nome do usuário" name="nome" required="">
				    </div>
                    <div class ="form-group col-md-2">
				      <label for="inputState">Nacimento</label>
				      <input type="date" class="form-control" id="inputCity" name="nacimento" required="">
                    </div>
                </div>
		  		<button type="submit" class="btn btn-primary" name="salvar">Salvar</button>
			</form>
		</div>

</body>
</html>