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
    function openEditModal(id, descricao, unidade) {
        document.getElementById('alt_codigo').value = id;
        document.getElementById('alt_descricao').value = descricao;
		document.getElementById('alt_unidade').value = unidade;
        $('#editModal').modal('show');

        const rows = document.querySelectorAll('.aptidao-row');
        rows.forEach(row => {
            row.classList.remove('dblclick-hover');
        });
        event.currentTarget.classList.add('dblclick-hover');
    }

    // Remove o efeito ao clicar em qualquer lugar da tela
    document.addEventListener('click', function() {
        const rows = document.querySelectorAll('.aptidao-row');
        rows.forEach(row => {
            row.classList.remove('dblclick-hover');
        });
    });
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
						<h1 class="h3 mb-2 text-gray-800">Aptidões</h1>
					</div>

					<?php
						$sql = "SELECT idAptidao, dsAptidao, unidadeAptidao FROM aptidoes";
						$result = mysqli_query($conn, $sql);
					?>

					<!-- DataTales Example -->
					<div class="card shadow mb-4">
						<div class="card-header py-3 d-flex justify-content-between align-items-center">
							<h6 class="m-0 font-weight-bold text-primary">Cadastro de Aptidões</h6>
							<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalIncluir">Incluir</button>
						</div>

						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
									<thead>
										<tr>
											<th width="15%">Código</th>
											<th width="75%">Descrição da Aptidão</th>
											<th width="10%">Ações</th>
										</tr>
									</thead>
									<tbody>
										<?php while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) { ?>
											<tr ondblclick="openEditModal(<?php echo $row[0];?>, '<?php echo $row[1];?>' , '<?php echo $row[2];?>')" class="aptidao-row">
												<td><?php echo $row[0]; ?></td>
												<td><?php echo $row[1]; ?></td>
												<td>
													<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalExcluir<?php echo $row[0]; ?>">Excluir</button>
												</td>
											</tr>

											<!-- Modal de exclusão específico para cada aptidão -->
											<div class="modal fade" id="modalExcluir<?php echo $row[0]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title" id="exampleModalLabel">Atenção</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
															Tem certeza que deseja excluir a aptidão "<?php echo $row[1]; ?>"?
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
															<button type="button" class="btn btn-danger" onclick="document.location = 'aptidoes_excluir.php?codigo=<?php echo $row[0]; ?>'">Confirmar</button>
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

					<!-- Modal de inclusão -->
                    <div class="modal fade" id="modalIncluir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Inclusão de Aptidão</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="formIncluir" method="POST" action="aptidoes_incluir.php" autocomplete="off">
                                        <div class="form-group col-md-12">
                                            <label for="descricao">Descrição da Aptidão</label>
                                            <input type="text" class="form-control" id="descricao" name="descricao" required>
                                        </div>
										<div class="form-group col-md-12">
                                            <label for="unidadeMedida">Unidade de medida</label>
                                            <input type="text" class="form-control" id="unidadeMedida" name="unidadeMedida" required>
                                        </div>
                                    </form>
                                </div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
									<button type="submit" form="formIncluir" class="btn btn-success">Confirmar</button>
								</div>
							</div>
						</div>
					</div>

					<!-- Modal de edição -->
					<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="editModalLabel">Editar a Aptidão</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<form id="formEditAluno" method="POST" action="aptidoes_alterar.php">
										<input type="hidden" id="alt_codigo" name="alt_codigo">
										<div class="form-group">
											<label for="alt_descricao">Descrição da Aptidão</label>
											<input type="text" class="form-control" id="alt_descricao" name="alt_descricao" required>
										</div>
										<div class="form-group">
											<label for="alt_unidade">Unidade de medida</label>
											<input type="text" class="form-control" id="alt_unidade" name="alt_unidade" required>
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
