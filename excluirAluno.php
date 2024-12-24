<?php 
    $codigo = $_GET['codigo'];

    include_once "sessao.php";

    $sql = "DELETE FROM alunos WHERE idAluno = $codigo";
    $result = mysqli_query($conn, $sql);

    if (! $result) {
        header("Location: index.html");
    }
    else {
        header("Location: alunos.php");
    }

    mysqli_close($conn);
?>