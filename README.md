Desafio Capgemini 
----
Teste Técnico PHP B1

-------------
OBJETIVO DO DESAFIO

O Banco Capgemini necessita criar uma Web API Rest para expor os seguintes serviços para
seus clientes:
1) Serviço para verificar o saldo de uma conta corrente;
2) Serviço para realizar um depósito em uma determinada contacorrente;
3) Serviço para realizar um saque de uma determinada contacorrente.
-------------
TECNOLOGIAS
---
Foram utilizadas as seguintes tecnologias:
- PHP 7.2
- Laravel 7.24
- Vue 2.5
- Banco de Dados SQLite
-------------
PASSO A PASSO DE INSTALAÇÃO
----

Clone este Repositório:

```
git clone https://github.com/airtonfranca/capgemini-desafio.git
```

Entre no Diretório do Repositório:

```
cd capgemini-desafio
```   

Instale as Dependências (Projeto Laravel):

```
composer install
```

Copie o arquivo .env:

```
cp .env.example .env
```

Crie o Banco de Dados vazio:

O banco SQLite deve estar no local: `database/database.sqlite`
```
touch database/database.sqlite
```

Gere a Chave da Aplicação

```
php artisan key:generate
```

Migrations
```
php artisan migrate
```

Instale as Dependências do Node (Projeto Vue):
```
npm install
```
```
npm run prod
```

Execute servidor:

````
php artisan serve
````
