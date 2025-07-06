document.addEventListener("DOMContentLoaded", () => {
  
  let usuario = JSON.parse(localStorage.getItem("usuario")) || {};
  let historicoCompras = JSON.parse(localStorage.getItem("historicoCompras")) || [];

  const emailUsuario = document.querySelector('#emailUsuario');
  const tipoUsuario = document.querySelector('#tipoUsuario');
  const enderecoInput = document.querySelector('#endereco');
  const cpfInput = document.querySelector('#cpf');
  const btnEditarLogin = document.querySelector('#btnEditarLogin');
  const formDadosAdicionais = document.querySelector('#formDadosAdicionais');
  const enderecoUsuarioSpan = document.querySelector('#enderecoUsuario');
  const cpfUsuarioSpan = document.querySelector('#cpfUsuario');
  const btnEditarDadosAdicionais = document.querySelector('#btnEditarDadosAdicionais');
  const informacoesAdicionaisBloco = document.querySelector('#informacoesAdicionaisBloco');
  const historicoComprasElement = document.querySelector('#historicoCompras');
  const btnSair = document.querySelector("#sair");

  function exibirInformacoesCliente() {
    emailUsuario.textContent = usuario.email || "Não informado";
    tipoUsuario.textContent = usuario.tipo || "Não informado";
    enderecoUsuarioSpan.textContent = usuario.endereco || "Não informado";
    cpfUsuarioSpan.textContent = usuario.cpf || "Não informado";

    informacoesAdicionaisBloco.style.display = (usuario.endereco || usuario.cpf) ? 'block' : 'none';
  }

  btnEditarLogin.addEventListener("click", () => {
    const novoEmail = prompt("Digite seu novo email:", usuario.email);
    if (novoEmail && novoEmail !== usuario.email) {
      usuario.email = novoEmail;
      localStorage.setItem("usuario", JSON.stringify(usuario));
      exibirInformacoesCliente();
    }
  });

  btnEditarDadosAdicionais.addEventListener("click", () => {
    enderecoInput.value = usuario.endereco || "";
    cpfInput.value = usuario.cpf || "";
    formDadosAdicionais.style.display = 'block';
  });

  formDadosAdicionais.addEventListener("submit", (e) => {
    e.preventDefault();
    usuario.endereco = enderecoInput.value;
    usuario.cpf = cpfInput.value;
    localStorage.setItem("usuario", JSON.stringify(usuario));
    formDadosAdicionais.style.display = 'none';
    exibirInformacoesCliente();
  });

  function exibirHistoricoCompras() {
    historicoComprasElement.innerHTML = '';

    if (historicoCompras.length === 0) {
      historicoComprasElement.innerHTML = '<li>Nenhuma compra realizada.</li>';
    } else {
      historicoCompras.forEach(compra => {
        let total = 0;

        compra.itens.forEach(item => {
          const preco = parseFloat(item.preco);
          const qtd = parseInt(item.quantidade);

          if (!isNaN(preco) && !isNaN(qtd)) {
            total += preco * qtd;
          }
        });

        const li = document.createElement('li');
        li.innerHTML = `<span>Compra: ${compra.data} | Total: R$ ${total.toFixed(2)}</span>`;
        historicoComprasElement.appendChild(li);
      });
    }
  }

  btnSair?.addEventListener("click", () => {
    localStorage.removeItem("usuario");
    localStorage.removeItem("historicoCompras");
    location.href = "../web/login.html";
  });

  exibirInformacoesCliente();
  exibirHistoricoCompras();
});