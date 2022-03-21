<?php 
date_default_timezone_set('America/Sao_Paulo');
   // A sessão precisa ser iniciada em cada página diferente
  if (!isset($_SESSION)) session_start();
    
  // Verifica se não há a variável da sessão que identifica o usuário
  if (!isset($_SESSION['confirma'])) 
  {
	  // Destrói a sessão por segurança
	  session_destroy();
	  // Redireciona o visitante de volta pro login
	  header("Location: login.php"); exit;
  }
else 
 
?>
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
	  <a href="?acao=sair"><button name="Botao" type="submit" class="btn btn-danger my-2 my-sm-0 btn-lg" value="Sair">Sair</button></a>
	</nav>

    <center>
    	<br><h1>Sistema de Gerenciamento de Leitos </h1><hr>
    	<?php 
	    	include 'conexao.php';

				$Comando=$conexao->prepare("SELECT * FROM tb_leitos");
				if ($Comando->execute()) 
				{	
					$LeitosOcupados = $Comando->rowCount();
					$LeitosDisponiveis = 100 - $LeitosOcupados;
					echo "<p style=color:#6fe894;>Quantidade de leitos disponíveis: " . $LeitosDisponiveis . " leitos.</p>";
					echo "<p style=color:#e86f6f>Quantidade de leitos ocupados: " . $LeitosOcupados . " leitos.</p>";
				}

	    ?>
<table class="borda">

<tbody>
<tr>
<td><form action="home.php?valor=enviado" method="POST">
		  <div class="form-group">
		    <label>Código do Paciente:</label>
		    <input name="codigo_paciente" type="number" class="form-control form-control-sm" placeholder="Código" >
		  </div>
		  <div class="form-group">
		    <label>Nome do Paciente:</label>
		    <input name="nome_paciente" type="text" class="form-control form-control-sm" placeholder="Paciente" >
		  </div>
		  <div class="form-group">
		    <label>Idade do Paciente:</label>
		    <input name="idade_paciente" type="number" class="form-control form-control-sm" placeholder="Idade" >
		  </div>
		  <div class="form-group">
		    <label>Patologia do Paciente:</label>
		    <input name="patologia_paciente" type="text" class="form-control form-control-sm" placeholder="Patologia" >
		  </div>
		  <div class="form-group">
		    <label>UTI do Paciente:</label>
		    <input name="uti_paciente" type="text" class="form-control form-control-sm" placeholder="UTI" >
		  </div>
		  <div class="form-group">
		    <label>Enfermeiro Responsável:</label>
		    <input name="enfermeiro_paciente" type="text" class="form-control form-control-sm" placeholder="Enfermeiro" >
		  </div>
		  <div class="form-group">
		    <label>Quarto do Paciente:</label>
		    <input name="quarto_paciente" type="number" class="form-control form-control-sm" placeholder="Quarto" >
		    <small id="emailHelp" class="form-text text-muted">Deve ter entre 1 e 5 caracteres.</small>
		  </div>

		  <button name="Botao" type="submit" class="btn btn-outline-info" value="Inserir">Inserir</button>
		  <button name="Botao" type="submit" class="btn btn-outline-success" value="Consultar">Consultar</button>
		  <button name="Botao" type="submit" class="btn btn-outline-danger" value="Excluir">Excluir</button>
		  <button name="Botao" type="submit" class="btn btn-outline-warning" value="Alterar">Alterar</button>
		</form>
		<?php include 'acoes.php';?></td>
</tr>
</tbody>
</table><br><br><br><br><br>
    	
    <!-- JavaScript (Opcional) -->
    <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>

	