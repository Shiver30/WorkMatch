# WorkMatch

### Plataforma de conexão entre prestadores de serviços e clientes

O **WorkMatch** é um projeto acadêmico desenvolvido em equipe, com o objetivo de conectar pessoas que oferecem serviços a pessoas que procuram profissionais.

A plataforma permite que usuários cadastrem seus serviços, encontrem prestadores de acordo com suas necessidades e localização, avaliem experiências e estabeleçam contato por meio de um sistema de mensagens.

O projeto foi desenvolvido como parte da formação técnica em Informática para Internet, envolvendo conceitos de desenvolvimento web, programação back-end, integração com banco de dados e trabalho colaborativo.

---

## Funcionalidades

- **Cadastro de usuários:** criação de contas com informações pessoais e endereço.
- **Autenticação:** acesso à plataforma por meio de login.
- **Cadastro de serviços:** publicação de serviços oferecidos pelos usuários.
- **Pesquisa de serviços:** busca de profissionais e serviços por categoria e localização.
- **Perfis de usuários:** visualização de informações e serviços cadastrados.
- **Sistema de avaliações:** avaliação de usuários por meio de notas e comentários.
- **Sistema de conversas:** comunicação privada entre usuários.
- **Mensagens dinâmicas:** atualização de mensagens sem necessidade de recarregar toda a página.
- **Fotos de perfil:** possibilidade de adicionar imagens aos perfis.

---

## Tecnologias utilizadas

### Front-end
- HTML5
- CSS3
- JavaScript
- Bootstrap

### Back-end
- PHP 8.2

### Banco de dados
- MySQL 8.0
- MySQL Workbench
- SQL

### Ambiente de desenvolvimento
- Docker
- Docker Compose
- Apache

---

## Estrutura do projeto

```text
WorkMatch/
│
├── banco/
│   ├── banco.mwb
│   ├── banco.sql
│   └── banco2.0.png
│
├── html/
│   ├── cadastro/
│   ├── chat/
│   ├── css/
│   ├── fotos/
│   ├── funcoes/
│   ├── home/
│   ├── include/
│   ├── conexao.php
│   ├── index.php
│   ├── login.php
│   └── logout.php
│
├── Dockerfile
├── docker-compose.yml
└── README.md
```

---

## Como executar o projeto

### Pré-requisitos

- Docker Desktop instalado.
- Docker Compose disponível.

### 1. Clonar o repositório

```bash
git clone https://github.com/Shiver30/WorkMatch.git
```

### 2. Entrar na pasta do projeto

```bash
cd WorkMatch
```

### 3. Iniciar os containers

```bash
docker compose up -d --build
```

O Docker Compose ficará responsável por iniciar o ambiente PHP com Apache e o banco de dados MySQL.

O script SQL localizado na pasta `banco/` é utilizado na inicialização do banco de dados pelo container MySQL.

### 4. Acessar a aplicação

Com os containers em execução, acesse:

```text
http://localhost:81
```

### 5. Acessar o banco de dados

O MySQL fica disponível na porta `3307` da máquina local.

As configurações de conexão estão definidas nos arquivos `docker-compose.yml` e `html/conexao.php`.

**Observação:** as credenciais presentes na versão acadêmica são configurações locais de desenvolvimento. Antes de compartilhar ou publicar o projeto, substitua as credenciais de teste e evite armazenar senhas diretamente no repositório.

---

## Banco de dados

O projeto utiliza um banco de dados relacional MySQL para armazenar informações sobre usuários, serviços, avaliações, endereços e conversas.

O modelo foi desenvolvido utilizando o MySQL Workbench.

O diagrama e o script SQL estão disponíveis na pasta `banco/`.

---

## Desenvolvimento em equipe

O WorkMatch foi desenvolvido colaborativamente por uma equipe de quatro integrantes.

A distribuição aproximada de participação no desenvolvimento foi:

- **Fernando Ramos Silva Reis (@Shiver30):** 40%.
- **Taynan Rodrigues Pereira(@Taynan19):** 40%.
- **Arthur Correia Barros (@ArtCdev):** 10%.
- **Jaqueline Pereira de Lima (@jac654):** 10%.

O desenvolvimento envolveu colaboração na implementação das funcionalidades, organização do sistema e integração com o banco de dados.

---

## Status do projeto

Projeto acadêmico desenvolvido durante a formação técnica em Informática para Internet.

O repositório representa o desenvolvimento realizado pela equipe e tem finalidade educacional e de portfólio. Não representa uma plataforma comercial em operação.

---

## Autores e colaboradores

Projeto desenvolvido em equipe como parte da formação técnica em Informática para Internet.

| Colaborador | GitHub |
|---|---|
| Fernando Ramos Silva Reis | [@Shiver30](https://github.com/Shiver30) |
| Taynan Rodrigues Pereira | [@Taynan19](https://github.com/Taynan19) |
| Arthur Correia Barros| [@ArtCdev](https://github.com/ArtCdev) |
| Jaqueline Pereira de Lima | [@jac654](https://github.com/jac654) |
---

---

*Projeto desenvolvido para fins acadêmicos e de aprendizado em desenvolvimento web.*
