<?php
	// conexão
	include_once "sessao.php";

	// recebe parametros
	$descricao = $_POST['descricao'];
	$unidadeMedida = $_POST['unidadeMedida'];

	// monta QUERY
	$sql = "INSERT INTO aptidoes (dsAptidao, unidadeAptidao) VALUES ('$descricao', '$unidadeMedida')";
	$result = mysqli_query($conn, $sql);

	// desconecta do banco
	mysqli_close($conn);

	if (! $result) {
		echo  "<script>alert('N\u00e3o foi poss\u00edvel incluir os dados!');</script>";
	}
	else {
		echo  "<script>alert('Aptid\u00e3o incluida com sucesso!');</script>";
	}

	// retorna
	header("Location: aptidoes.php");
?>