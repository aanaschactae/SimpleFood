<?php
function s($v) {
    return htmlspecialchars(trim((string)$v), ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $genero = $_POST['genero'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $data_nasc = $_POST['data_nasc'] ?? '';

    $errors = [];
    if (empty($nome)) $errors[] = 'Nome é obrigatório.';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'E-mail inválido.';

    $dados = [
        'nome' => $nome,
        'email' => $email,
        'genero' => $genero,
        'telefone' => $telefone,
        'data_nasc' => $data_nasc,
        'enviado_em' => date('Y-m-d H:i:s')
    ];

    $responseFromSheet = null;
    $curlError = null;
    if (empty($errors)) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://localhost/simplefood/action_planilha.php');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($dados));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $responseFromSheet = curl_exec($ch);
        if ($responseFromSheet === false) {
            $curlError = curl_error($ch);
        }
        curl_close($ch);
    }
} else {
    header('Location: perfil.html');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SimpleFood - Dados Enviados</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h2>SimpleFood</h2>
    <nav>
        <a href="index.html">Início</a>
        <a href="tabela.html">Tabela IMC</a>
        <a href="pqsimplefood.html">Por que SimplePlan?</a>
        <a href="perfil.html">Seu Perfil</a>
    </nav>
</header>
<main>
    <h1>Resultado do Envio</h1>
    <?php if (!empty($errors)): ?>
        <div class="errors">
            <h3>Ocorreram erros:</h3>
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?php echo s($e); ?></li>
                <?php endforeach; ?>
            </ul>
            <p><a href="perfil.html">Voltar ao formulário</a></p>
        </div>
    <?php else: ?>
        <div class="perfil-form">
            <p><strong>Nome:</strong> <?php echo s($nome); ?></p>
            <p><strong>Email:</strong> <?php echo s($email); ?></p>
            <p><strong>Gênero:</strong> <?php echo s($genero); ?></p>
            <p><strong>Telefone:</strong> <?php echo s($telefone); ?></p>
            <p><strong>Data de nascimento:</strong> <?php echo s($data_nasc); ?></p>
            <p><strong>Enviado em:</strong> <?php echo s($dados['enviado_em']); ?></p>

            <?php if ($curlError): ?>
                <h3>Erro ao enviar para a planilha:</h3>
                <pre><?php echo s($curlError); ?></pre>
            <?php else: ?>
                <h3>Resposta do servidor (planilha):</h3>
                <pre><?php echo s($responseFromSheet ?? 'Sem resposta'); ?></pre>
            <?php endif; ?>

            <p><a href="perfil.html">Enviar outro</a></p>
        </div>
    <?php endif; ?>
</main>
<footer>
    <p>&copy; 2025 SimpleFood - Todos os direitos reservados</p>
</footer>
</body>
</html>

