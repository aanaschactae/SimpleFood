<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Método não permitido.";
    exit;
}

$url = "https://script.google.com/macros/s/SEU_SCRIPT_ID_AQUI/exec";

$data = [
    "nome" => $_POST["nome"] ?? "",
    "email" => $_POST["email"] ?? "",
    "genero" => $_POST["genero"] ?? "",
    "telefone" => $_POST["telefone"] ?? "",
    "data_nasc" => $_POST["data_nasc"] ?? "",
    "enviado_em" => date('Y-m-d H:i:s')
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
$response = curl_exec($ch);

if ($response === false) {
    $err = curl_error($ch);
    curl_close($ch);
    http_response_code(500);
    echo "Erro cURL: " . $err;
    exit;
}

curl_close($ch);
header('Content-Type: text/plain; charset=utf-8');
echo $response;
