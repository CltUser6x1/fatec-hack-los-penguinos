// Busca no mural: esconde os avisos que não combinam com o termo digitado.
const buscaMural = document.getElementById('busca-mural');
const recados = document.querySelectorAll('[data-recado]');
const muralSemResultado = document.getElementById('mural-sem-resultado');

const semAcento = (texto) =>
    texto.toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, '');

buscaMural?.addEventListener('input', () => {
    const termo = semAcento(buscaMural.value.trim());
    let visiveis = 0;

    recados.forEach((recado) => {
        const combina = !termo || semAcento(recado.textContent).includes(termo);
        recado.hidden = !combina;
        if (combina) visiveis++;
    });

    muralSemResultado.hidden = visiveis > 0 || recados.length === 0;
});
