document.addEventListener("DOMContentLoaded", () => {

  let usuarios = JSON.parse(localStorage.getItem('usuarios') || '[]');
  let feirantes = JSON.parse(localStorage.getItem('feirantes') || '[]');
  let feiras = JSON.parse(localStorage.getItem('feiras') || '[]');

  const listaUsuarios = document.querySelector('#listaUsuarios');
  const listaFeirantes = document.querySelector('#listaFeirantes');
  const listaFeiras = document.querySelector('#listaFeiras');

  function salvarDados() {
    localStorage.setItem('usuarios', JSON.stringify(usuarios));
    localStorage.setItem('feirantes', JSON.stringify(feirantes));
    localStorage.setItem('feiras', JSON.stringify(feiras));
  }

  function renderLista(lista, dados, editarFunc, deletarFunc) {
    lista.innerHTML = '';
    dados.forEach((item, index) => {
      const li = document.createElement('li');
      li.textContent = Object.values(item).join(" | ");

      const btnEditar = document.createElement('button');
      btnEditar.textContent = 'Editar';
      btnEditar.classList.add('editar');
      btnEditar.onclick = () => editarFunc(index);

      const btnDeletar = document.createElement('button');
      btnDeletar.textContent = 'Deletar';
      btnDeletar.classList.add('deletar');
      btnDeletar.onclick = () => deletarFunc(index);

      li.appendChild(btnEditar);
      li.appendChild(btnDeletar);

      lista.appendChild(li);
    });
  }

  function editarUsuario(index) {
    const nome = prompt('Novo nome:', usuarios[index].nome);
    const email = prompt('Novo email:', usuarios[index].email);
    if (nome && email) {
      usuarios[index] = { nome, email, tipo: 'cliente' };
      salvarDados();
      renderUsuarios();
    }
  }

  function editarFeirante(index) {
    const nome = prompt('Novo nome:', feirantes[index].nome);
    const email = prompt('Novo email:', feirantes[index].email);
    if (nome && email) {
      feirantes[index] = { nome, email, tipo: 'feirante' };
      salvarDados();
      renderFeirantes();
    }
  }

  function editarFeira(index) {
    const nome = prompt('Nome da Feira:', feiras[index].nome);
    const endereco = prompt('Endereço da Feira:', feiras[index].endereco);
    const data = prompt('Data da Feira:', feiras[index].data);

    if (nome && endereco && data) {
      feiras[index] = { ...feiras[index], nome, endereco, data };
      salvarDados();
      renderFeiras();
    }
  }

  function deletarUsuario(index) {
    if (confirm("Excluir usuário?")) {
      usuarios.splice(index, 1);
      salvarDados();
      renderUsuarios();
    }
  }

  function deletarFeirante(index) {
    if (confirm("Excluir feirante?")) {
      feirantes.splice(index, 1);
      salvarDados();
      renderFeirantes();
    }
  }

  function deletarFeira(index) {
    if (confirm("Excluir feira?")) {
      feiras.splice(index, 1);
      salvarDados();
      renderFeiras();
    }
  }

  document.querySelector("#btnAddUsuario").onclick = () => {
    const nome = prompt("Nome:");
    const email = prompt("Email:");

    if (nome && email) {
      usuarios.push({ nome, email, tipo: 'cliente' });
      salvarDados();
      renderUsuarios();
    }
  };

  document.querySelector("#btnAddFeirante").onclick = () => {
    const nome = prompt("Nome:");
    const email = prompt("Email:");

    if (nome && email) {
      feirantes.push({ nome, email, tipo: 'feirante' });
      salvarDados();
      renderFeirantes();
    }
  };

  document.querySelector("#btnAddFeira").onclick = () => {
    const nome = prompt("Nome da Feira:");
    const endereco = prompt("Endereço:");
    const data = prompt("Data (ex: 25/12/2025):");
    
    if (nome && endereco && data) {
      feiras.push({ id: Date.now(), nome, endereco, data, produtos: [] });
      salvarDados();
      renderFeiras();
    }
  };

  function renderUsuarios() {
    renderLista(listaUsuarios, usuarios, editarUsuario, deletarUsuario);
  }

  function renderFeirantes() {
    renderLista(listaFeirantes, feirantes, editarFeirante, deletarFeirante);
  }

  function renderFeiras() {
    renderLista(listaFeiras, feiras, editarFeira, deletarFeira);
  }

  renderUsuarios();
  renderFeirantes();
  renderFeiras();
});
