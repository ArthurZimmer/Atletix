<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <?php
    // Conexão com o banco de dados (lembre-se de preencher com seus dados)
    $conn = mysqli_connect("192.168.20.2", "root", "12345", "atletismoZimmer");
    if (!$conn) {
        die("Falha na conexão: " . mysqli_connect_error());
    }

    // Consulta SQL
    $sql = "SELECT vlrAptidao FROM avaliacoes";
    $result = mysqli_query($conn, $sql);

    // Array para armazenar os dados
    $perfomanceData = [];

    if (mysqli_num_rows($result) > 0) {
        // Armazena cada valor em um array
        while ($row = mysqli_fetch_assoc($result)) {
            $perfomanceData[] = $row['vlrAptidao'];
        }
    }

    // Fechar a conexão
    mysqli_close($conn);
    ?>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            // PHP passa o array para JavaScript
            var perfomanceData = <?php echo json_encode($perfomanceData); ?>;

            // Constrói a tabela de dados no formato esperado pelo Google Charts
            var data = google.visualization.arrayToDataTable([
                ['Semestre', 'Performance'],
                ['1', perfomanceData[0]],
                ['2', perfomanceData[1]],
                // Adicione mais linhas conforme necessário
            ]);

            var options = {
                title: 'Rendimento',
                curveType: 'function',
                legend: { position: 'bottom' }
            };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
            chart.draw(data, options);
        }
    </script>
</head>
<body>
    <div id="curve_chart" style="width: 900px; height: 500px"></div>
</body>
</html>
