<?php
session_start();
include_once "sessao.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dsAluno = $_POST['dsAluno'];
    $dtNascimento = $_POST['dtNascimento'];
    $nrAltura = $_POST['nrAltura'];
    $nrEnvergadura = $_POST['nrEnvergadura'];
    $nrCintura = $_POST['nrCintura'];
    $flSexo = $_POST['flSexo']; 
    $txIMC = $_POST['txIMC'];
    $idAluno = $_POST['idAluno'];

    $sql = "UPDATE alunos SET dsAluno=?, dtNascimento=?, txIMC=?, nrAltura=?, nrEnvergadura=?, nrCintura=?, flSexo=? WHERE idAluno=?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, 'ssddddsi', $dsAluno, $dtNascimento, $txIMC, $nrAltura, $nrEnvergadura, $nrCintura, $flSexo, $idAluno);

        if (mysqli_stmt_execute($stmt)) {
            // Redireciona com sucesso
            header("Location: index.php?status=sucesso");
        } else {
            // Log do erro de execução da query
            error_log("Erro na execução da query: " . mysqli_stmt_error($stmt));
            header("Location: index.php?status=erro");
        }

        mysqli_stmt_close($stmt);
    } else {
        // Log do erro ao preparar a declaração
        error_log("Erro ao preparar a declaração: " . mysqli_error($conn));
        header("Location: index.php?status=erro");
    }
}

mysqli_close($conn);
?>
