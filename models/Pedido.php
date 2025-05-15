<?php
require_once "config.php";

class Pedido {
    public function create($cliente, $cep, $subtotal, $frete, $total, $status = 'pendente') {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO pedidos (cliente, cep, subtotal, frete, total, status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$cliente, $cep, $subtotal, $frete, $total, $status]);
        return $pdo->lastInsertId();
    }

    public function updateStatus($id, $status) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE pedidos SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
    }

    public function delete($id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM pedidos WHERE id = ?");
        $stmt->execute([$id]);
    }
}
