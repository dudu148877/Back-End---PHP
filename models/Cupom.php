<?php
require_once "config.php";

class Cupom {
    public function getValidCupom($codigo) {
        global $pdo;
        $hoje = date('Y-m-d');
        $stmt = $pdo->prepare("SELECT * FROM cupons WHERE codigo = ? AND validade >= ? LIMIT 1");
        $stmt->execute([$codigo, $hoje]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
