<?php
require_once "models/Produto.php";
require_once "models/Estoque.php";
require_once "models/Variacao.php";

class ProdutoController {
    public function form() {
       
        $id = $_GET['id'] ?? null;
        $produto = null;
        $variacoes = [];
        $estoque = null;

        if ($id) {
            $produtoModel = new Produto();
            $produto = $produtoModel->getById($id);

            $variacaoModel = new Variacao();
            $variacoes = $variacaoModel->getByProdutoId($id);

            $estoqueModel = new Estoque();
            $estoque = $estoqueModel->getByProdutoId($id);
        }
        require "views/produto_form.php";
    }

    public function save() {
        $produtoModel = new Produto();
        $estoqueModel = new Estoque();
        $variacaoModel = new Variacao();

        $id = $_POST['id'] ?? null;
        $nome = $_POST['nome'] ?? '';
        $preco = $_POST['preco'] ?? 0;
        $variacoes = $_POST['variacoes'] ?? [];
        $estoqueQtd = $_POST['estoque'] ?? 0;

        if ($id) {
            $produtoModel->update($id, $nome, $preco);
            $estoqueModel->updateByProdutoId($id, $estoqueQtd);
          
            $variacaoModel->deleteByProdutoId($id);
            foreach ($variacoes as $v) {
                $variacaoModel->create($id, $v);
            }
        } else {
            $novoId = $produtoModel->create($nome, $preco);
            $estoqueModel->create($novoId, $estoqueQtd);
            foreach ($variacoes as $v) {
                $variacaoModel->create($novoId, $v);
            }
        }
        header("Location: index.php?c=produto&a=form&id=" . ($id ?? $novoId) . "&status=success&msg=" . urlencode("Produto salvo com sucesso!"));
exit;  

    }
}
