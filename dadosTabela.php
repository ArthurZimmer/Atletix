<?php 

	include_once "sessao.php";
	//include_once "estatisticas.php";

	$idAluno = $_POST['gera'];

	$sql = "SELECT vlrAptidao FROM avaliacoes WHERE idAluno = $idAluno";
	$result = mysqli_query($conn, $sql);

	$valorAptidao = [];

	if ($result->num_rows > 0) {
		// Salva os dados em arrays
		while($row = $result->fetch_assoc()) {
			$valorAptidao[] = $row['vlrAptidao'];  // Colunas de valores de avaliacao
		}
	}

	// Retorna os dados como JSON
	echo json_encode(['vlrAptidao' => $valorAptidao]);

	mysqli_close($conn);

?>