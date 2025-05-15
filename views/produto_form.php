<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Cadastro Produto</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
  <style>
    body {
      background: #f8f9fa;
    }
    .variacao-item {
      position: relative;
    }
    .btn-remove-variacao {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      border-radius: 50%;
      width: 30px;
      height: 30px;
      padding: 0;
      line-height: 1;
    }
  </style>
</head>
<body class="container py-5">
  <div class="card shadow-sm">
    <div class="card-body">

    
      <div id="alertContainer"></div>

      <h1 class="mb-4 text-primary">Cadastro de Produto</h1>
      <form id="produtoForm" action="index.php?c=produto&a=save" method="POST" novalidate>
        <input type="hidden" name="id" value="<?= $produto['id'] ?? '' ?>" />

        <div class="mb-3">
          <label for="nome" class="form-label fw-semibold">Nome</label>
          <input
            type="text"
            id="nome"
            name="nome"
            class="form-control"
            value="<?= $produto['nome'] ?? '' ?>"
            placeholder="Nome do produto"
            required
          />
          <div class="invalid-feedback">Por favor, informe o nome do produto.</div>
        </div>

        <div class="mb-3">
          <label for="preco" class="form-label fw-semibold">Preço (R$)</label>
          <input
            type="number"
            id="preco"
            name="preco"
            step="0.01"
            min="0"
            class="form-control"
            value="<?= $produto['preco'] ?? '' ?>"
            placeholder="Ex: 19.99"
            required
          />
          <div class="invalid-feedback">Informe um preço válido.</div>
        </div>

        <div id="variacoesContainer" class="mb-3">
          <label class="form-label fw-semibold">Variações</label>
          <div id="variacoesList" class="d-flex flex-column gap-2">
            <?php if (!empty($variacoes)): ?>
              <?php foreach ($variacoes as $v): ?>
                <div class="variacao-item input-group">
                  <input
                    type="text"
                    name="variacoes[]"
                    class="form-control"
                    value="<?= htmlspecialchars($v['nome']) ?>"
                    placeholder="Nome da variação"
                    required
                  />
                  <button type="button" class="btn btn-outline-danger btn-remove-variacao" title="Remover variação">&times;</button>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="variacao-item input-group">
                <input
                  type="text"
                  name="variacoes[]"
                  class="form-control"
                  placeholder="Nome da variação"
                  required
                />
                <button type="button" class="btn btn-outline-danger btn-remove-variacao" title="Remover variação">&times;</button>
              </div>
            <?php endif; ?>
          </div>
          <button
            type="button"
            id="btnAddVariacao"
            class="btn btn-secondary btn-sm mt-2"
          >
            + Adicionar Variação
          </button>
          <div class="form-text">Adicione diferentes variações do produto.</div>
        </div>

        <div class="mb-3">
          <label for="estoque" class="form-label fw-semibold">Estoque</label>
          <input
            type="number"
            id="estoque"
            name="estoque"
            min="0"
            class="form-control"
            value="<?= $estoque['quantidade'] ?? 0 ?>"
            required
          />
          <div class="invalid-feedback">Informe a quantidade em estoque.</div>
        </div>

        <button type="submit" class="btn btn-primary w-100">Salvar Produto</button>
      </form>
    </div>
  </div>
  <script>
  (() => {
    const form = document.getElementById('produtoForm');
    const btnAddVariacao = document.getElementById('btnAddVariacao');
    const variacoesList = document.getElementById('variacoesList');
    const inputNome = document.getElementById('nome');

  
    inputNome.addEventListener('input', (e) => {
      e.target.value = e.target.value.replace(/[0-9]/g, '');
    });

    
    form.addEventListener('submit', (e) => {
    
      if (/\d/.test(inputNome.value)) {
        e.preventDefault();
        inputNome.classList.add('is-invalid');
        inputNome.focus();
        return;
      } else {
        inputNome.classList.remove('is-invalid');
      }

      
      const inputsVariacoes = variacoesList.querySelectorAll('input[name="variacoes[]"]');
      for (const input of inputsVariacoes) {
        if (!input.value.trim()) {
          e.preventDefault();
          input.classList.add('is-invalid');
          input.focus();
          return;
        } else {
          input.classList.remove('is-invalid');
        }
      }

       
      if (!form.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
      }

      form.classList.add('was-validated');
    });
  })();
</script>

  <script>
    (() => {
      const form = document.getElementById('produtoForm');
      const btnAddVariacao = document.getElementById('btnAddVariacao');
      const variacoesList = document.getElementById('variacoesList');

     
      function criarVariacao(nome = '') {
        const wrapper = document.createElement('div');
        wrapper.classList.add('variacao-item', 'input-group');

        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'variacoes[]';
        input.className = 'form-control';
        input.placeholder = 'Nome da variação';
        input.value = nome;
        input.required = true;

        const btnRemover = document.createElement('button');
        btnRemover.type = 'button';
        btnRemover.className = 'btn btn-outline-danger btn-remove-variacao';
        btnRemover.title = 'Remover variação';
        btnRemover.innerHTML = '&times;';

        btnRemover.addEventListener('click', () => {
          if (variacoesList.children.length > 1) {
            wrapper.remove();
          } else {
            alert('Deve haver pelo menos uma variação.');
          }
        });

        wrapper.appendChild(input);
        wrapper.appendChild(btnRemover);

        return wrapper;
      }

      
      btnAddVariacao.addEventListener('click', () => {
        const novaVariacao = criarVariacao();
        variacoesList.appendChild(novaVariacao);
        novaVariacao.querySelector('input').focus();
      });

       
      Array.from(document.querySelectorAll('.btn-remove-variacao')).forEach(
        (btn) => {
          btn.addEventListener('click', (e) => {
            if (variacoesList.children.length > 1) {
              btn.closest('.variacao-item').remove();
            } else {
              alert('Deve haver pelo menos uma variação.');
            }
          });
        }
      );

     
      form.addEventListener('submit', (e) => {
       
        const inputsVariacoes = variacoesList.querySelectorAll('input[name="variacoes[]"]');
        for (const input of inputsVariacoes) {
          if (!input.value.trim()) {
            e.preventDefault();
            input.classList.add('is-invalid');
            input.focus();
            return;
          } else {
            input.classList.remove('is-invalid');
          }
        }

         
        if (!form.checkValidity()) {
          e.preventDefault();
          e.stopPropagation();
        }

        form.classList.add('was-validated');
      });
    })();
  </script>

 
  <script>
    (function() {
      const alertContainer = document.getElementById('alertContainer');
      const params = new URLSearchParams(window.location.search);
      const status = params.get('status');  
      const msg = params.get('msg');

      if (status && msg) {
        const alertType = status === 'success' ? 'alert-success' : 'alert-danger';
        const alertHtml = `
          <div class="alert ${alertType} alert-dismissible fade show" role="alert">
            ${decodeURIComponent(msg)}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        `;
        alertContainer.innerHTML = alertHtml;

        
        window.history.replaceState({}, document.title, window.location.pathname);
      }
    })();
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
