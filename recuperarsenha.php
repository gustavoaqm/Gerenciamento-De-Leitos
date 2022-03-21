 <?php
        include "conexao.php";

        if(isset($_REQUEST['valor']) and ($_REQUEST['valor'] == 'enviado')) 
        { 

            session_start();
            $codigo = base64_decode($_SESSION["codigo"]); // Recebendo a session 'código' do esqueceusenha.php

            // Verificando se a data do código é valida
            $Comando=$conexao->prepare("SELECT id FROM tb_codigos WHERE codigo=? AND data > NOW()");        
            $Comando->bindParam(1, $codigo);

            if ($Comando->execute()) 
            {
                if ($Comando->rowCount () > 0) // Se for maior que 0, então está no banco e existe
                {
                    while ($Linha = $Comando->fetch(PDO::FETCH_OBJ))
                    {
                        $id_usuario = $Linha->id; // Pegamos o id do usuário na tabela 'tb_codigos' e setamos na variável
 
                        try
                        {
                            $Botao = $_POST["Botao"];
                            $SenhaNova = $_POST["nova_senha"];

                            if($Botao == "Enviar")
                            {
                                if($_POST["nova_senha"] == $_POST["nova_senha_confirma"]) // Verifiando se as senhas são iguais
                                {
                                    $senha = $SenhaNova;
                                    $Comando=$conexao->prepare("UPDATE tb_login set senha=? WHERE id=?");
                                    $Comando->bindParam(1, $senha);
                                    $Comando->bindParam(2, $id_usuario);    

                                    if($Comando->execute())
                                    {
                                        // Se o comando for executado com sucesso, podemos excluir o código da tabela.
                                        $Comando=$conexao->prepare("DELETE FROM tb_codigos WHERE codigo=?");
                                        $Comando->bindParam(1, $codigo);
                                        $Comando->execute();
                                        session_destroy();
                                        echo ("<script> alert('Senha redefinida com sucesso!'); location.href='http://localhost/Gerenciamento/login.php'</script>");
                                    }
                                }
                                else
                                {
                                    echo ("<script> alert('Senhas não conferem!'); </script>");
                                }
                            }
                        }
                        catch(PDOExepction $erro)
                        {
                            echo "Erro" . $erro->getMessage();
                        }
                    } 
                }
                else // Se o código tiver expirado, deletamos do banco de dados.
                {
                    $Comando=$conexao->prepare("DELETE FROM tb_codigos WHERE codigo=?");
                    $Comando->bindParam(1, $codigo);
                    if ($Comando->execute()) 
                    {
                        echo "<script>alert('Código expirado e/ou inexistente! Redirecionando...'); location.href='http://localhost/Gerenciamento/esqueceusenha.php';</script>";
                    }
                } 
            }
            else
            {
                throw new PDOException("Erro! Não foi possível executar a declaração SQL.");
            }
        }
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
	</nav>

    <center>
    	<br><h1>Sistema de Gerenciamento de Leitos - Esqueceu Senha</h1><hr>
    	<form class="borda" style="width: 20%;" action="esqueceusenha.php?valor=enviado" method="POST">
		  
          <div class="form-group">
		    <label>Nova Senha</label>
		    <input name="nova_senha" type="password" class="form-control form-control-sm" placeholder="Nova Senha" required>
		  </div>
            <label>Confirmar Senha</label>
            <input name="nova_senha_confirma" type="password" class="form-control form-control-sm" placeholder="Confirmar Senha" required><br>
          </div>

		  <button name="Botao" type="submit" class="btn btn-success" style="width: 40%;" value="Enviar">Enviar</button>
		</form>

    <!-- JavaScript (Opcional) -->
    <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>

   