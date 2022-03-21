<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" type="text/css" href="./css/estilo.css">
    <link rel="icon" href="./imagens/icone.jpg">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Gerenciamento de Leitos Hospitalares</title>
  </head>
  <body>
	<!-- Imagem e texto -->
	<nav class="navbar sticky-top navbar-dark bg-dark">
	  <a class="navbar-brand" href="home.php">
	    <img src="./imagens/icone.jpg" width="30" height="30" class="d-inline-block align-top" alt="">
	    Gerencia Leitos
	  </a>
	</nav>

    <center>
    	<br><h1>Gerenciamento de Leitos - Login</h1><hr>
	    
    	<form class="borda" style="width: 20%;" action="login.php?valor=enviado" method="POST">
		  <div class="form-group">
		    <label>Email:</label>
		    <input name="email" type="email" class="form-control form-control-sm" placeholder="Email" required>
		  </div>
		  <div class="form-group">
		    <label>Senha:</label>
		    <input name="senha" type="password" maxlength="15" class="form-control form-control-sm" placeholder="Senha" required>
		  </div>
		  <a href="esqueceusenha.php" style="color: white;"> Esqueci a senha </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  <a href="cadastro.php" style="color: white;"> Não Possuo Cadastro </a><br><br>
		  <button name="Botao" type="submit" style="width: 40%;" class="btn btn-success" value="Logar">Enviar</button>
		</form>


    <!-- JavaScript (Opcional) -->
    <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>

<?php

	include 'conexao.php';

	if(isset($_REQUEST['valor']) and ($_REQUEST['valor'] == 'enviado'))
	{
		$Botao = $_POST ["Botao"]; 
		$login = $_POST["email"];
		$senha = $_POST["senha"];

	    if ($Botao == "Logar")
	    {
	        try
	        {
	        	$Comando=$conexao->prepare("SELECT email, senha FROM tb_login WHERE email=? AND senha=?");		
			    $Comando->bindParam(1, $login);
			    $Comando->bindParam(2, $senha);

			    if ($Comando->execute()) 
			    {
			    	if ($Comando->rowCount() > 0) 
			    	{
			    		while ($Linha = $Comando->fetch(PDO::FETCH_OBJ)) 
				       	{
				            $email = $Linha->email;
				            $senha = $Linha->senha;
							     
				            session_start();
			    					$_SESSION["confirma"] = "abc";
			    					header('location:home.php');
				        }
			    	}
			    	else
			    	{
			    		echo "<script> alert('Login ou senha inválidos! Por favor tente novamente.'); document.href='login.php'; </script>";
			    	}
			    }
			    else
			    {
			    	throw new PDOException("Erro! Não foi possivel efetuar a declaração sql.");
			    }
	        }
	        catch(Exception $erro)
	        {
	        	echo "Erro!" . $erro->getMessage();
	        }
	    }
	} 

?>