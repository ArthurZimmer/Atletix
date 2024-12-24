<?php
    include_once "sessao.php"
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<?php
	include_once "header.php";
	?>
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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4" style="margin-left: 14rem;">
                        <h1 class="h2 mb-0 text-gray-800">Perfil de usuário</h1>
                    </div>

                    <?php
                    // totalizadores
					$codigo = $_SESSION['id'];
					$sql = "SELECT * FROM usuarios WHERE idUsuario=$codigo";
					$result = mysqli_query($conn, $sql);
					while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
						$nome = $row[1];
						$email = $row[2];
						$senha = $row[3];
						$foto = $row[4];
						$cargo = $row[5];
						$escola = $row[6];
					}
					?>

                    <!-- Content Row -->
                    <div class="row" style="margin-left: 13rem;">
                        <div class="col-xl-3 col-lg-5">
                            <div class="card shadow mb-4">

                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Perfil</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        </a>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center text-center">
										<a class="dropdown-item" href="#" data-toggle="modal" data-target="#fotoModal">
											<img src="<?php echo $foto;?>" alt="Admin" class="rounded-circle" width="150">
										</a>
                                        <div class="mt-3">
                                            <h4><?php echo $nome;?></h4>
                                            <p class="text-secondary mb-1"><?php echo $cargo;?></p>
                                            <p class="text-muted font-size-sm"><?php echo $escola;?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Area Chart -->
                        <div class="col-xl-7 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Informações</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        </a>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <form class="user" action="perfil_alterar.php" method="post">
                                    <div class="row" style="margin-top: 1.6rem;">
                                        <input type="text" class="form-control form-control-user" 
											id="nome" name="nome" value="<?php echo $nome;?>" 
											placeholder="Nome do usuário">
                                        </div>
                                        <hr>
                                        <div class="row">
                                        
                                        <input type="email" class="form-control form-control-user" 
											id="email" name="email" value="<?php echo $email;?>" 
											placeholder="E-mail" required>

                                        </div>
                                        <hr>
                                        <div class="row">
                                        <input type="password" class="form-control form-control-user"
											id="senha" name="senha" value="<?php echo $senha;?>" 
											placeholder="Senha" required>
                                        </div>
                                        <hr>
                                        
                                        <div class="form-group row">
                                            <input type="hidden" name="codigo" value="<?php echo $codigo;?>">
                                            <button type="submit" class="btn btn-info btn-user">
                                                <b>Salvar</b>
                                            </button>
                                            &nbsp;&nbsp;
                                            <a href="index.php" class="btn btn-secondary btn-user">
										        <b>Voltar</b>
									        </a>
								        </div>
                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Pie Chart -->
                    </div>

                    <!-- Content Row -->
                    
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->
<footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Arthur Zimmer, Guilherme Frizzo, Gustavo Ternus, Fabian Viégas 2024</span>
                    </div>
                </div>
            </footer>
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="fotoModal" tabindex="-1" role="dialog" aria-labelledby="fotoModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fotoModal">Troca de foto do perfil</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
					<form name="form_codigo" class="user" action="perfil_foto.php" method="post" enctype="multipart/form-data" autocomplete="off">
						<div class="form-group">
							<input type="file" name="arquivo" id="arquivo" value="" accept=".jpg,.png" required>
						</div>
						<div class="form-group">
							<input type="hidden" name="codigo" value="<?php echo $codigo;?>">
							<input type="submit" class="btn btn-success" value="Salvar">
							<button class="btn btn-primary" type="button" data-dismiss="modal">Sair</button>
						</div>
					</form>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Modal-->
	<?php
	include_once "sair.php";
	?>

	<?php
	include_once "footer.php";
	?>

</body>

</html>