function validarFormulario(nome, email, senha, tipo) {
  if (nome.trim() === "") return "O campo 'Nome' é obrigatório.";
  const regexEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
  if (!regexEmail.test(email)) return "Por favor, insira um email válido.";
  if (senha.trim().length < 6) return "A senha precisa ter pelo menos 6 caracteres.";
  if (!tipo) return "Selecione um tipo de usuário.";
  return null;
}

function exibirMensagemErro(mensagem) {
  const mensagemErro = document.querySelector("#mensagemCadastro");
  mensagemErro.textContent = mensagem;
  mensagemErro.style.color = "red";
  mensagemErro.style.fontWeight = "bold";
}

function armazenarDadosCadastro(nome, email, senha, tipo) {
  const usuario = { nome, email, senha, tipo };
  let usuarios = JSON.parse(localStorage.getItem('usuarios') || '[]');
  let feirantes = JSON.parse(localStorage.getItem('feirantes') || '[]');

  if (tipo === "cliente") {
    usuarios.push(usuario);  
    localStorage.setItem('usuarios', JSON.stringify(usuarios));
  } else if (tipo === "feirante") {
    feirantes.push(usuario);  
    localStorage.setItem('feirantes', JSON.stringify(feirantes));
  }

  localStorage.setItem("usuario", JSON.stringify(usuario));
}


document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector("#formRegister");

  form.addEventListener("submit", function (e) {
    e.preventDefault();

    const nome = document.querySelector("#nome").value;
    const email = document.querySelector("#email").value;
    const senha = document.querySelector("#senha").value;
    const tipo = document.querySelector("#tipo").value;

    document.querySelector("#mensagemCadastro").textContent = "";

    const erro = validarFormulario(nome, email, senha, tipo);
    if (erro) return exibirMensagemErro(erro);

    armazenarDadosCadastro(nome, email, senha, tipo);

    if (tipo === "cliente") {
      window.location.href = "http://localhost/trabalhopwii/app/painel-cliente";
    } else if (tipo === "feirante") {
      window.location.href = "http://localhost/trabalhopwii/app/painel-feirante";
    }
  });
});
