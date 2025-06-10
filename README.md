# Sistema de Organização de Eventos

Este projeto é uma aplicação web para gerenciamento e participação em eventos. Permite que usuários se cadastrem, organizadores criem eventos, usuários interajam com eventos (curtir, favoritar, se inscrever) e deixem comentários.

---

## 🗂 Estrutura de Pastas

```

/
├── back-end        # Scripts PHP responsáveis pela lógica de negócio e comunicação com o banco
│   └── db          # (Opcional) Pode conter scripts de inicialização ou backups do banco
├── front-end       # Telas de login, cadastro, página inicial e interações visuais
├── uploads         # Imagens enviadas nos eventos

```

---

## ⚙️ Tecnologias

- **PHP 8+**
- **MySQL**
- **HTML/CSS/JavaScript**
- **Servidor local**: Laragon (utilizado no desenvolvimento)

---

## 📋 Funcionalidades

### 👤 Usuário
- Cadastro com nome, email, username e senha segura
- Login com verificação de credenciais
- Comentar em eventos
- Curtir, favoritar e se inscrever em eventos

### 🧑‍💼 Organizador
- Cadastro com dados da organização (nome do responsável, tipo, telefone)
- Criação de eventos com:
  - Nome, descrição, data de início e fim
  - Localização (presencial, online, híbrido)
  - Capacidade e preço
  - Imagem de capa

### 💬 Comentários e Interações
- Curtir, favoritar ou se inscrever em eventos (1 clique ativa, 2º clique remove)
- Adição de comentários por usuários logados

---

## 🗄 Banco de Dados

O banco é composto pelas seguintes tabelas:

- `usuarios`: dados de login
- `organizadores`: dados dos organizadores vinculados a um usuário
- `eventos`: informações completas dos eventos
- `interacoes`: curtir, favoritar, inscrever
- `comentarios`: sistema de comentários nos eventos

Para criar as tabelas, utilize o script disponível em `back-end/conexao.php` com os comandos `CREATE TABLE`.

---

## ▶️ Como executar

1. Clone o repositório
2. Execute o projeto com Laragon ou outro servidor local compatível com PHP/MySQL
3. Importe ou deixe o MySQL criar o banco `banco_eventos`
4. Acesse via navegador:

```

http://localhost/Preparacao-para-ADE/front-end/login.php

```

---

## 🔐 Segurança

- Senhas são armazenadas com `password_hash()`
- Login com `password_verify()`
- Sessões são verificadas em todas as rotas protegidas
- Dados são preparados com `PDO` e bind para evitar SQL Injection

---

## 📁 Uploads

As imagens dos eventos são armazenadas na pasta `/uploads` e referenciadas pela URL acessível em `image_event`.

---

## ✍️ Autor

Desenvolvido por **Luan** como parte de um projeto de preparação para a prova da ADE.

---
