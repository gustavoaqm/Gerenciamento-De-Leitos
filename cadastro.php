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
    	<br><h1>Gerenciamento de Leitos - Cadastro</h1><hr>
	    
    	<form class="borda" style="width: 20%;" action="cadastro.php?valor=enviado" method="POST">
    		<div class="form-group">
		    <label>Nome:</label>
		    <input name="nome" type="text" class="form-control form-control-sm" placeholder="Nome" required>
		  </div>
		  <div class="form-group">
		    <label>Email:</label>
		    <input name="email" type="email" class="form-control form-control-sm" placeholder="Email" required>
		  </div>
		  <div class="form-group">
		    <label>Senha:</label>
		    <input name="senha" type="password" maxlength="15" class="form-control form-control-sm" placeholder="Senha" required>
		  </div>
		  <div class="form-group">
		    <label>Confirmar Senha:</label>
		    <input name="senha_confirma" type="password" maxlength="15" class="form-control form-control-sm" placeholder="Confirma Senha" required>
		  </div>
		  <a href="esqueceusenha.php" style="color: white;"> Esqueci a senha </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  <a href="login.php" style="color: white;"> Já possuo cadastro </a><br><br>
		  <button name="Botao" type="submit" style="width: 40%;" class="btn btn-success" value="Enviar">Enviar</button>
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
		$Botao = $_POST["Botao"];
		$nome = $_POST["nome"];
		$email = $_POST["email"];
		$senha = $_POST["senha"];
		$confirma_senha = $_POST["senha_confirma"];

		if ($Botao == "Enviar") 
		{
			try
			{
				if ($senha == $confirma_senha) 
				{
					$Comando=$conexao->prepare("SELECT * FROM tb_login WHERE email=?");
					$Comando->bindParam(1, $email);
					
		    		if ($Comando->execute()) 
		    		{
		    			if ($Comando->rowCount() > 0) 
		    			{
		    				echo "<script> alert('Usuário já existente! Por favor insira outro.'); document.href='cadastro.php'; </script>";
		    			}
		    			else
		    			{
		    				$Comando=$conexao->prepare("INSERT INTO tb_login (nome, email, senha) VALUES ( ?, ?, ?)");
			       			$Comando->bindParam(1, $nome);
			       			$Comando->bindParam(2, $email);
				    		$Comando->bindParam(3, $senha);

				    		if ($Comando->execute()) 
				    		{
				    			echo("<script type='text/javascript'> alert('Cadastro realizado com sucesso !!!');
							    location.href='login.php';</script>");
				    			$nome = null;
				    			$email = null;
				    			$senha = null;
				    			$confirma_senha = null;
				    		}
				    		else
				    		{
				    			throw new Exception("Não foi possível executar a declaração SQL!", 1);
				    		}
		    			}
		    		}
		    		else
		    		{
		    			throw new Exception("Não foi possível executar a declaração SQL!", 1);
		    		}
				}
				else
				{
					echo "<script> alert('Senhas não conferem! Por favor tente novamente.'); document.href='cadastro.php'; </script>";
				}
			}
			catch(Exception $Erro)
			{
				echo "Erro!" . $Erro->getMessage();
			}
		}
	}


?>