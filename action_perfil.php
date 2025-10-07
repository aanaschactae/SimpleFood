<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SimpleFood - Resultado do Formulário</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header>
        <h2>SimpleFood</h2>
        <nav>
            <a href="index.html">Início</a>
            <a href="pqsimplefood.html">Por que SimplePlan?</a>
            <a href="perfil.html">Seu Perfil</a>
        </nav>
    </header>

    <main>
        <h1>Dados Recebidos</h1>
        <div class="perfil-form">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                echo "<p><strong>Nome:</strong> " . htmlspecialchars($_POST["nome"]) . "</p>";
                echo "<p><strong>Email:</strong> " . htmlspecialchars($_POST["email"]) . "</p>";

                if (!empty($_POST["genero"])) {
                    echo "<p><strong>Gênero:</strong> " . htmlspecialchars($_POST["genero"]) . "</p>";
                }

                if (!empty($_POST["telefone"])) {
                    echo "<p><strong>Telefone:</strong> " . htmlspecialchars($_POST["telefone"]) . "</p>";
                }

                if (!empty($_POST["data_nasc"])) {
                    echo "<p><strong>Data de Nascimento:</strong> " . htmlspecialchars($_POST["data_nasc"]) . "</p>";
                }

                $dados = [
                    "nome" => $_POST["nome"] ?? "",
                    "email" => $_POST["email"] ?? "",
                    "genero" => $_POST["genero"] ?? "",
                    "telefone" => $_POST["telefone"] ?? "",
                    "data_nasc" => $_POST["data_nasc"] ?? "",
                    "enviado_em" => date('Y-m-d H:i:s')
                ];

                $apps_script_url = "https://script.google.com/macros/s/SEU_SCRIPT_ID_AQUI/exec";

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $apps_script_url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($dados));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                $erro = curl_error($ch);
                curl_close($ch);

                if ($response) {
                    echo "<h3>Dados enviados com sucesso!</h3>";
                    echo "<pre>" . htmlspecialchars($response) . "</pre>";
                } elseif ($erro) {
                    echo "<h3>Erro ao salvar:</h3>";
                    echo "<pre>" . htmlspecialchars($erro) . "</pre>";
                } else {
                    echo "<h3>Não houve resposta do servidor.</h3>";
                }

            } else {
                echo "<p>Nenhum dado foi enviado.</p>";
            }
            ?>
        </div>
        <p><a href="perfil.html">Voltar ao formulário</a></p>
    </main>

    <footer>
        <p>&copy; 2025 SimpleFood - Todos os direitos reservados</p>
    </footer>

</body>

</html>
