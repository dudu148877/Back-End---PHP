<?php
 
session_start();

$host = "localhost";
$dbname = "sistema_comprass";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

 
function buscarCEP($cep) {
    $cep = preg_replace('/[^0-9]/', '', $cep);
    $url = "https://viacep.com.br/ws/$cep/json/";
    $dados = @file_get_contents($url);
    if ($dados === false) return null;
    $json = json_decode($dados, true);
    if (isset($json['erro'])) return null;
    return $json;
}
