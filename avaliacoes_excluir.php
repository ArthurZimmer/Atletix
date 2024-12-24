<?php 
include_once "sessao.php";

// Verifica se o parâmetro 'idAvaliacao' foi passado e se é um número válido
if (isset($_GET['idAvaliacao']) && is_numeric($_GET['idAvaliacao'])) {
    $idAvaliacao = (int)$_GET['idAvaliacao']; // Cast para inteiro para segurança

    // Conexão com o banco de dados já deve estar feita em sessao.php
    $sql = "DELETE FROM avaliacoes WHERE idAvaliacao = $idAvaliacao";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Redireciona para a página de avaliações após a exclusão
        echo "<script>
					alert('Avaliação excluída com sucesso!');
					window.location.href = 'alunos.php';
				</script>";
			exit();
    } else {
        // Registro de erro (pode ser melhorado com um log ou mensagem para o usuário)
        echo "Erro ao excluir a avaliação: " . mysqli_error($conn);
        exit;
    }
} else {
    // Redireciona para a página de avaliações se o ID não for válido
    header("Location: index.html");
    exit;
}

// Fecha a conexão
mysqli_close($conn);
?>
