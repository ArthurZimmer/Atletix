<?php
	// conexão
	include_once "sessao.php";
	
	// recebe parametro
	$codigo = $_GET['codigo'];

	// monta QUERY
	$sql = "DELETE FROM aptidoes WHERE idAptidao=$codigo";
	$result = mysqli_query($conn, $sql);

	// desconecta do banco
	mysqli_close($conn);

	if (! $result) {
		echo  "<script>alert('N\u00e3o foi poss\u00edvel excluir os dados!');</script>";
	}
	else {
		echo  "<script>alert('Aptid\u00e3o exclu\u00edda com sucesso!');</script>";
	}

	// retorna
	header("Location: aptidoes.php");
?>