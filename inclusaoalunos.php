<?php
    $dsAluno = $_POST['dsAluno'];
    $dtNascimento = $_POST['dtNascimento'];
    $nrAltura = $_POST['nrAltura'];
    $nrEnvergadura = $_POST['nrEnvergadura'];
    $nrCintura = $_POST['nrCintura'];
    $flSexo = $_POST['nrSexo'];
    $txIMC = $_POST['txIMC'];

    include_once "sessao.php";

    $sql = "INSERT INTO alunos (dsAluno, dtNascimento, txIMC, nrAltura, nrEnvergadura, nrCintura, flSexo) VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'ssdddds', $dsAluno, $dtNascimento, $txIMC, $nrAltura, $nrEnvergadura, $nrCintura, $flSexo);

        $result = mysqli_stmt_execute($stmt);

        if (!$result) {
            header("Location: index.html");
        } else {
            header("Location: alunos.php");
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Erro ao preparar a declaração:  " . mysqli_error($conn);
    }

    mysqli_close($conn);

?>
