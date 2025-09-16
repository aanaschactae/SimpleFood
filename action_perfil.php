<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locadora IFPR - Resultado do Formulário</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <!-- Cabeçalho -->
    <header>
        <h2>SimpleFood</h2>
        <nav>
            <a href="index.html">Início</a>
            <a href="tabela.html">Tabela IMC</a>
            <a href="pqsimplefood.html">Por que SimplePlan?</a>
            <a href="perfil.html">Seu Perfil</a>
        </nav>
    </header>

    <!-- Conteúdo principal -->
    <main>
        <h1>Dados do Usuário Enviados</h1>
        <div class="perfil-form">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                echo "<p><strong>Nome:</strong> " . htmlspecialchars($_POST["nome"]) . "</p>";
                echo "<p><strong>Email:</strong> " . htmlspecialchars($_POST["email"]) . "</p>";

                if (!empty($_POST["mensagem"])) {
                    echo "<p><strong>Mensagem:</strong> " . nl2br(htmlspecialchars($_POST["mensagem"])) . "</p>";
                }

                // Exibe os outros campos que o aluno adicionar
                foreach ($_POST as $campo => $valor) {
                    if (!in_array($campo, ["nome", "email", "gen", "telefone", "data_nasc"])) {
                        echo "<p><strong>" . ucfirst($campo) . ":</strong> " . htmlspecialchars($valor) . "</p>";
                    }
                }
            } else {
                echo "<p>Nenhum dado foi enviado.</p>";
            }
            ?>
        </div>
    </main>

    <!-- Rodapé -->
    <footer>
        <p>&copy; 2025 SimpleFood - Todos os direitos reservados</p>
    </footer>

</body>

</html>
