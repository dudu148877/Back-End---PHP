<?php
require_once "config.php";

class Estoque {
    public function create($produtoId, $quantidade) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO estoque (produto_id, quantidade) VALUES (?, ?)");
        $stmt->execute([$produtoId, $quantidade]);
    }

    public function updateByProdutoId($produtoId, $quantidade) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE estoque SET quantidade = ? WHERE produto_id = ?");
        $stmt->execute([$quantidade, $produtoId]);
    }

    public function getByProdutoId($produtoId) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM estoque WHERE produto_id = ?");
        $stmt->execute([$produtoId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
