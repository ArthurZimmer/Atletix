<?php 
	include_once "sessao.php";
	include_once "conexao.php";
	include_once "header.php";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<style>
		/* Card estilizado */
		.construcao-container {
			margin: 40px auto;
			padding: 30px;
			max-width: 600px;
			background: linear-gradient(135deg, #6a11cb, #2575fc);
			color: #fff;
			border-radius: 15px;
			box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
			text-align: center;
			position: relative;
		}

		.construcao-container h1 {
			font-size: 28px;
			font-weight: bold;
			margin: 0;
			padding: 0;
			color: #fff;
		}

		.construcao-container p {
			font-size: 16px;
			margin-top: 10px;
		}

		.icon-wrapper {
			background-color: rgba(255, 255, 255, 0.15);
			width: 60px;
			height: 60px;
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			margin: 0 auto 15px auto;
		}

		.icon-wrapper i {
			font-size: 30px;
			color: #fff;
		}
	</style>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include_once "sidebar.php"; ?>
        
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php
					include_once "topbar.php";
					$sql = "SELECT idAptidao, dsAptidao, unidadeAptidao FROM aptidoes ORDER BY dsAptidao";
					$result = mysqli_query($conn, $sql);
				?>

                <div class="container-fluid">
                    <div class="construcao-container">
						<div class="icon-wrapper">
							<i class="fas fa-tools"></i>
						</div>
                        <h1>Funcionalidade em construção!</h1>
                        <p>Estamos trabalhando para trazer novidades em breve. Agradecemos sua paciência!</p>
                    </div>
                </div>
            </div>

            <?php include_once "rodape.php"; ?>
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

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
