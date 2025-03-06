<h1 align="center">
    <br>
    <img src="img/logo.png" width="10%">
    <br>
    OrderApp
    <br>
</h1>

<h4 align="center">
    Aplicação Web desenvolvida para descomplicar o gerenciamento de encomendas para confeiteras autônomas.
</h4>

<p align="center">
  <img src="img/img00.png">
  <br>
  <img src="img/img02.png">
</p>

<h3>Descrição</h3>

<p>
<b>OrderApp</b> é uma aplicação web projetada para permitir que confeteiras autônomas gerenciam suas encomendas de maneira simples e eficiente.

A aplicação permite que os usuários <b>Cadastrem</b> e <b>Acompanhem</b> seus pedidos, além de organizar informações sobre clientes e produtos.

Funcionalidades principais:
  - <b>Cadastro e Autenticação</b> de usuários;
  - <b>Cadastro e gerenciamento</b> de clientes, incluindo histórico de vendas;
  - <b>Cadastro e gerenciamento</b> de produtos, com detalhes de faturamento;
  - <b>Cadastro de encomendas</b> com informações detalhadas do pedido;
  - <b>Gerenciamento de encomendas</b> com histórico e status.
  - <b>Interface responsiva</b>, adaptada para diferentes dispositivos.
</p>

<h3>Tecnologias</h3>

<p>
O projeto foi desenvolvido seguindo o padrão MVC (Model-View-Controller), utilizando um framework próprio. Esse framework conta com rotas dinâmicas, um sistema de flash messages e suporte a múltiplos usuários, permitindo que cada um gerencie seus dados de forma independente.

Tecnologias e ferramentas utilizadas:
- <b>PHP</b> para a lógica da aplicação;
- <b>Composer</b> para autoload das classes;
- <b>PostgreSQL</b> como banco de dados relacional;
- <b>Bootstrap</b> para componentes e design responsivo;
- <b>JavaScript</b> para AJAX e funcionalidades dinâmicas;
- <b>Apache</b> como servidor web.
</p>

<h3>Instalação e Configuração</h3>

<p>
Para executar a aplicação localmente, siga os passos abaixo:

1. Iniciar o servidor <b>Apache</b> e o <b>PostgreSQL</b>.
2. Clone o repositório dentro da pasta do <b>Apache</b>.
3. Configure o arquivo `config.php` com suas credenciais de banco de dados e edite o `BASE_URL` conforme a necessidade.
4. Ative o módulo ModRewrite no Apache: no terminal digite o comando `a2enmod rewrite` ou habilite nas configurações do <b>Apache</b>.
5. Execute as instruções SQL do arquivo `database.sql`.
6. Execute o comando `composer install`.
</p>