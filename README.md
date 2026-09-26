# Los Penguinos · FAQ e Mural da Fatec Itaquera

> Como a tecnologia pode melhorar a comunicação do estudante dentro da Fatec Itaquera.

Projeto desenvolvido no **1º Hackathon Fatec Itaquera**. É um site em Laravel que reúne, em uma página só:

- um **FAQ** com as dúvidas mais comuns sobre a Fatec, organizado em listas suspensas, com links para vídeos no YouTube;
- um **mural de avisos** dividido em setores, onde alunos e professores com conta publicam informações com texto, imagem e vídeo;
- uma **área de administração** para editar o FAQ direto pelo site.


---

## Sumário

- [Equipe](#equipe)
- [Funcionalidades](#funcionalidades)
- [Tecnologias](#tecnologias)
- [Como rodar o projeto](#como-rodar-o-projeto)
- [Como usar](#como-usar)
- [Estrutura do projeto](#estrutura-do-projeto)
- [Banco de dados](#banco-de-dados)
- [Rotas](#rotas)
- [Testes](#testes)
- [Problemas comuns](#problemas-comuns)
- [Fluxo de trabalho no Git](#fluxo-de-trabalho-no-git)
- [Licença](#licença)

---

## Equipe

| Nome | Função |
| --- | --- |
| Lucas Lemos Veneziani | Desenvolvimento full stack |
| Reinaldo Santana | Apresentação |
| Erick Ferreira | Criação e alterações no Git |
| Breno Rodrigues | Issues do repositório |

---

## Funcionalidades

### FAQ (perguntas frequentes)

- Assuntos em **listas suspensas** (ex.: "Sobre a Fatec", "Vestibular", "Cursos", "Vida acadêmica"). Cada assunto abre e mostra suas perguntas; cada pergunta abre e mostra a resposta.
- Cada pergunta pode ter um **botão para vídeos no YouTube** sobre o tema.
- **Busca** no topo que filtra as perguntas enquanto você digita, sem diferenciar acentos (buscar "inscricoes" encontra "inscrições").
- Funciona sem JavaScript: as listas usam `<details>`/`<summary>` do HTML. O JavaScript só é usado na busca.

### Contas de usuário

- Telas de **Cadastro** (`/cadastro`) e **Login** (`/login`), com opção "Manter conectado".
- Senha com no mínimo 8 caracteres, guardada criptografada.
- Mensagens de erro em português.


### Mural de avisos

Fica abaixo do FAQ, na mesma página.

- **Qualquer pessoa pode ler**; só quem está logado pode publicar.
- **Setores**: os avisos são separados em Notícias Principais, Cursos, Eventos e Estágios e Vagas. Ao publicar, a pessoa escolhe o setor.
- Cada aviso tem **título**, **texto de até 10.000 caracteres**, **imagem opcional** (jpg, png, webp ou gif, até 4 MB) e **link opcional de vídeo do YouTube**.
- **Todos os cards têm o mesmo tamanho**: o título é cortado em 2 linhas e o texto em 8 (ou 3, quando há imagem), com "…".
- **Ao clicar em um aviso**, ele abre em um card no meio da tela com o texto completo, a imagem inteira e o vídeo tocável. Fecha clicando fora, no × ou com Esc (o vídeo para ao fechar).
- **Busca própria do mural**, que procura no título, no texto inteiro e no nome do autor. Setores sem resultado somem durante a busca.
- Só o **autor** vê o botão "Excluir" no próprio aviso. A imagem é apagada junto.



### Editar o FAQ (administradores)

- Página **Editar FAQ** (`/admin/faq`), com link no topo para quem é administrador.
- Criar, renomear, reordenar e excluir **seções** (excluir uma seção remove as perguntas dela).
- Criar, editar e excluir **perguntas**: seção, pergunta, resposta, link do vídeo, texto do botão e ordem.
- Toda exclusão pede confirmação.
- Quem não é administrador recebe "acesso negado" (erro 403). Não é possível virar administrador pelo cadastro.


---

## Tecnologias

| Camada | Tecnologia |
| --- | --- |
| Linguagem | PHP 8.2 ou superior |
| Framework | Laravel 12 |
| Banco de dados | MySQL / MariaDB (XAMPP + phpMyAdmin) |
| Front-end | Blade, HTML, CSS e JavaScript puros (sem etapa de build, sem npm) |
| Testes | PHPUnit (banco SQLite em memória) |

O projeto usa Laravel 12 porque o XAMPP vem com PHP 8.2, e o Laravel 13 exige PHP 8.3 ou mais novo.

---

## Como rodar o projeto

### Pré-requisitos

- [XAMPP](https://www.apachefriends.org/) com PHP 8.2 ou superior (confira com `php -v`)
- [Composer](https://getcomposer.org/)
- Git

### Passo a passo

1. **Clone o repositório**

   ```bash
   git clone https://github.com/CltUser6x1/fatec-hack-los-penguinos.git
   cd fatec-hack-los-penguinos
   ```

2. **Inicie o banco**: no painel do XAMPP, clique em **Start** no **Apache** e no **MySQL**.

3. **Crie o banco de dados**: abra http://localhost/phpmyadmin, clique em **Novo**, digite o nome `faq_fatec`, escolha o agrupamento `utf8mb4_unicode_ci` e clique em **Criar**.

4. **Instale as dependências**

   ```bash
   composer install
   ```

5. **Crie o arquivo de configuração**

   ```bash
   cp .env.example .env          # no PowerShell: copy .env.example .env
   php artisan key:generate
   ```

   Abra o `.env` e confira o bloco do banco. Ele já vem com o padrão do XAMPP:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=faq_fatec
   DB_USERNAME=root
   DB_PASSWORD=
   ```

   Se o seu MySQL usa outra porta (o phpMyAdmin mostra no topo, por exemplo `Servidor: 127.0.0.1:3309`), outro nome de banco ou tem senha, ajuste essas linhas.

6. **Crie as tabelas e o conteúdo inicial**

   ```bash
   php artisan migrate --seed
   ```

   Isso cria as tabelas e preenche o FAQ com as perguntas iniciais e os setores do mural. Pode rodar de novo sem duplicar nada.

7. **Suba o servidor**

   ```bash
   php artisan serve
   ```

   Acesse **http://127.0.0.1:8000**.

8. **(Opcional) Crie um administrador**: cadastre uma conta pelo site e rode:

   ```bash
   php artisan faq:admin seu@email.com
   ```

> O arquivo `.env` **não vai para o GitHub** (está no `.gitignore`). Cada pessoa da equipe cria o seu a partir do `.env.example`.

---

## Como usar

| Quero... | Como fazer |
| --- | --- |
| Ler o FAQ | Abra a página inicial e clique em um assunto e depois em uma pergunta. |
| Buscar no FAQ | Digite na caixa "Buscar no FAQ", na barra vermelha. |
| Criar conta | Clique em **Cadastrar** no topo. |
| Publicar no mural | Entre na conta, desça até "Mural de avisos", escolha o setor, preencha e clique em **Publicar no mural**. |
| Ver um aviso inteiro | Clique no aviso. Para fechar, clique fora, no × ou aperte Esc. |
| Apagar meu aviso | Clique em **Excluir** no próprio aviso. |
| Editar o FAQ | Com uma conta de administrador, clique em **Editar FAQ** no topo. |
| Dar ou tirar permissão de admin | `php artisan faq:admin email@da.pessoa` (use `--remover` para tirar). |
| Mudar os setores do mural | Edite a lista em `database/seeders/SetorSeeder.php` e rode `php artisan db:seed --class=SetorSeeder`, ou altere a tabela `setores` no phpMyAdmin. |

---

## Estrutura do projeto

Arquivos principais (o resto é a estrutura padrão do Laravel):

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── FaqController.php            # página inicial (FAQ + mural)
│   │   ├── AuthController.php           # login, cadastro e logout
│   │   ├── MuralController.php          # publicar, excluir e servir imagens dos avisos
│   │   └── Admin/FaqAdminController.php # editar seções e perguntas do FAQ
│   └── Middleware/SomenteAdmin.php      # bloqueia quem não é administrador
└── Models/
    ├── Secao.php     # assunto do FAQ
    ├── Pergunta.php  # pergunta do FAQ
    ├── Setor.php     # setor do mural
    ├── Aviso.php     # aviso do mural (inclui a leitura de links do YouTube)
    └── User.php

database/
├── migrations/       # criação das tabelas
└── seeders/
    ├── FaqSeeder.php    # perguntas iniciais do FAQ
    └── SetorSeeder.php  # setores do mural

resources/views/
├── layouts/app.blade.php   # topo, menu e rodapé
├── faq.blade.php           # página inicial
├── mural/_recado.blade.php # card de um aviso
├── auth/                   # login e cadastro
└── admin/faq/              # páginas de edição do FAQ

public/
├── css/faq.css   # todo o visual
└── js/
    ├── faq.js    # busca do FAQ
    └── mural.js  # busca do mural e card no meio da tela

lang/pt_BR/validation.php   # mensagens de erro em português
routes/web.php              # rotas do site
routes/console.php          # comando faq:admin
tests/Feature/              # testes automatizados
```

---

## Banco de dados

| Tabela | Para que serve | Campos principais |
| --- | --- | --- |
| `secoes` | Assuntos do FAQ | `titulo`, `ordem` |
| `perguntas` | Perguntas do FAQ | `secao_id`, `pergunta`, `resposta`, `video_titulo`, `video_url`, `ordem` |
| `setores` | Setores do mural | `nome`, `slug`, `ordem` |
| `avisos` | Avisos do mural | `user_id`, `setor_id`, `titulo`, `conteudo`, `imagem`, `video_url` |
| `users` | Contas | `name`, `email`, `password`, `is_admin` |

Relações:

- Uma **seção** tem várias **perguntas**. Apagar a seção apaga as perguntas.
- Um **setor** tem vários **avisos**. Se um setor for apagado, seus avisos vão para "Outros avisos".
- Um **usuário** tem vários **avisos**. Apagar o usuário apaga os avisos dele.

As imagens dos avisos ficam em `storage/app/public/avisos` e são entregues pela rota `/mural/{id}/imagem`, então **não é preciso rodar `php artisan storage:link`**.

---

## Rotas

| Método | Endereço | O que faz | Quem pode |
| --- | --- | --- | --- |
| GET | `/` | FAQ e mural | Todos |
| GET | `/mural/{aviso}/imagem` | Imagem de um aviso | Todos |
| GET/POST | `/login` | Entrar | Visitantes |
| GET/POST | `/cadastro` | Criar conta | Visitantes |
| POST | `/logout` | Sair | Logados |
| POST | `/mural` | Publicar aviso | Logados |
| DELETE | `/mural/{aviso}` | Excluir aviso | Autor do aviso |
| GET | `/admin/faq` | Painel de edição do FAQ | Administradores |
| POST/PUT/DELETE | `/admin/faq/secoes/...` | Criar, editar e excluir seções | Administradores |
| GET/POST/PUT/DELETE | `/admin/faq/perguntas/...` | Criar, editar e excluir perguntas | Administradores |

Para ver a lista completa: `php artisan route:list`.

---

## Testes

```bash
php artisan test
```

São 34 testes, que usam um banco SQLite em memória (não mexem no seu MySQL). Eles cobrem:

- a página do FAQ e o seeder sem duplicação;
- cadastro, login com senha certa e errada, e logout;
- publicar e excluir avisos, e só o autor poder excluir;
- limite de 10.000 caracteres no aviso;
- upload de imagem (e recusa de arquivos que não são imagem);
- links do YouTube virando vídeo (e recusa de outros sites);
- setores do mural;
- edição do FAQ só por administradores e o comando `faq:admin`.

---

## Problemas comuns

| Erro | Causa e solução |
| --- | --- |
| `vendor/autoload.php: Failed to open stream` | Falta instalar as dependências. Rode `composer install`. |
| `Your PHP version does not satisfy that requirement` | O PHP é mais velho que 8.2. Atualize o XAMPP. |
| `could not find driver` | A extensão do MySQL está desligada. No `php.ini` do XAMPP, tire o `;` de `extension=pdo_mysql` e reinicie o terminal. |
| `Access denied for user 'root'` | Senha do MySQL diferente. Ajuste `DB_PASSWORD` no `.env`. |
| `Connection refused` ou tabelas não aparecem no phpMyAdmin | O Laravel está apontando para outro servidor. Confira `DB_PORT` e `DB_DATABASE` no `.env` com o que aparece no topo do phpMyAdmin e rode `php artisan config:clear`. |
| Perguntas do FAQ repetidas | Versão antiga do seeder. Rode `php artisan migrate:fresh --seed` (apaga e recria as tabelas). |
| Mudei o `.env` e nada mudou | Rode `php artisan config:clear`. |

---

## Fluxo de trabalho no Git

Seguindo as regras do hackathon:

- **Nunca** fazer commit direto na `main`. Cada mudança vai em um branch novo a partir da `main`:
  - `feature/...` para funcionalidades novas
  - `fix/...` para correções
  - `chore/...` para configuração e manutenção
  - `docs/...` para documentação
- Commits pequenos, em português e no imperativo, no formato `tipo: descrição`. Exemplo: `feat: adicionar busca no mural de avisos`.
- Cada branch vira um **Pull Request** com as seções:

  ```markdown
  ## O que esta PR faz?
  ## Issue relacionada
  ## Como testar?
  ```

- Pelo menos uma pessoa da equipe revisa antes do merge. Depois do merge, o branch é apagado.

---

## Licença

Distribuído sob a licença MIT. Veja o arquivo [LICENSE](LICENSE).
