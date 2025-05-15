<?php
require_once "models/Pedido.php";
require_once "models/Cupom.php";

class PedidoController {
    public function carrinho() {
        $carrinho = $_SESSION['carrinho'] ?? [];
        require "views/carrinho.php";
    }

    public function adicionar() {
        $produtoId = $_POST['produto_id'] ?? null;
        $quantidade = intval($_POST['quantidade'] ?? 1);
        if (!$produtoId || $quantidade < 1) {
            header("Location: index.php?c=pedido&a=carrinho");
            exit;
        }

         
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }

        if (isset($_SESSION['carrinho'][$produtoId])) {
            $_SESSION['carrinho'][$produtoId] += $quantidade;
        } else {
            $_SESSION['carrinho'][$produtoId] = $quantidade;
        }

        header("Location: index.php?c=pedido&a=carrinho");
    }

   
}
