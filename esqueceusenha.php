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
		    <label>Informe o endereço de email para sua conta. Um código de verificação será enviado a você. Uma vez recebido o código você poderá escolher uma nova senha para sua conta.</label>
		    <input name="Email" type="email" class="form-control form-control-sm" placeholder="example@email.com" required><br>
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

<?php

    if (isset($_REQUEST['valor']) and ($_REQUEST['valor'] == 'enviado')) 
    {
    	$Botao = $_POST["Botao"];
        $Email = $_POST["Email"];

        if ($Botao == "Enviar") 
        {
            include 'conexao.php';
            $Comando=$conexao->prepare("SELECT id, nome, email, senha FROM tb_login WHERE email=?");   
            $Comando->bindParam(1, $Email);

            if ($Comando->execute()) 
            {
                if ($Comando->rowCount() > 0) 
                {
                    while ($Linha = $Comando->fetch(PDO::FETCH_OBJ)) 
                    {
                        $id = $Linha->id;
                        $nome = $Linha->nome;
                        $email = $Linha->email;
                        $senha = $Linha->senha;

                        try 
                        {
                            // Pegando as bibliotecas do PHPMailer para o envio dos e-mails
                            require("PHPMailer-master/src/PHPMailer.php");
                            require("PHPMailer-master/src/SMTP.php");
                            // equire("PHPMailer-master/src/Exception.php");

                            $mail = new PHPMailer\PHPMailer\PHPMailer();
                            $mail->IsSMTP(); // enable SMTP
                            
                            // Definindo um tempo de 10 minutos para o link ser válido
                            $date = new DateTime( 'now + 10 minutes', new DateTimeZone( 'America/Sao_Paulo')); 
                            $data = $date->format('Y-m-d H:i:s');

                            // Definindo um código aleatório
                            $codigo = strtoupper(substr(bin2hex(random_bytes(10)), 1));
                            $codigoCript = base64_encode($codigo);

                            // Enviando o código codificado por session para outra página
                            session_start();
                            $link = "localhost/Gerenciamento/recuperarsenha.php/?codigo=".$_SESSION["codigo"] = $codigoCript;

                            //configuração do gmail
                            $mail->Port = '465'; //porta usada pelo gmail.
                            $mail->Host = 'smtp.gmail.com'; 
                            $mail->IsHTML(true); 
                            $mail->Mailer = 'smtp'; 
                            $mail->SMTPSecure = 'ssl';

                            //configuração do usuário do gmail
                            $mail->SMTPAuth = true; 
                            $mail->Username = ''; // usuario gmail.   
                            $mail->Password = ''; // senha do email.

                            $mail->SingleTo = true; 

                            // configuração do email a ver enviado.
                            $mail->From = ""; // remetente
                            $mail->FromName = ""; // nome remetente

                            $mail->addAddress($Email); // email do destinatario.

                            $mail->CharSet = 'UTF-8';
                            $mail->Subject = "Redefinir sua senha do Gerenciamento de Leitos"; 
                            $mail->Body = "Olá " . $nome . "!" . "<br> Obrigado por entrar em contato sobre a redefinição de senha. Basta <a href='".$link."'>clicar aqui</a> e seguir as instruções. <br>" . "<br> Se você não solicitou a troca de senha, por favor desconsidere este e-mail.";

                            if(!$mail->Send())
                            {
                                echo "Erro ao enviar Email:" . $mail->ErrorInfo;
                            }

                            $Comando=$conexao->prepare("INSERT INTO tb_codigos (id,codigo, data) VALUES (?, ?, ?)");
                            $Comando->bindParam(1, $id);
                            $Comando->bindParam(2, $codigo);
                            $Comando->bindParam(3, $data);
                            $Comando->execute();
                            echo "<script> alert('E-mail enviado com sucesso! Verifique sua caixa de entrada.'); location.href='login.php';</script>"; 

                        } 
                        catch (PDOException $Erro) 
                        {
                            echo "erro!" . $Erro->getMessage();
                        }
                    }
                }
                else
                {
                    echo "<script> alert('E-mail inválido e/ou não cadastrado!'); location.href='esqueceusenha.php';</script>"; 
                }
            }
            else
            {
                throw new Exception("Erro ao fazer a consulta.", 1);
            }
        }
    }
?>
	