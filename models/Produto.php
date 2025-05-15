<?php
require_once "config.php";

class Produto {
    public function create($nome, $preco) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO produtos (nome, preco) VALUES (?, ?)");
        $stmt->execute([$nome, $preco]);
        return $pdo->lastInsertId();
    }

    public function update($id, $nome, $preco) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE produtos SET nome = ?, preco = ? WHERE id = ?");
        $stmt->execute([$nome, $preco, $id]);
    }

    public function getById($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
