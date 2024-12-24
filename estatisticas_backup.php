<?php 
include_once "sessao.php";
include_once "conexao.php";
include_once "header.php";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        #wrapper {
            min-height: 100vh;
            display: flex;
        }

        #content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        #content {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 0; /* Importante para permitir scroll interno */
        }

        .stats-container {
            padding: 2rem;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 0; /* Permite que o conteúdo seja scrollável */
            overflow-y: auto;
        }

        .page-title {
            color: #2c3e50;
            margin-bottom: 1.5rem;
            font-weight: 600;
            position: relative;
            padding-bottom: 0.5rem;
            flex-shrink: 0; /* Evita que o título encolha */
        }

        .page-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: rgba(54, 162, 235, 0.8);
        }

        .selection-container {
            background: #f8f9fc;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            border: 1px solid rgba(54, 162, 235, 0.1);
            flex-shrink: 0; /* Evita que o formulário encolha */
        }

        .form-group label {
            color: #2c3e50;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            border: 1px solid #e3e6f0;
            padding: 0.75rem;
            border-radius: 6px;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
            width: 100%;
            height: auto;
        }

        .form-control:focus {
            border-color: rgba(54, 162, 235, 0.5);
            box-shadow: 0 0 0 0.2rem rgba(54, 162, 235, 0.1);
        }

        .chart-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            margin-top: 2rem;
            flex: 1;
            min-height: 300px; /* Altura mínima para o gráfico */
            display: flex;
            flex-direction: column;
        }

        .chart-wrapper {
            position: relative;
            flex: 1;
            min-height: 0; /* Permite que o gráfico se ajuste */
            width: 100%;
        }

        canvas#graphCanvas {
            width: 100% !important;
            height: 100% !important;
        }

        @media (max-width: 768px) {
            .stats-container {
                padding: 1rem;
            }
            
            .chart-container {
                min-height: 250px; /* Altura mínima menor para mobile */
            }

            .row {
                flex-direction: column;
            }

            .col-md-6 {
                width: 100%;
            }
        }

        /* Ajuste para o conteúdo scrollável */
        .container-fluid {
            height: 100%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Estilo para o rodapé */
        footer {
            flex-shrink: 0; /* Evita que o rodapé encolha */
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include_once "sidebar.php"; ?>
        
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include_once "topbar.php"; ?>

                <div class="container-fluid stats-container">
                    <h1 class="page-title">Estatísticas de Desempenho</h1>
                    
                    <div class="selection-container">
                        <form id="formulario" method="post" action="estatisticas_backup.php">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="aluno">Aluno(a)</label>
                                        <select class="form-control" id="aluno" name="aluno" required>
                                            <option value="">Selecione o(a) Aluno(a)...</option>
                                            <?php 
                                            $idAluno = isset($_POST['aluno']) ? $_POST['aluno'] : '';
                                            $sql1 = "SELECT idAluno, dsAluno FROM alunos ORDER BY dsAluno";
                                            $resultado1 = mysqli_query($conn, $sql1);
                                            while ($linha1 = mysqli_fetch_array($resultado1, MYSQLI_NUM)) {
                                                $selected = ($linha1[0] == $idAluno) ? 'selected' : '';
                                                echo "<option value='{$linha1[0]}' {$selected}>{$linha1[1]}</option>";
                                            } 
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="aptidao">Aptidão</label>
                                        <select class="form-control" id="aptidao" name="aptidao" onchange="this.form.submit()" required>
                                            <option value="">Selecione a aptidão...</option>
                                            <?php 
                                            $sql2 = "SELECT dsAptidao FROM aptidoes";
                                            $resultado2 = mysqli_query($conn, $sql2);
                                            while ($linha2 = mysqli_fetch_array($resultado2, MYSQLI_NUM)) {
                                                echo "<option value='{$linha2[0]}'>{$linha2[0]}</option>";
                                            } 
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <?php
                    if (isset($_POST['aluno']) && isset($_POST['aptidao'])) {
                        $idAluno = $_POST['aluno'];
                        $dsAptidao = $_POST['aptidao'];

                        $sql = "SELECT dtAvaliacao, vlrAptidao 
                               FROM avaliacoes 
                               WHERE idAluno = ? AND dsAptidao = ? 
                               ORDER BY dtAvaliacao";
                        
                        $stmt = mysqli_prepare($conn, $sql);
                        mysqli_stmt_bind_param($stmt, "is", $idAluno, $dsAptidao);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);

                        $rotulosX = array();
                        $dados = array();
                        
                        while ($row = mysqli_fetch_assoc($result)) {
                            $date = DateTime::createFromFormat('Y-m-d', $row['dtAvaliacao']);
                            if ($date) {
                                $rotulosX[] = $date->format('d/m/Y');
                                $dados[] = $row['vlrAptidao'];
                            }
                        }
                    ?>
                        <div class="chart-container">
                            <div class="chart-wrapper">
                                <canvas id="graphCanvas"></canvas>
                            </div>
                            
                            <script>
                                const rotulosX = <?php echo json_encode($rotulosX); ?>;
                                const dados = <?php echo json_encode($dados); ?>;
                                const ctx = document.getElementById('graphCanvas');

                                new Chart(ctx, {
                                    type: 'line',
                                    data: {
                                        labels: rotulosX,
                                        datasets: [{
                                            label: 'Desempenho',
                                            data: dados,
                                            backgroundColor: 'rgba(54, 162, 235, 0.1)',
                                            borderColor: 'rgba(54, 162, 235, 0.8)',
                                            borderWidth: 2,
                                            pointRadius: 4,
                                            pointBackgroundColor: '#fff',
                                            pointBorderColor: 'rgba(54, 162, 235, 0.8)',
                                            pointBorderWidth: 2,
                                            tension: 0.3,
                                            fill: true
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        scales: {
                                            y: {
                                                beginAtZero: true,
                                                grid: {
                                                    color: 'rgba(0, 0, 0, 0.05)'
                                                },
                                                ticks: {
                                                    font: {
                                                        size: 12
                                                    }
                                                },
                                                title: {
                                                    display: true,
                                                    text: 'Desempenho',
                                                    font: {
                                                        size: 14,
                                                        weight: 'bold'
                                                    }
                                                }
                                            },
                                            x: {
                                                grid: {
                                                    color: 'rgba(0, 0, 0, 0.05)'
                                                },
                                                ticks: {
                                                    font: {
                                                        size: 12
                                                    }
                                                },
                                                title: {
                                                    display: true,
                                                    text: 'Data da Avaliação',
                                                    font: {
                                                        size: 14,
                                                        weight: 'bold'
                                                    }
                                                }
                                            }
                                        },
                                        plugins: {
                                            title: {
                                                display: true,
                                                text: 'Evolução do Desempenho em <?php echo $dsAptidao; ?>',
                                                font: {
                                                    size: 16,
                                                    weight: 'bold'
                                                },
                                                padding: 20
                                            },
                                            legend: {
                                                display: false
                                            }
                                        }
                                    }
                                });
                            </script>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <?php include_once "rodape.php"; ?>
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php include_once "footer.php"; ?>
</body>
</html>