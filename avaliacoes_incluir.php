<?php
    // Inclui o arquivo de sessão ou conexão com o banco de dados
    include_once "sessao.php"; // Certifique-se de que o $conn está configurado corretamente
	date_default_timezone_set('America/Sao_Paulo');
	
    $dsAluno = $_POST['dsAluno']; // Nome do aluno (já selecionado)
    $dsAptidao = $_POST['aptidao']; // Aptidão selecionada
    $vlrAptidao = $_POST['vlrAptidao'];
    $unidadeAptidao = $_POST['unidadeAptidao']; // Unidade de medida (já selecionado)
    $dtAvaliacao = date('Y-m-d'); // Data da avaliação
    $codigo = $_POST['codigo'];

    // Substitui a vírgula por ponto, caso exista, para que o valor seja interpretado como decimal
    $vlrAptidao = str_replace(',', '.', $vlrAptidao);

    // Agora $vlrAptidao está em um formato numérico compatível com PHP, e pode ser tratado corretamente


    // Verifica se todos os campos foram preenchidos
    if (empty($dsAptidao) || empty($vlrAptidao) || empty($unidadeAptidao)) {
        echo "Todos os campos são obrigatórios.";
        exit;
    }

    // Agora que temos o idAluno, podemos proceder para a inserção da avaliação
    $sql = "INSERT INTO avaliacoes (idAluno, dsAptidao, vlrAptidao, unidadeAptidao, dtAvaliacao) 
            VALUES (?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {    
        // Associa os valores aos parâmetros
        mysqli_stmt_bind_param($stmt, 'isdss', $codigo, $dsAptidao, $vlrAptidao, $unidadeAptidao, $dtAvaliacao);

        // Executa a consulta
        $result = mysqli_stmt_execute($stmt);

        // Verifica se a inserção foi bem-sucedida
        if ($result) {
            echo "<script>
					alert('Avaliação incluída com sucesso!');
					window.location.href = 'alunos.php';
				</script>";
			exit();
		} else {
			echo "<script>
					alert('Erro ao incluir a avaliação. Tente novamente.');
				</script>";
            echo "Erro ao inserir os dados: " . mysqli_error($conn);
        }

        // Fecha o statement
        mysqli_stmt_close($stmt);
    } else {
        // Exibe mensagem de erro caso a preparação da query falhe
        echo "Erro ao preparar a declaração: " . mysqli_error($conn);
    }

    // Fecha a conexão com o banco de dados
    mysqli_close($conn);
?>