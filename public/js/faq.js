// Filtra as perguntas do FAQ enquanto a pessoa digita na busca.
const campoBusca = document.getElementById('busca');
const secoes = document.querySelectorAll('[data-secao]');
const semResultado = document.getElementById('sem-resultado');

const normalizar = (texto) =>
    texto.toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, '');

campoBusca.addEventListener('input', () => {
    const termo = normalizar(campoBusca.value.trim());
    let encontrou = false;

    secoes.forEach((secao) => {
        const tituloSecao = normalizar(secao.querySelector('summary').textContent);
        let perguntasVisiveis = 0;

        secao.querySelectorAll('[data-pergunta]').forEach((item) => {
            const visivel = !termo || tituloSecao.includes(termo) || normalizar(item.textContent).includes(termo);
            item.hidden = !visivel;
            if (visivel) perguntasVisiveis++;
        });

        secao.hidden = perguntasVisiveis === 0;
        secao.open = termo !== '' && perguntasVisiveis > 0;
        if (perguntasVisiveis > 0) encontrou = true;
    });

    semResultado.hidden = encontrou;
});
