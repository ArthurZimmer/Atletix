                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Alerts -->
                        <div class="topbar-divider d-none d-sm-block"></div>

						<?php
                            include_once('sessao');

                            $nome = $_SESSION['nome'];
                            $email = $_SESSION["usuario"];
                            $senha = $_SESSION["senha"];

                            // Consulta SQL para buscar o campo dsFoto
                            $query = "SELECT dsFoto FROM usuarios WHERE dsEmail = '$email' AND dsSenha = '$senha'";
                            $result = mysqli_query($conn, $query);

                            // Verifica se o resultado retornou alguma linha
                            if ($result && mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result); // Extrai os dados da linha
                                $foto = $row['dsFoto']; // Atribui o caminho da foto
                            } else {
                                // Define uma imagem padrão se não houver resultado no banco
                                $foto = 'path/to/default-profile.png';
                            }
                        ?>


                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $nome;?></span>
                                <img class="img-profile rounded-circle"
                                    src="<?php echo $foto;?>">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="perfil.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Perfil
                                </a>
<!--                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>-->
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Sair
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>