document.addEventListener("DOMContentLoaded", () => {
  const botoes = document.querySelectorAll(".acordeao-btn");

  botoes.forEach(btn => {
    btn.addEventListener("click", () => {
      const conteudo = btn.nextElementSibling;

      if (conteudo.style.maxHeight) {
        conteudo.style.maxHeight = null;
      } else {
        document.querySelectorAll(".acordeao-conteudo").forEach(c => c.style.maxHeight = null);
        conteudo.style.maxHeight = conteudo.scrollHeight + "px";
      }
    });
  });
});
