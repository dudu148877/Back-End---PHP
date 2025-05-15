<?php
require_once "config.php";

class Variacao {
    public function create($produtoId, $nome) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO variacoes (produto_id, nome) VALUES (?, ?)");
        $stmt->execute([$produtoId, $nome]);
    }

    public function deleteByProdutoId($produtoId) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM variacoes WHERE produto_id = ?");
        $stmt->execute([$produtoId]);
    }

    public function getByProdutoId($produtoId) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM variacoes WHERE produto_id = ?");
        $stmt->execute([$produtoId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
