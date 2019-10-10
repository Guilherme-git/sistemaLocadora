<?php
	include 'conexao.php';
	$id_cliente = $_GET['id_cliente'];
	
	$selecionarCliente = $pdo->prepare("SELECT * FROM cliente WHERE id_cliente=?");
	$selecionarCliente->execute(array($id_cliente));
	$res_selecionarCliente= $selecionarCliente->fetchAll();
	foreach ($res_selecionarCliente as $key => $value) {
		$plano_id = $value['plano_id'];
		
	}
	
	if(isset($_POST['editarCartao'])){
		$titular = $_POST['titular'];
		$codigo = $_POST['codigo'];
		$validade = $_POST['validade'];
		$numero = $_POST['numero'];

		$editar_cartao = $pdo->prepare("UPDATE cartao SET titular_cartao=?,numero_cartao=?,codigo_cartao=?,validade_cartao=? WHERE cliente_id=?");
		$editar_cartao->execute(array($titular,$numero,$codigo,$validade,$id_cliente));
		if($editar_cartao == true){
			echo "<script language='javascript'>window.alert('Dados Alterados com sucesso');
			window.location.href = 'editarConta.php?id_cliente=$id_cliente'</script>";
		}
	}

	if(isset($_POST['editarPlano'])){
		$plano = $_POST['plano'];

		$editar_plano = $pdo->prepare("UPDATE cliente SET plano_id=? WHERE id_cliente=?");
		$editar_plano->execute(array($plano,$id_cliente));
		if($editar_plano == true){
			echo "<script language='javascript'>window.alert('Dados Alterados com sucesso');
			window.location.href = 'editarConta.php?id_cliente=$id_cliente'</script>";
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
	       	 	    <a class="nav-link active" href="editarConta.php?id_cliente=<?php echo $id_cliente; ?>">Conta</a>
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
        <div class="form-row">
			<div class="form-group col-md-3">
                <a href="editarConta.php?pg=cartao&id_cliente=<?php echo $id_cliente; ?>" class="alert-link">Editar Cartão</a>
			</div>
			<div class="form-group col-md-3">
                <a href="editarConta.php?pg=plano&id_cliente=<?php echo $id_cliente; ?>" class="alert-link">Alterar Plano</a>
			</div>
			<div class="form-group col-md-3">
                <a href="editarConta.php?pg=dados&id_cliente=<?php echo $id_cliente; ?>" class="alert-link">Ver dados</a>
			</div>
			<div class="form-group col-md-3">
				<div class="alert alert-danger" role="alert">
					<?php
						if($plano_id == 1){
							echo "<strong>Fatura = 15,00 R$</strong>";
						}else if($plano_id == 2){
							echo "<strong>Fatura = 25,00 R$</strong>";
						}else{
							echo "<strong>Fatura = 35,00 R$</strong>";
						}
					?>
					
				</div>
			</div>
		</div>
        <hr>
  

    <?php
        if(@$_GET['pg'] == 'cartao'){
            $id_cliente = $_GET['id_cliente'];

            $sql = $pdo->prepare("SELECT * FROM cartao INNER JOIN cliente WHERE cliente_id=? AND `cartao`.`cliente_id`=`cliente`.`id_cliente`");
            $sql->execute(array($id_cliente));
            $res= $sql->fetchAll();

            foreach ($res as $key => $value) {
                $titular = $value['titular_cartao'];
                $numero = $value['numero_cartao'];
                $codigo = $value['codigo_cartao'];
                $validade = $value['validade_cartao'];
            }
    ?>
	<form action="" method="POST">
        <div class="form-row">
			<div class="form-group col-md-6">
				<label for="inputEmail4">Titular do cartão</label>
				<input type="text" class="form-control" id="inputEmail4" placeholder="Titular do cartão" name="titular" value="<?php echo $titular; ?>" required="">
			</div>
			<div class="form-group col-md-6">
				<label for="inputPassword4">Número do cartão</label>
				<input type="texte" class="form-control" id="inputPassword4" placeholder="Número do cartão" name="numero" value="<?php echo $numero; ?>" required="">
			</div>
			<div class="form-row">
				<div class="form-group col-md-6">
				    <label for="inputEmail4">Código de segurança</label>
				    <input type="text" class="form-control" id="inputEmail4" placeholder="Digite o código do cartão" name="codigo" value="<?php echo $codigo; ?>" required="">
				</div>
				<div class="form-group col-md-5">
				    <label for="inputPassword4">Validade do cartão</label>
				    <input type="texte" class="form-control" id="inputPassword4" placeholder="Validade do cartão" name="validade" value="<?php echo $validade; ?>" required="">   
                </div>
                    <button type="submit" class="btn btn-success" name="editarCartao">Editar</button>
		</div>
	</form>
        <?php } ?>




	<?php
		if(@$_GET['pg'] == 'plano'){
			$id_cliente = $_GET['id_cliente'];

			$sql = $pdo->prepare("SELECT * FROM cliente INNER JOIN plano WHERE id_cliente=? AND `cliente`.`plano_id`=`plano`.`id_plano`");
			$sql->execute(array($id_cliente));
			$res = $sql->fetchAll();
			
	?>
		<form method="POST" enctype="multipart/form-data">
			<select id="inputState" class="form-control" name="plano">
				<?php 
					foreach ($res as $key => $value) {
						$id_plano = $value['id_plano'];
						$nome_plano = $value['nome_plano'];
				?>
				<option value="<?php echo $id_plano; ?>">Plano atual - <?php echo $nome_plano; ?></option>
				<option value="">------------</option>
				<option value="1">Plano Básico</option>
				<option value="2" >Plano Platino</option>
				<option value="3" >Plano Ouro</option>
				<?php } ?>
			</select><br>
			<button type="submit" class="btn btn-success" name="editarPlano">Editar</button>
		</form>
	<?php } ?>



	<?php
		if(@$_GET['pg'] == 'dados'){
			$id_cliente = $_GET['id_cliente'];

			$sql = $pdo->prepare("SELECT * FROM cliente WHERE id_cliente=?");
			$sql->execute(array($id_cliente));
			$res = $sql->fetchAll();
			foreach ($res as $key => $value) {
				$nome_cliente = $value['nome_cliente'];
				$senha_cliente = $value['senha_cliente'];
				$email_cliente = $value['email_cliente'];
				$endereco_cliente  = $value['endereco_cliente'];
				$cidade_cliente = $value['cidade_cliente'];
				$nacimento_cliente = $value['nacimento_cliente'];
				$telefone_cliente = $value['telefone_cliente'];
			}
			$nacimento_cliente_formatado = date("d/m/Y",strtotime($nacimento_cliente));
	?>
		<h3>Dados da minha conta</h3><br>
		<form>
			<fieldset disabled>
				<div class="form-group">
					<div class="form-row">
						<div class="col-md-4 mb-3">
							<label for="disabledTextInput">Nome</label>
							<input type="text" id="disabledTextInput" class="form-control" value="<?php echo $nome_cliente; ?>">
						</div>
						<div class="col-md-4 mb-3">
							<label for="disabledTextInput">Senha</label>
							<input type="text" id="disabledTextInput" class="form-control" value="<?php echo $senha_cliente; ?>">
						</div>
						<div class="col-md-4 mb-3">
							<label for="disabledTextInput">Email</label>
							<input type="text" id="disabledTextInput" class="form-control" value="<?php echo $email_cliente; ?>">
						</div>
						<div class="col-md-4 mb-3">
							<label for="disabledTextInput">Endereço</label>
							<input type="text" id="disabledTextInput" class="form-control" value="<?php echo $endereco_cliente; ?>">
						</div>
						
						<div class="col-md-4 mb-3">
							<label for="disabledTextInput">Cidade</label>
							<input type="text" id="disabledTextInput" class="form-control" value="<?php echo $cidade_cliente; ?>">
						</div>
						<div class="col-md-4 mb-3">
							<label for="disabledTextInput">Nacimento</label>
							<input type="text" id="disabledTextInput" class="form-control" value="<?php echo $nacimento_cliente_formatado; ?>">
						</div>
						<div class="col-md-4 mb-3">
							<label for="disabledTextInput">Telefone</label>
							<input type="text" id="disabledTextInput" class="form-control" value="<?php echo $telefone_cliente; ?>">
						</div>
					</div>
					
					
				</div>
				
				
				
			</fieldset>
		</form>
	<?php } ?>
    </div>
</body>
</html>
