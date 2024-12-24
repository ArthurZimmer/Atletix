<?php
	// conexão
	include_once "sessao.php";

	// recebe parametro
	$codigo = $_POST['codigo'];
	$nome  = $_POST['nome'];
	$email = $_POST['email'];
	$senha = $_POST['senha'];

	// monta QUERY
	$sql = "UPDATE usuarios ".
			"SET dsUsuario='$nome', dsEmail='$email', dsSenha='$senha' ".
			"WHERE idUsuario=$codigo";
	$result = mysqli_query($conn, $sql);

	// fecha conexão
	mysqli_close($conn);

	if (! $result) {
		echo  "<script>alert('N\u00e3o foi poss\u00edvel alterar os dados!');</script>";
	}
	else {
		header("Location: perfil.php");
		echo  "<script>alert('Dados salvos com sucesso!');</script>";
	}

	//redireciona
	header("Location: index.php");
?>