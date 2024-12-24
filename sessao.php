<?php
    // Conexão
    include_once "conexao.php";

    $conn = mysqli_connect($localhost, $user, $password, $banco);

    // Configura a codificação para evitar problemas com caracteres especiais
    mysqli_set_charset($conn, 'utf8');

    // Verifica se a conexão foi bem-sucedida
    if (!$conn) {
        echo "<script>alert('Não foi possível conectar ao Banco de Dados!');</script>";
        header('Location: logout.php');
        exit();  // Termina a execução após o redirecionamento
    }

    // Inicia a sessão
    session_start();

    // Verifica se as variáveis de sessão estão definidas
    if ((!isset($_SESSION["usuario"])) || (!isset($_SESSION["senha"]))) {
        header("Location: index.html");
        exit();  // Termina a execução após o redirecionamento
    } else {
        $usuario = $_SESSION["usuario"];
        $senha = $_SESSION["senha"];
    }
?>