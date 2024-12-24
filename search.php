<?php
// Verifica se o formulário foi enviado com POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Verifica se o campo 'aluno' foi enviado
    if (isset($_POST['aluno'])) {
        // Evitar injeção SQL
        $alunoSelecionado = htmlspecialchars($_POST['aluno']);

        $localhost = "192.168.20.2";
        $user = "root";
        $password = "12345";
        $banco = "atletismo";

        $conn = new mysqli($localhost, $user, $password, $banco);

        // Verifica a conexão
        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        // Consulta os dados do aluno selecionado
        $sql = "SELECT * FROM alunos WHERE dsAluno = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $alunoSelecionado);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {

            // Mostra dados do aluno
            while ($row = $result->fetch_assoc()) {

                // Exemplo: Supondo que a tabela tem colunas 'id', 'dsAlunos', 'email', etc.
                echo "<p><strong>ID:</strong> " . htmlspecialchars($row["id"]) . "</p>";
                echo "<p><strong>Nome:</strong> " . htmlspecialchars($row["dsAluno"]) . "</p>";
                echo "<p><strong>Data de nascimento:</strong> " . htmlspecialchars($row["dtNascimento"]) . "</p>";
                echo "<p><strong>Taxa de IMC:</strong> " . htmlspecialchars($row["txIMC"]) . "</p>";
                echo "<p><strong>Altura:</strong> " . htmlspecialchars($row["nrAltura"]) . "</p>";
                echo "<p><strong>Envergadura:</strong> " . htmlspecialchars($row["nrEnvergadura"]) . "</p>";
                echo "<p><strong>Cintura:</strong> " . htmlspecialchars($row["nrCintura"]) . "</p>";
                echo "<p><strong>Sexo:</strong> " . htmlspecialchars($row["flSexo"]) . "</p>";
                // Adicione mais campos conforme necessário
            }
        } else {
            echo "<p>Nenhum dado encontrado para o aluno selecionado.</p>";
        }

        // Fechar conexão
        $stmt->close();
        $conn->close();

        echo "<a href='index.php' class='btn btn-primary'>Voltar</a>
            </div>
            <script src='https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js'></script>
        </body>
        </html>";
    } else {
        echo "Campo aluno não enviado!";
    }
} else {
    echo "Erro!";
}
?>
