<?php
// Conexão
include_once "sessao.php";

// Recebe parâmetros
$codigo = $_POST['codigo'];
$diretorio = "fotos/";
$arquivo = isset($_FILES["arquivo"]) ? $_FILES["arquivo"] : FALSE;
$nome = $_FILES["arquivo"]["name"];

// Verifica se o arquivo foi enviado e se não há erros
if ($arquivo && $arquivo["error"] === UPLOAD_ERR_OK) {

    // Define o caminho final da foto
    $foto = $diretorio.$nome;
    $fotoant = "";
	
    // Pega a foto anterior para possivelmente deletá-la
    $sql = "SELECT dsFoto FROM usuarios WHERE idUsuario = $codigo";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_array($result, MYSQLI_NUM);
        $fotoant = $row[0];
    }

    // Verifica se a pasta existe, e cria se necessário
    if (!file_exists("fotos")) {
        mkdir("fotos", 0777, true);
    }

    // Remove o arquivo antigo se existir
    if (!empty($fotoant) && file_exists($fotoant)) {
        unlink($fotoant);
    }

	// configura tamanho do arquivo de envio
	ini_set('post_max_size','512M');
	ini_set('upload_max_filsize','512M');
	
	if (move_uploaded_file($arquivo["tmp_name"], $diretorio.$arquivo["name"])) {
        // Atualiza o banco de dados com o caminho da nova foto
        $sql = "UPDATE usuarios SET dsFoto='$foto' WHERE idUsuario=$codigo";
		$result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<script>alert('Foto alterada com sucesso!');</script>";
            header("Location: perfil.php");
        } else {
            echo "<script>alert('Não foi possível alterar a foto!');</script>";
            echo "Erro SQL: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Não foi possível fazer upload da foto!');</script>";
    }
} else {
    // Tratamento de erros durante o upload
    $error_code = isset($arquivo["error"]) ? $arquivo["error"] : 'N/A';
    switch ($error_code) {
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            echo "<script>alert('O arquivo é maior que o permitido.');</script>";
            break;
        case UPLOAD_ERR_PARTIAL:
            echo "<script>alert('O arquivo foi carregado parcialmente.');</script>";
            break;
        case UPLOAD_ERR_NO_FILE:
            echo "<script>alert('Nenhum arquivo foi enviado.');</script>";
            break;
        case UPLOAD_ERR_NO_TMP_DIR:
            echo "<script>alert('Falta a pasta temporária.');</script>";
            break;
        case UPLOAD_ERR_CANT_WRITE:
            echo "<script>alert('Falha ao escrever o arquivo no disco.');</script>";
            break;
        case UPLOAD_ERR_EXTENSION:
            echo "<script>alert('Uma extensão do PHP parou o upload do arquivo.');</script>";
            break;
        default:
            echo "<script>alert('Erro desconhecido.');</script>";
            break;
    }
}

// Desconecta do banco
mysqli_close($conn);

// Redireciona após tudo estar concluído
//header("Location: perfil.php");
?>
