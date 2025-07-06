document.addEventListener("DOMContentLoaded", function () {
  
  const feiras = JSON.parse(localStorage.getItem('feiras') || '[]');
  const feiraSelect = document.querySelector('#feiraSelect');
  const produtosList = document.querySelector('#produtosList');
  const addProdutoBtn = document.querySelector('#addProdutoBtn');
  const gerenciarProdutosDiv = document.querySelector('.gerenciar-produtos');

  function popularSelectFeiras() {
    feiras.forEach((feira, index) => {
      const option = document.createElement('option');
      option.value = index;
      option.textContent = `${feira.nome} - ${feira.data}`;
      feiraSelect.appendChild(option);
    });
  }

  function salvarProdutos(feiraIndex, produtos) {
    feiras[feiraIndex].produtos = produtos; 
    localStorage.setItem('feiras', JSON.stringify(feiras));
  }

  function carregarProdutos(feiraIndex) {
    return feiras[feiraIndex].produtos || []; 
  }

  function renderProdutos(produtos) {
    produtosList.innerHTML = '';
    if (produtos.length === 0) {
      produtosList.innerHTML = '<p>Nenhum produto cadastrado para esta feira.</p>';
      return;
    }

    produtos.forEach((produto, index) => {
      const produtoItem = document.createElement('div');
      produtoItem.classList.add('produto-item');
      produtoItem.innerHTML = `
        <h4>${produto.nome}</h4>
        <p>Preço: R$ ${produto.preco.toFixed(2)}</p>
        <button onclick="editarProduto(${index})">Editar</button>
        <button onclick="deletarProduto(${index})">Deletar</button>
      `;
      produtosList.appendChild(produtoItem);
    });
  }

  let feiraSelecionada = null;
  let produtos = [];

  feiraSelect.addEventListener('change', function () {
    const index = feiraSelect.value;
    if (index === '') {
      gerenciarProdutosDiv.style.display = 'none';
      produtosList.innerHTML = '';
      feiraSelecionada = null;
      return;
    }

    feiraSelecionada = parseInt(index);
    produtos = carregarProdutos(feiraSelecionada);
    gerenciarProdutosDiv.style.display = 'block';
    renderProdutos(produtos);
  });

  addProdutoBtn.addEventListener('click', function () {
    const nome = prompt('Nome do Produto:');
    if (!nome) return alert('Nome é obrigatório.');

    let precoStr = prompt('Preço do Produto (ex: 15.50):');
    if (!precoStr) return alert('Preço é obrigatório.');

    let preco = parseFloat(precoStr.replace(',', '.'));
    if (isNaN(preco) || preco < 0) return alert('Preço inválido.');

    produtos.push({ nome, preco });
    salvarProdutos(feiraSelecionada, produtos);
    renderProdutos(produtos);
  });

  window.editarProduto = function (index) {
    const produto = produtos[index];
    const novoNome = prompt('Editar nome do Produto:', produto.nome);
    if (!novoNome) return alert('Nome é obrigatório.');

    let novoPrecoStr = prompt('Editar preço do Produto:', produto.preco.toFixed(2));
    if (!novoPrecoStr) return alert('Preço é obrigatório.');

    let novoPreco = parseFloat(novoPrecoStr.replace(',', '.'));
    if (isNaN(novoPreco) || novoPreco < 0) return alert('Preço inválido.');

    produtos[index] = { nome: novoNome, preco: novoPreco };
    salvarProdutos(feiraSelecionada, produtos);
    renderProdutos(produtos);
  };

  window.deletarProduto = function (index) {
    if (confirm('Tem certeza que deseja deletar este produto?')) {
      produtos.splice(index, 1);
      salvarProdutos(feiraSelecionada, produtos);
      renderProdutos(produtos);
    }
  };

  popularSelectFeiras();
});