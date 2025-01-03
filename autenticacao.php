// autenticacao.php
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    // conexão
    session_start();

    include_once "conexao.php";

    $conn = mysqli_connect($localhost, $user, $password, $banco);

    if (!$conn) {
        header('Location: index.html?error=db');
        exit();
    }

    $user = $_POST['usuario'];
    $password = $_POST['senha'];
    
    // Usando prepared statement para prevenir SQL injection
    $sql = "SELECT * FROM usuarios WHERE dsEmail=? AND dsSenha=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $user, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_num_rows($result);
    
    if ($row > 0) {
        $row = mysqli_fetch_array($result, MYSQLI_NUM);
        // cria sessão
        $_SESSION['id'] = $row[0];
        $_SESSION['nome'] = $row[1];
        $_SESSION['usuario'] = $user;
        $_SESSION['senha'] = $password;
        $_SESSION['foto'] = $row[4];

        header('Location: index.php');
        exit();
    } else {
        header('Location: index.html?error=invalid');
        exit();
    }
?>

// index.html
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Atletix</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="img/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="img/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="img/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="img/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="img/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="img/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="img/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="img/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image">
                                <center>
                                    <img src="img\logo.png">
                                </center>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <!-- Error Card -->
                                    <div id="errorCard" class="alert alert-danger alert-dismissible fade show" style="display: none;" role="alert">
                                        <strong>Erro!</strong> <span id="errorMessage">Usuário ou senha incorretos.</span>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4"><b>Login - Atletix</b></h1>
                                    </div>
                                    
                                    <form class="user" action="autenticacao.php" method="post" autocomplete="off">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="usuario" name="usuario" aria-describedby="emailHelp"
                                                placeholder="Entre E-mail..." value="" autofocus required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="senha" name="senha" placeholder="Senha" value="" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                                    </form>
                                    
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.html">Esqueceu a Senha?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="register.html">Crie uma Conta!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Error handling script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const error = urlParams.get('error');
            
            if (error) {
                const errorCard = document.getElementById('errorCard');
                const errorMessage = document.getElementById('errorMessage');
                
                if (error === 'invalid') {
                    errorMessage.textContent = 'Usuário ou senha incorretos.';
                } else if (error === 'db') {
                    errorMessage.textContent = 'Erro ao conectar ao banco de dados.';
                }
                
                errorCard.style.display = 'block';
            }
        });
    </script>
</body>
</html>