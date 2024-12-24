<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include_once "header.php"; ?>
    <!-- Favicon and Apple Touch Icons -->
    <link rel="apple-touch-icon" sizes="57x57" href="img/favicon/apple-icon-57x57.png">
    <!-- Outros links de favicon -->
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <!-- Bootstrap CSS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</head>

<?php 
include_once "sessao.php";

if (isset($_GET['idAluno'])) {
    $idAluno = $_GET['idAluno'];
    $idAluno = mysqli_real_escape_string($conn, $idAluno);

    // Consulta SQL para pegar o nome do aluno baseado no idAluno
    $sql = "SELECT dsAluno FROM alunos WHERE idAluno = '$idAluno'";
    $result = mysqli_query($conn, $sql);

    // Verificar se a consulta retornou algum resultado
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $dsAluno = $row['dsAluno'];
    } else {
        $dsAluno = "Aluno não encontrado";
    }
} else {
    $dsAluno = "ID do aluno não fornecido";
    echo "Parâmetro idAluno não foi fornecido na URL.<br>"; // Debug: aviso de ID não fornecido
}
?>  

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include_once "sidebar.php"; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include_once "topbar.php"; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3 mb-2 text-gray-800">
                            
                        </h1>
                    </div>

                    <?php 
                    $sqlContent = "SELECT idAvaliacao, DATE_FORMAT(dtAvaliacao, '%d/%m/%Y') AS dataFormatada, dsAptidao, vlrAptidao, unidadeAptidao FROM avaliacoes WHERE idAluno = $idAluno;";
                    $resultContent = mysqli_query($conn, $sqlContent);
                    ?>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h4 class="m-0 font-weight-bold text-primary"><?php echo htmlspecialchars($dsAluno, ENT_QUOTES, 'UTF-8'); ?></h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="10%">Data</th>
                                            <th width="20%">Aptidão</th>
                                            <th width="25%">Desempenho</th>
                                            <th width="5%">Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_array($resultContent, MYSQLI_NUM)) { ?>
                                            <tr>
                                                <td><?php echo $row[1]; ?></td>
                                                <td><?php echo $row[2]; ?></td>
                                                <td><?php echo $row[3]; echo " "; echo $row[4];?> </td>
                                                <td>
                                                    <!-- Botão de Exclusão -->
                                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalex<?php echo $row[0]; ?>">
                                                        Excluir
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Modal de Exclusão -->
                                            <div class="modal fade" id="modalex<?php echo $row[0]; ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalLabel<?php echo $row[0]; ?>">Atenção</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Tem certeza que deseja excluir essa avaliação?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                            <button type="button" class="btn btn-danger" onclick="document.location = 'avaliacoes_excluir.php?idAvaliacao=<?php echo $row[0]; ?>'">Confirmar</button>
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
                <!-- End of Page Content -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include_once "rodape.php"; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Quer realmente sair?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Selecione "Sair" abaixo se você quer encerrar a aplicação.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" href="logout.php">Sair</a>
                </div>
            </div>
        </div>
    </div>

    <?php include_once "footer.php"; ?>

</body>

</html>
