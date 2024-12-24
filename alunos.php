<?php 
	include_once "sessao.php";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<?php
	include_once "header.php";
	?>

	<style>
		.table tbody tr {
			transition: background-color 0.3s ease;
			cursor: pointer; /* Muda o cursor para indicar que a linha é clicável */
		}

		.table tbody tr:hover {
			background-color: #f1f1f1; /* Cor de fundo ao passar o mouse */
		}

		.table tbody tr.dblclick-hover {
			background-color: #d9d9d9; /* Cor de fundo ao dar double click */
		}
		
	</style>




    <script>
	function openEditModal(id, nome, nascimento, imc, altura, envergadura, cintura, sexo) {
		// coloca os valores no modal
		document.getElementById('editId').value = id;
		document.getElementById('editNome').value = nome;
		document.getElementById('editNascimento').value = nascimento.split('/').reverse().join('-'); // converte para YYYY-MM-DD
		document.getElementById('editIMC').value = imc;
		document.getElementById('editAltura').value = altura;
		document.getElementById('editEnvergadura').value = envergadura;
		document.getElementById('editCintura').value = cintura;
		document.getElementById('editSexo').value = sexo;

		// abre o modal
		$('#editModal').modal('show');
	}
	
	function atualizarUnidade(id) {
		var select = document.getElementById('aptidao_' + id);
        var unidade = select.options[select.selectedIndex].getAttribute('data-unidade');
        document.getElementById('unidadeAptidao_' + id).value = unidade;
		}
	</script>
	
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
		<?php
		include_once "sidebar.php";
		?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
				<?php
				include_once "topbar.php";
				?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
               <div class="container-fluid">

					<!-- Page Heading -->
					<div class="d-flex justify-content-between align-items-center mb-4">
						<h1 class="h3 mb-2 text-gray-800">Alunos</h1>
					</div>
					
					<?php 
					
					$nomeCompleto = '';

					if (isset($_SESSION['nomeCompleto'])) {
						$nomeCompleto = $_SESSION['nomeCompleto'];
						unset($_SESSION['nomeCompleto']); 
					}

					?>

					<?php
						if(empty($nomeCompleto))
						{
						
						$sql = "SELECT idAluno, dsAluno,".
									"DATE_FORMAT(dtNascimento,'%d/%m/%Y'),".
									"txIMC, nrAltura, nrEnvergadura, nrCintura, ".
									"flSexo ".
								"FROM alunos";
						$result = mysqli_query($conn, $sql);
						
						} else {
							
						$nomeCompleto = mysqli_real_escape_string($conn, $nomeCompleto);

						$sql = "SELECT idAluno, dsAluno, ".
							   "DATE_FORMAT(dtNascimento,'%d/%m/%Y') AS dtNascimento, ".
							   "txIMC, nrAltura, nrEnvergadura, nrCintura, flSexo ".
							   "FROM alunos ".
							   "WHERE dsAluno = '$nomeCompleto'";

						$result = mysqli_query($conn, $sql);
							
						}
					?>

					<!-- DataTales Example -->
					<div class="card shadow mb-4">
						<div class="card-header py-3 d-flex justify-content-between align-items-center">
							<h6 class="m-0 font-weight-bold text-primary">Cadastro de Alunos</h6>
							<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal">Incluir aluno</button>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
									<thead>
										<tr>
											<th width="10%">Código</th>
											<th width="35%">Nome do(a) Aluno(a)</th>
											<th width="10%">Nascimento</th>
											<th width="10%">Sexo</th>
											<th width="35%">Ações</th>
										</tr>
									</thead>
									<tbody>
										<?php while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) { ?>
											<tr ondblclick="openEditModal(<?php echo $row[0]; ?>, '<?php echo $row[1]; ?>', '<?php echo $row[2]; ?>', '<?php echo $row[3]; ?>', '<?php echo $row[4]; ?>', '<?php echo $row[5]; ?>', '<?php echo $row[6]; ?>', '<?php echo $row[7]; ?>')">
													<?php $idAluno = $row[0]; ?>
												<td><?php echo $row[0]; ?></td>
												<td><?php echo $row[1]; ?></td>
												<td><?php echo $row[2]; ?></td>
												<td><?php echo ($row[7]=='M')?'Masculino':'Feminino'; ?></td>
												<td>
													<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal<?php echo $row[0]; ?>">Inserir avaliação</button>
													<button onclick="window.location.href='avaliacoes_mostrar.php?idAluno=<?php echo $idAluno; ?>';" class="btn btn-sm btn-primary">Visualizar</button>
													<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalex<?php echo $row[0]; ?>">Excluir aluno</button>
												</td>
											</tr>

											<!-- Modal de excluir -->
											<div class="modal fade" id="modalex<?php echo $row[0]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title" id="exampleModalLabel">Atenção</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
															Tem certeza que deseja excluir esse aluno?
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
															<button type="button" class="btn btn-danger" onclick="document.location = 'alunos_excluir.php?codigo=<?php echo $row[0]; ?>'">Confirmar</button>
														</div>
													</div>
												</div>
											</div>
												<?php 
													$sql2 = "SELECT dsAptidao, unidadeAptidao FROM aptidoes";
													$result2 = $conn->query($sql2);
												?>
											<!-- Modal de inserir AVALIAÇÃO-->
                                                    <div class="modal fade" id="modal<?php echo $row[0]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <?php $nomeAluno = $row[1]; ?>
                                                                    <h5 class="modal-title" id="exampleModalLabel">Avaliar <?php echo $nomeAluno; ?></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form id="formAptidao<?php echo $row[0]; ?>" method="POST" action="avaliacoes_incluir.php">
                                                                        <label for="dsAptidao">Aptidão</label>
                                                                        <div class="form-group">
																			<select id="aptidao_<?php echo $row[0]; ?>" name="aptidao" onchange="atualizarUnidade(<?php echo $row[0]; ?>)">
																				<option value="">Selecione a aptidão...</option>
																				<?php
																				if ($result2->num_rows > 0) {
																					while($row2 = $result2->fetch_assoc()) {
																						echo '<option value="'.$row2["dsAptidao"].'" data-unidade="'.$row2["unidadeAptidao"].'">'.$row2["dsAptidao"].'</option>';
																					}
																				} else {
																					echo '<option value="">Nenhuma aptidão encontrada</option>';
																				}
																				?>
																			</select>
                                                                        </div>
                                                                        <div class="form-row">
                                                                            <div class="form-group col-md-6">
                                                                                <label for="vlrAptidao">Valor</label>
                                                                                <input type="text" class="form-control" id="vlrAptidao_<?php echo $row[0]; ?>" name="vlrAptidao" required>
																				<input type="hidden" name="codigo" value="<?php echo $row[0]; ?>">
                                                                            </div>
                                                                            <div class="form-group col-md-6">
                                                                                <label for="unidadeAptidao">Unidade de medida</label>
                                                                                <input type="text" class="form-control" id="unidadeAptidao_<?php echo $row[0]; ?>" name="unidadeAptidao" value="" >
                                                                            </div>
                                                                           <!-- <div class="form-group col-md-6">
                                                                                <label for="dsData">Data</label>
                                                                                <input type="date" step="0.01" class="form-control" id="dsData_" name="dsData" required>
                                                                            </div> -->
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                                    <button type="submit" form="formAptidao<?php echo $row[0]; ?>" class="btn btn-success">Inserir</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>



                <!--Modal de inclusão-->
                <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Inclusão de alunos</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="formAluno" method="POST" action="alunos_incluir.php">
                                    <div class="form-group">
                                        <label for="dsAluno">Nome do Aluno</label>
                                        <input type="text" class="form-control" id="dsAluno" name="dsAluno" required autofocus>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="dtNascimento">Data de Nascimento</label>
                                            <input type="date" class="form-control" id="dtNascimento" name="dtNascimento" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="nrAltura">Altura (m)</label>
                                            <input type="number" step="0.01" class="form-control" id="nrAltura" name="nrAltura" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="nrEnvergadura">Envergadura (m)</label>
                                            <input type="number" step="0.01" class="form-control" id="nrEnvergadura" name="nrEnvergadura" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="txIMC">Taxa IMC</label>
                                            <input type="number" step="0.01" class="form-control" id="txIMC" name="txIMC" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="nrCintura">Cintura (m)</label>
                                        <input type="number" step="0.01" class="form-control" id="nrCintura" name="nrCintura" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nrSexo">Sexo</label>
                                        <select class="form-control" id="nrSexo" name="nrSexo" required>
                                            <option value="M">Masculino</option>
                                            <option value="F">Feminino</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="submit" form="formAluno" class="btn btn-success">Incluir aluno</button>
                            </div>
                        </div>
                    </div>
                </div>

				<!-- Modal de edição -->
				<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="editModalLabel">Editar Aluno</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form id="formEditAluno" method="POST" action="alunos_alterar.php">
									<input type="hidden" id="editId" name="idAluno">
									<div class="form-group">
										<label for="editNome">Nome do Aluno</label>
										<input type="text" class="form-control" id="editNome" name="dsAluno" required autofocus>
									</div>
									<div class="form-row">
										<div class="form-group col-md-6">
											<label for="editNascimento">Data de Nascimento</label>
											<input type="date" class="form-control" id="editNascimento" name="dtNascimento" required>
										</div>
										<div class="form-group col-md-6">
											<label for="editAltura">Altura (m)</label>
											<input type="number" step="0.01" class="form-control" id="editAltura" name="nrAltura" required>
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-md-6">
											<label for="editEnvergadura">Envergadura (m)</label>
											<input type="number" step="0.01" class="form-control" id="editEnvergadura" name="nrEnvergadura" required>
										</div>
										<div class="form-group col-md-6">
											<label for="editIMC">Taxa IMC</label>
											<input type="number" step="0.01" class="form-control" id="editIMC" name="txIMC" required>
										</div>
									</div>
									<div class="form-group">
										<label for="editCintura">Cintura (m)</label>
										<input type="number" step="0.01" class="form-control" id="editCintura" name="nrCintura" required>
									</div>
									<div class="form-group">
										<label for="editSexo">Sexo</label>
										<select class="form-control" id="editSexo" name="flSexo" required>
											<option value="M">Masculino</option>
											<option value="F">Feminino</option>
										</select>
									</div>
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
								<button type="submit" form="formEditAluno" class="btn btn-success">Salvar</button>
							</div>
						</div>
					</div>
				</div>



            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
			<?php
			include_once "rodape.php";
			?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!--Modal de logout-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Quer realmente sair?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Selecione "Sair" abaixo se você quer encessar a aplicação.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" href="logout.php">Sair</a>
                </div>
            </div>
        </div>
    </div>

	<?php
	include_once "footer.php";
	?>
	
</body>

</html>