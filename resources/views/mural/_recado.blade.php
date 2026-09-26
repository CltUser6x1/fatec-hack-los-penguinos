<article @class(['recado', 'recado-com-imagem' => $aviso->imagem]) data-recado
    data-busca="{{ $aviso->titulo }} {{ $aviso->conteudo }} {{ $aviso->autor->name }}"
    tabindex="0" role="button" aria-haspopup="dialog"
    aria-label="Abrir aviso: {{ $aviso->titulo }}">
    @if ($aviso->imagem)
        <img src="{{ $aviso->imagemUrl() }}" alt="" class="recado-imagem" loading="lazy">
    @endif
    <h3>{{ $aviso->titulo }}</h3>
    <p class="recado-resumo">{{ Str::limit($aviso->conteudo, 600) }}</p>
    @if ($aviso->videoEmbedUrl())
        <span class="recado-selo">▶ Tem vídeo</span>
    @endif
    <footer>
        <span>{{ $aviso->autor->name }} · {{ $aviso->created_at->format('d/m/Y H:i') }}</span>
        @if (auth()->id() === $aviso->user_id)
            <form method="POST" action="{{ route('mural.destroy', $aviso) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="link-botao">Excluir</button>
            </form>
        @endif
    </footer>

    <template data-detalhe>
        @if ($aviso->imagem)
            <img src="{{ $aviso->imagemUrl() }}" alt="Imagem do aviso {{ $aviso->titulo }}" class="modal-imagem">
        @endif
        <h3 id="modal-titulo">{{ $aviso->titulo }}</h3>
        <p class="modal-texto">{{ $aviso->conteudo }}</p>
        @if ($aviso->videoEmbedUrl())
            <div class="recado-video">
                <iframe src="{{ $aviso->videoEmbedUrl() }}" title="Vídeo: {{ $aviso->titulo }}"
                    allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        @endif
        <p class="modal-autor">{{ $aviso->autor->name }} · {{ $aviso->created_at->format('d/m/Y H:i') }}</p>
    </template>
</article>
