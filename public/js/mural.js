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
        const combina = !termo || semAcento(recado.dataset.busca).includes(termo);
        recado.hidden = !combina;
        if (combina) visiveis++;
    });

    // Durante a busca, esconde os setores que ficaram sem nenhum aviso visível.
    document.querySelectorAll('[data-setor]').forEach((setor) => {
        setor.hidden = termo !== '' && !setor.querySelector('[data-recado]:not([hidden])');
    });

    muralSemResultado.hidden = visiveis > 0 || recados.length === 0;
});

// Card no meio da tela: abre ao clicar no aviso e fecha ao clicar fora, no X ou com Esc.
const modal = document.getElementById('recado-modal');
const corpoModal = modal?.querySelector('.modal-corpo');

const abrirRecado = (recado) => {
    corpoModal.replaceChildren(recado.querySelector('[data-detalhe]').content.cloneNode(true));
    modal.showModal();
};

recados.forEach((recado) => {
    recado.addEventListener('click', (evento) => {
        // O botão "Excluir" continua funcionando sem abrir o card.
        if (evento.target.closest('form')) return;
        abrirRecado(recado);
    });

    recado.addEventListener('keydown', (evento) => {
        if (evento.target !== recado) return;
        if (evento.key === 'Enter' || evento.key === ' ') {
            evento.preventDefault();
            abrirRecado(recado);
        }
    });
});

modal?.addEventListener('click', (evento) => {
    // O próprio <dialog> só recebe o clique quando ele acontece no fundo escuro, fora do card.
    if (evento.target === modal) modal.close();
});

modal?.querySelector('.modal-fechar').addEventListener('click', () => modal.close());

// Limpa o conteúdo ao fechar para o vídeo parar de tocar.
modal?.addEventListener('close', () => corpoModal.replaceChildren());
