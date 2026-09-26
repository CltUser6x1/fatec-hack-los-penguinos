# Los-Penguinos
Como a tecnologia pode melhorar a comunicação do estudante dentro da Fatec Itaquera

## FAQ da Fatec

Página de perguntas frequentes em listas suspensas: cada assunto (ex.: "Sobre a Fatec") abre e mostra as perguntas, as respostas e links para vídeos no YouTube. Há também uma busca que filtra as perguntas enquanto você digita.

### Stack

- PHP 8.3+ e Laravel
- SQLite (banco padrão)
- HTML, CSS e JavaScript puros (sem etapa de build)

### Como rodar

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
php artisan serve
```

Acesse http://127.0.0.1:8000.

As perguntas ficam em `database/seeders/FaqSeeder.php`. Para rodar os testes: `php artisan test`.
