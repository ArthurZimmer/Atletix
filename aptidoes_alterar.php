<?php
	// conex�o
	include_once "sessao.php";

	// recebe parametros
	$codigo = $_POST['alt_codigo'];
	$descricao = $_POST['alt_descricao'];
	$unidadeMedida = $_POST['alt_unidade'];


	// monta QUERY
	$sql = "UPDATE aptidoes SET dsAptidao='$descricao', unidadeAptidao='$unidadeMedida' WHERE idAptidao=$codigo";
	$result = mysqli_query($conn, $sql);

	// desconecta do banco
	mysqli_close($conn);

	if (! $result) {
		echo  "<script>alert('N\u00e3o foi poss\u00edvel alterar os dados!');</script>";
	}
	else {
		echo  "<script>alert('Aptid\u00e3o alterada com sucesso!');</script>";
	}

	// retorna
	header("Location: aptidoes.php");
?>