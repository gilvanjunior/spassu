## Sistema de Gerenciamento de biblioteca

Este projeto é um teste prático exigido pela empresa Spassu que consiste na criação de um CRUD para cadastro de livros.

Para este objetivo foi utilizada a seguinte stack:

- Docker
- php 8.3
- Postgresql
- Redis
- Laravel 11
- AdminLTE
- Boostrap
- Jquery
- PHPUnit
- nginx
- Mnonolog
- Pulse

## Configuração do ambiente

clonar o repositório

#### https://github.com/gilvanjunior/biblioteca-spassu.git

Acessar o diretório biblioteca-spassu

#### cd biblioteca-spassu

Subir os containers a partir da pasta raiz do projeto. Para isto, rode o comando:

#### docker compose up -d --buld

## Criação de usuário

#### http://localhost

Para acessar a aplicação é necessário registrar um novo membro clicando em "Registrar um novo membro".
Após isto, use as credenciais que foram criadas para fazer o login

## Observabilidade

    Pulse delivers at-a-glance insights into your application’s performance and usage. Track down bottlenecks like slow jobs and endpoints, find your most active users, and more.

    From pulse.laravel.com

Para acessar o pulse 

#### http://localhost/pulse

