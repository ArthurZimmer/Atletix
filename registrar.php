<?php
	include_once "sessao.php";
	
	$nome = $_POST['nome'];
	$email = $_POST['email'];
	$senha = $_POST['senha'];
	$reseta = $_POST['senharepeat'];
	
	if ($senha == $reseta) {
		$sql = "insert into usuarios (dsUsuario, dsEmail, dsSenha) ".
				"values ('$nome', '$email', '$senha')";
		$result = mysqli_query($conn, $sql);
		
		mysqli_close($conn);

		if (!result) {
			echo "<script>alert('N\u00e3o foi poss\u00edvel incluir os dados!');</script>";
		}
		else {
			echo "<script>alert('Dados inclu\u00eddos com sucesso!');</script>";
		}
	}
	else {
		echo "<script>alert('Confirma a senha!');</script>";
	}

	header("Location: index.html");
?>