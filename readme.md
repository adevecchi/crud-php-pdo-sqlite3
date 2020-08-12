# Requisitos
- PHP >= 7.2.12
- PHP PDO SQlite3
- Composer

# Sistemas operacionais testados
- Windows 10 com PHP v7.212
- Linux Ubuntu 18.04 com PHP v7.4.8

# Instruções
Clonar o repositório e instalar as dependências com composer:

```bash
$ https://github.com/adevecchi/sistema-gerenciamento-produtos.git

$ cd sistema-gerenciamento-produtos/

$ composer install
Loading composer repositories with package information
Updating dependencies (including require-dev)
Package operations: 7 installs, 0 updates, 0 removals
  - Installing steampixel/simple-php-router (0.4.1): Loading from cache
  - Installing psr/log (1.1.3): Loading from cache
  - Installing monolog/monolog (2.1.1): Loading from cache
  - Installing symfony/polyfill-php80 (v1.18.1): Loading from cache
  - Installing symfony/polyfill-mbstring (v1.18.1): Loading from cache
  - Installing symfony/deprecation-contracts (v2.1.3): Loading from cache
  - Installing symfony/http-foundation (v5.1.3): Loading from cache
```

Depois de clonar o repositório e instalar as dependências com composer, executar o servidor embutido do PHP:

```bash
$ php -S localhost:8080 -t public
PHP 7.2.12 Development Server started at Thu Jul 30 21:54:41 2020
Listening on http://localhost:8080
```

Após executar os comando acima é só digitar **localhost:8080** na barra de endereço do navegador para testar.

# Descrição
- **Bando de dados SQLite3**: Se encontra no diretório app/data/dbsqlite.db com alguns resgistros cadastrados.

- **Simple PHP Router**: Realiza o roteamento da URL.

- **Symfony HttpFoundation Component**: Define uma camada orientada a objetos para a especificação HTTP.

- **Monolog**: Registra as ações realizadas, o diretório com os logs se encontra em app/logs/

- **Front-End**: Utilizado o jQuery, jQuery Mask e AlertifyJs.

# Captura de tela
![Tela Dashboard](https://github.com/adevecchi/crud-php-pdo-sqlite3/blob/master/public/assets/images/screenshot/dashboard.png)

![Tela Product](https://github.com/adevecchi/crud-php-pdo-sqlite3/blob/master/public/assets/images/screenshot/product.png)

![Tela Edit Product](https://github.com/adevecchi/crud-php-pdo-sqlite3/blob/master/public/assets/images/screenshot/product-edit.png)

![Tela Delete Product](https://github.com/adevecchi/crud-php-pdo-sqlite3/blob/master/public/assets/images/screenshot/product-delete.png)

![Tela Category](https://github.com/adevecchi/crud-php-pdo-sqlite3/blob/master/public/assets/images/screenshot/category.png)

![Tela Add Category](https://github.com/adevecchi/crud-php-pdo-sqlite3/blob/master/public/assets/images/screenshot/category-add.png)
