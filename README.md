# Los-Penguinos
Como a tecnologia pode melhorar a comunicação do estudante dentro da Fatec Itaquera

## FAQ da Fatec

Página de perguntas frequentes em listas suspensas: cada assunto (ex.: "Sobre a Fatec") abre e mostra as perguntas, as respostas e links para vídeos no YouTube. Há também uma busca que filtra as perguntas enquanto você digita.

Abaixo do FAQ fica o **mural de avisos**: qualquer pessoa pode ler, e quem tem conta (telas de **Cadastro** e **Login**) pode publicar informações (com imagem ou vídeo do YouTube, opcionais) e excluir os próprios avisos. O mural tem busca própria.

> `php artisan storage:link` é necessário uma vez para as imagens enviadas aparecerem.

### Stack

- PHP 8.3+ e Laravel
- MySQL/MariaDB (XAMPP + phpMyAdmin)
- HTML, CSS e JavaScript puros (sem etapa de build)

### Como rodar

1. No XAMPP, inicie **Apache** e **MySQL**.
2. Abra http://localhost/phpmyadmin, clique em **Novo** e crie o banco `faq_fatec` com agrupamento `utf8mb4_unicode_ci`.
3. No terminal, dentro da pasta do projeto:

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

O `.env.example` já vem com o usuário padrão do XAMPP (`root`, sem senha). Se o seu MySQL tiver senha, ajuste `DB_PASSWORD` no `.env`.

Acesse http://127.0.0.1:8000.

As perguntas ficam em `database/seeders/FaqSeeder.php`. Para rodar os testes: `php artisan test`.
