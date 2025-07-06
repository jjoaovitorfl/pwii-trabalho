document.addEventListener("DOMContentLoaded", function () {

  const listaFeiras = document.querySelector("#listaFeiras");
  const carrinhoTotal = document.querySelector("#carrinhoTotal");
  const finalizarCompraBtn = document.querySelector("#finalizarCompraBtn");
  const feiras = JSON.parse(localStorage.getItem("feiras") || "[]");
  const carrinho = JSON.parse(localStorage.getItem("carrinho") || "{}");

  function atualizarCarrinho() {
    let total = 0;
    const listaCarrinho = document.getElementById("listaCarrinho");
    listaCarrinho.innerHTML = "";

    Object.keys(carrinho).forEach((feiraId) => {
      carrinho[feiraId].forEach((item) => {
        const preco = Number(item.preco);
        const quantidade = Number(item.quantidade);
        const subtotal = preco * quantidade;

        total += subtotal;

        const li = document.createElement("li");
        li.textContent = `${item.nome} (${quantidade}x) - R$ ${subtotal.toFixed(2)}`;
        listaCarrinho.appendChild(li);
      });
    });

    carrinhoTotal.textContent = `Total: R$ ${total.toFixed(2)}`;
  }

  function adicionarAoCarrinho(feiraId, produto) {
    if (!carrinho[feiraId]) {
      carrinho[feiraId] = [];
    }

    const existente = carrinho[feiraId].find(p => p.nome === produto.nome);
    if (existente) {
      existente.quantidade++;
    } else {
      carrinho[feiraId].push({
        ...produto,
        preco: Number(produto.preco),
        quantidade: 1
      });
    }

    localStorage.setItem("carrinho", JSON.stringify(carrinho));
    atualizarCarrinho();
  }

  feiras.forEach((feira) => {
    const card = document.createElement("div");
    card.classList.add("feira");
    card.innerHTML = `
      <h3>${feira.nome}</h3>
      <p><strong>Endereço:</strong> ${feira.endereco}</p>
      <p><strong>Data:</strong> ${feira.data}</p>
    `;

    if (feira.produtos?.length > 0) {
      const produtosList = document.createElement("div");
      feira.produtos.forEach((produto) => {
        const item = document.createElement("div");
        item.classList.add("produto-item");
        item.innerHTML = `
          <h4>${produto.nome}</h4>
          <p>Preço: R$ ${Number(produto.preco).toFixed(2)}</p>
        `;
        const btn = document.createElement("button");
        btn.textContent = "Adicionar ao Carrinho";
        btn.addEventListener("click", () => adicionarAoCarrinho(feira.id, produto));
        item.appendChild(btn);
        produtosList.appendChild(item);
      });
      card.appendChild(produtosList);
    } else {
      const aviso = document.createElement("p");
      aviso.textContent = "Sem produtos cadastrados.";
      card.appendChild(aviso);
    }

    listaFeiras.appendChild(card);
  });

  finalizarCompraBtn.addEventListener("click", function () {
    if (Object.keys(carrinho).length === 0) {
      alert("Seu carrinho está vazio!");
      return;
    }

    let compra = {
      data: new Date().toLocaleString(),
      itens: []
    };

  Object.keys(carrinho).forEach(feiraId => {
    const feira = feiras.find(f => String(f.id) === String(feiraId));
    if (!feira) return;
    carrinho[feiraId].forEach(item => {
      compra.itens.push({
        ...item,
        preco: Number(item.preco),
        quantidade: Number(item.quantidade),
        feira: feira.nome
      });
    });
  });


    let historico = JSON.parse(localStorage.getItem("historicoCompras") || "[]");
    historico.push(compra);

    console.log("Carrinho:", carrinho);
    console.log("Compra gerada:", compra);

    localStorage.setItem("historicoCompras", JSON.stringify(historico));
    localStorage.removeItem("carrinho");
    alert("Compra finalizada com sucesso!");
    atualizarCarrinho();
  });

  atualizarCarrinho();
});