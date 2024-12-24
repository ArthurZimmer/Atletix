<?php
// Inicia a sessão
session_start(); 

// Inclui o arquivo de conexão
include_once "conexao.php";

// Verifica se o formulário foi enviado corretamente
if (isset($_POST['aluno'])) {
    // Limpa os espaços em branco do início e fim da entrada
    $nomeCompleto = trim($_POST['aluno']); 

    // Verifica se o campo não está vazio
    if (!empty($nomeCompleto)) {
        // Armazena o valor do campo na sessão
        $_SESSION['nomeCompleto'] = htmlspecialchars($nomeCompleto); 

        // Redireciona para a página alunos.php
        header('Location: alunos.php');
        exit; // Certifica-se de que o script para aqui
    } else {
        // Caso o campo esteja vazio, exibe uma mensagem de erro
        echo 'Por favor, digite algo na busca.';
    }
} else {
    // Se o formulário não foi enviado corretamente
    echo 'Formulário inválido.';
}
?>
