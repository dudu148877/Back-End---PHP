<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Carrinho</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="container mt-4">
    <h1>Carrinho de Compras</h1>
    <?php if (empty($carrinho)): ?>
        <p>Carrinho vazio.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($carrinho as $produtoId => $quantidade):
                    require_once "models/Produto.php";
                    $produtoModel = new Produto();
                    $produto = $produtoModel->getById($produtoId);
                    $subtotal = $produto['preco'] * $quantidade;
                    $total += $subtotal;
                ?>
                <tr>
                    <td><?= htmlspecialchars($produto['nome']) ?></td>
                    <td><?= $quantidade ?></td>
                    <td>R$ <?= number_format($subtotal, 2, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p><strong>Total: R$ <?= number_format($total, 2, ',', '.') ?></strong></p>

<?php
// Cálculo do frete conforme subtotal
if ($total >= 52 && $total <= 166.59) {
    $frete = 15.00;
} elseif ($total > 200) {
    $frete = 0.00;
} else {
    $frete = 20.00;
}
?>

<p><strong>Frete: R$ <?= number_format($frete, 2, ',', '.') ?></strong></p>
<p><strong>Total com Frete: R$ <?= number_format($total + $frete, 2, ',', '.') ?></strong></p>

<form method="post" action="index.php?action=finalizar_pedido">
    <div class="mb-3">
        <label for="cep" class="form-label">CEP</label>
        <input type="text" id="cep" name="cep" class="form-control" required />
    </div>
    <button type="submit" class="btn btn-primary">Finalizar Pedido</button>
</form>

<script>
    // Exemplo simples para buscar endereço via ViaCEP (pode ser melhorado)
    document.getElementById('cep').addEventListener('blur', function() {
        const cep = this.value.replace(/\D/g, '');
        if (cep.length === 8) {
            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(response => response.json())
                .then(data => {
                    if (!data.erro) {
                        alert(`Endereço: ${data.logradouro}, ${data.bairro}, ${data.localidade} - ${data.uf}`);
                    } else {
                        alert('CEP não encontrado.');
                    }
                })
                .catch(() => alert('Erro ao consultar CEP.'));
        }
    });
</script>

<?php endif; ?>
</body>
</html>
