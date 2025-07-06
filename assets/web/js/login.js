document.querySelector('#formLogin').addEventListener('submit', function (e) {
  e.preventDefault();

  const email = document.querySelector('#email').value;
  const senha = document.querySelector('#password').value;
  const tipo = document.querySelector("#tipo").value; 
  const resp = document.querySelector("#resp");

  if (!email || !senha || !tipo) {
    resp.textContent = "Preencha todos os campos!";
    return;
  }

  if (email === "admin@gmail.com" && senha === "123456" && tipo === "administrador") {
    localStorage.setItem("usuario", JSON.stringify({
      email: "admin@gmail.com",
      tipo: "administrador"
    }));
    window.location.href = "http://localhost/trabalhopwii/admin/painel-admin";
    return;
  }

  const usuarios = JSON.parse(localStorage.getItem('usuarios')) || [];
  const feirantes = JSON.parse(localStorage.getItem('feirantes')) || [];

  let usuarioLogado = null;
  if (tipo === "cliente") {
    usuarioLogado = usuarios.find(user => user.email === email && user.senha === senha && user.tipo === tipo);
  } else if (tipo === "feirante") {
    usuarioLogado = feirantes.find(user => user.email === email && user.senha === senha && user.tipo === tipo);
  }

  if (usuarioLogado) {
    localStorage.setItem("usuario", JSON.stringify(usuarioLogado));
    if (tipo === "cliente") {
      window.location.href = "http://localhost/trabalhopwii/app/painel-cliente";
    } else if (tipo === "feirante") {
      window.location.href = "http://localhost/trabalhopwii/app/painel-feirante";
    }
  } else {
    resp.textContent = "Email ou senha incorretos!";
  }
});
