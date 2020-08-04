# Requisitos
- PHP >= 7.2.12
- PHP PDO sqlite3
- Composer

# Sistemas operacionais testados
- Windows 10 com PHP v7.212
- Linux Ubuntu 18.04 com PHP v7.4.8

# Instruções
Clonar o repositório e instalar as dependências com composer:

```bash
$ git clone https://adevecchi@bitbucket.org/adevecchi/assessment-backend-xp.git

$ cd assessment-backend-xp/

$ git checkout desafio
Switched to a new branch 'desafio'
Branch 'desafio' set up to track remote branch 'desafio' from 'origin'.

$ composer install
Loading composer repositories with package information
Updating dependencies (including require-dev)
Package operations: 3 installs, 0 updates, 0 removals
  - Installing steampixel/simple-php-router (0.4.1): Loading from cache
  - Installing psr/log (1.1.3): Loading from cache
  - Installing monolog/monolog (2.1.1): Loading from cache
```

Depois de clonar o repositório e instalar as dependências com composer, executar o servidor embutido do PHP:

```bash
$ php -S localhost:8080 -t public
PHP 7.2.12 Development Server started at Thu Jul 30 21:54:41 2020
Listening on http://localhost:8080
```

Após executar os comando acima é só digitar **localhost:8080** na barra de endereço do navegador para testar.

# Descrição
Foi utilizado o Bando de dados SQLite3. O arquivo dbsqlite.db se encontra no diretório app/data/dbsqlite.db com alguns resgistros para teste.

Foi utilizado o Monolog para registrar as ações realizadas em arquivo de log. O diretório com os log's se encontra em app/logs/

Foi utilizado o Simple PHP Router para tratar as requisições.

Também foi utilizad o jQuery, AlertifyJs e jQuery Mask.