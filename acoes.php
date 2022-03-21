<?php
		
		$hoje = date('Y-m-d'); // Pegando a data Atual do sistema

		// ============================================================BOTÃO SAIR ================================================================
		if (isset($_GET["acao"])) 
		{
			if($_GET["acao"] == "sair")
			{
				session_destroy();
				header("location: login.php");
			}
		}
		// ============================================================BOTÃO SAIR ================================================================

		if(isset($_REQUEST['valor']) and ($_REQUEST['valor'] == 'enviado')) 
		{
			$Codigo = $_POST['codigo_paciente'];
			$Nome = $_POST['nome_paciente'];
			$Idade = $_POST['idade_paciente'];
			$Patologia = $_POST['patologia_paciente'];
			$Uti = $_POST['uti_paciente'];
			$Enfermeiro = $_POST['enfermeiro_paciente'];
			$Quarto = $_POST['quarto_paciente'];
			$Botao = $_POST['Botao'];

			// =========================================================BOTÃO INSERIR============================================================================ //
			if ($Botao == "Inserir") 
			{
				if ($LeitosOcupados > $LeitosDisponiveis) 
				{
					echo "<script> alert('Atenção!! Não há mais leitos disponíveis!'); </script>";
				}
				else
				{
					try 
					{	
						//Verificando se o campo "código" está vazio
						if ($Codigo == "") 
						{
							echo "<script> alert('Por favor preencha o código antes de fazer a inserção!');</script>";
						}

						elseif ($Nome == "") 
						{
							echo "<script> alert('Por favor preencha o nome do paciente antes de fazer a inserção!');</script>";
						}

						//Se não estiver, verificar se o código já existe no banco de dados
						else
						{	
							$Comando=$conexao->prepare("SELECT * FROM tb_leitos WHERE cod_paciente=?");
							$Comando->bindParam(1, $Codigo);
							
							if ($Comando->execute()) 
							{	
								// Se existir, exibir um alert pedindo para o usuário inserir outro.
								if ($Comando->rowCount() > 0) 
								{
									echo "<script>alert('Usuário já existente, por favor tente novamente.'); </script>";
								}

								// Se não existir, fazer a inserção normalmente.
								else
								{
									$Comando=$conexao->prepare("INSERT INTO tb_leitos (cod_paciente, nome_paciente, idade_paciente, patologia_paciente, uti_paciente, enfermeiro_paciente, quarto_paciente, data_cadastro) 
										VALUES( ?,?,?,?,?,?,?,?)");
									$Comando->bindParam(1, $Codigo);
									$Comando->bindParam(2, $Nome);
									$Comando->bindParam(3, $Idade);
									$Comando->bindParam(4, $Patologia);
									$Comando->bindParam(5, $Uti);
									$Comando->bindParam(6, $Enfermeiro);
									$Comando->bindParam(7, $Quarto);
									$Comando->bindParam(8, $hoje);

									if ($Comando->execute()) 
									{
										if ($Comando->rowCount() > 0) 
										{
											echo "<script> alert('Inserção efetuada com sucesso!'); location.href='home.php'; </script>";
											$Codigo = null;
											$Nome = null;
											$Idade = null;
											$Patologia = null;
											$Uti = null;
											$Enfermeiro = null;
											$Quarto = null;
										}
										else
										{
											echo "Erro ao efetivar a inserção!";
										}
									}
									else
									{
										throw new PDOException("Erro! Não foi possivel efetuar a declaração sql.");
									}
								}
							}
							else
							{
								throw new PDOException("Erro! Não foi possivel efetuar a declaração sql.");
							}
						}
					} 
					catch (Exception $e) 
					{
						echo "Erro!" . $e->getMessage();
					}
				}
			}
			// =========================================================BOTÃO INSERIR============================================================================ //
			// 
			// =========================================================BOTÃO CONSULTAR============================================================================ //
			if ($Botao == "Consultar") 
			{
				try
				{	
					// Se o código estiver vazio, ele exibe todos os pacientes
					if($Codigo == "")
					{
						$Comando=$conexao->prepare("SELECT * FROM tb_leitos");
						echo "<center><br>Para fazer a consulta de um paciente específico, por favor preencha seu código!</center>";
					}
					else // Se não estiver vazio, fazer a verificação normalmente
					{
						$Comando=$conexao->prepare("SELECT * FROM tb_leitos WHERE cod_paciente=?");
						$Comando->bindParam(1, $Codigo);
					}	

					if ($Comando->execute()) 
					{
						// Se não existir um paciente, exibir um alert pedindo para o usuário digitar outro código. 
						if ($Comando->rowCount() > 0) 
						{
							echo "<center><br><table border=1>";
							echo "<tr>";
							echo "<th> Código </th>";
							echo "<th> Nome </th>";
							echo "<th> Idade </th>";
							echo "<th> Patologia </th>";
							echo "<th> UTI </th>";
							echo "<th> Enfermeiro </th>";
							echo "<th> Quarto Nº </th>";
							echo "<th> Dias Utilizados</th>";
							echo "</tr>";

							while ($Linha = $Comando->fetch(PDO::FETCH_OBJ)) 
							{
								$Codigo = $Linha->cod_paciente;
								$Nome = $Linha->nome_paciente;
								$Idade = $Linha->idade_paciente;
								$Patologia = $Linha->patologia_paciente;
								$Uti = $Linha->uti_paciente;
								$Enfermeiro = $Linha->enfermeiro_paciente;
								$Quarto = $Linha->quarto_paciente;
								$data_cadastro = $Linha->data_cadastro;
								
								// Pegando a data de hoje e a data do cadastro do usuário para subtrair e obter os dias.
								$data_inicial = \DateTime::createFromFormat('Y-m-d', $hoje);
								$data_final   = \DateTime::createFromFormat('Y-m-d', $data_cadastro);

								// Calculo da diferenca entre as datas
								$diferenca = $data_final->diff($data_inicial);

								echo "<tr>";
								echo "<td>" . $Codigo . "</td>";
								echo "<td>" . $Nome . "</td>";
								echo "<td>" . $Idade . "</td>";
								echo "<td>" . $Patologia . "</td>";
								echo "<td>" . $Uti . "</td>";
								echo "<td>" . $Enfermeiro . "</td>";
								echo "<td>" . $Quarto . "</td>";
								echo "<td>" . $diferenca->format("%a") . "</td>";
								echo "</tr>";
							}
							echo "</table></center>";
						}
						else
						{
							echo "<script> alert('Paciente(s) inexistente(s), por favor insira outro código!'); </script>";
						}
					}
					else
					{
						throw new PDOException("Erro! Não foi possivel efetuar a declaração sql.");
					}

				}
				catch(Exception $e)
				{
					echo "Erro!" . $e->getMessage();
				}
			}
			// =========================================================BOTÃO CONSULTAR============================================================================ //
			// opa tudo bom
			// =========================================================BOTÃO EXCLUIR============================================================================ //
			if ($Botao == "Excluir") 
			{
				try
				{
					// Se o código estiver vazio, pedir para o usuário preencher
					if ($Codigo == "") 
					{
						echo "<script> alert('Por favor preencha o código antes de fazer a exclusão!');</script>";
					}
					else //Se o código não estiver vazio, verificar se ele existe no banco de dados
					{
						$Comando=$conexao->prepare("DELETE FROM tb_leitos WHERE cod_paciente=?");
						$Comando->bindParam(1, $Codigo);
						
						if ($Comando->execute())
						{
							if ($Comando->rowCount() > 0) // Se existir, fazer a exclusão normalmente
							{
								echo "<script> alert('Paciente excluído com sucesso!'); location.href='home.php'; </script>";
							}
							// Se não existir, pedir para o usuário inserir um código válido
							else 
							{	
								echo "<script> alert('Paciente inexistente, porfavor insira outro código!'); </script>";
							}
						}
						else
						{
							throw new PDOException("Erro! Não foi possivel efetuar a declaração sql.");
						} 
					}
				}
				catch(Exception $erro)
				{
					echo "Erro!" . $erro->getMessage();
				}
			}

			// =========================================================BOTÃO EXCLUIR============================================================================ //
			// 
			// =========================================================BOTÃO ALTERAR============================================================================ //
			if ($Botao == "Alterar") 
			{
				try
				{
					// Se o código estiver vazio, pedir para o usuário preencher
					if ($Codigo == "") 
					{
						echo "<script> alert('Por favor preencha o código antes de fazer a alteração!');</script>";
					}
					else
					{
						$Comando=$conexao->prepare("UPDATE tb_leitos SET nome_paciente=?, idade_paciente=?, patologia_paciente=?, uti_paciente=?, enfermeiro_paciente=?, quarto_paciente=? WHERE cod_paciente=?");
						$Comando->bindParam(1, $Nome);
						$Comando->bindParam(2, $Idade);
						$Comando->bindParam(3, $Patologia);
						$Comando->bindParam(4, $Uti);
						$Comando->bindParam(5, $Enfermeiro);
						$Comando->bindParam(6, $Quarto);
						$Comando->bindParam(7, $Codigo);

						if ($Comando->execute()) 
						{
							if ($Comando->rowCount() > 0) 
							{
								echo "<script> alert('Dados alterados com sucesso!'); location.href='home.php'; </script>";
							}
							else
							{
								echo "<script> alert('Paciente inexistente! Por favor insira outro código.');</script>";
							}	
						}
						else
						{
							throw new PDOException("Erro! Não foi possivel efetuar a declaração sql.");
						}
					}
				}
				catch(Exception $erro)
				{
					echo "Erro!" . $erro->getMessage();
				}
			}
		}
	?>

