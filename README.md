# 🛠️ API de Catálogo de Produtos (Laravel 10+)

Bem-vindo ao projeto **API de Catálogo de Produtos** desenvolvido em Laravel 10. Esta API permite gerenciar produtos com funcionalidades CRUD, autenticação via Sanctum, paginação, filtros e testes automatizados.

## 📌 Funcionalidades

-   **CRUD completo** para gerenciar produtos (Create, Read, Update, Delete)
-   **Autenticação** com Laravel Sanctum para proteger as rotas
-   **Paginação** dos produtos
-   **Filtro** para buscar produtos pelo nome
-   **Testes Automatizados** para garantir o funcionamento da API

## 📋 Requisitos

Antes de instalar o projeto, certifique-se de ter os seguintes requisitos:

-   **PHP 8+**
-   **Composer** (Gerenciador de dependências PHP)
-   **Laravel 10+**
-   **Banco de dados**: SQLite, MySQL ou PostgreSQL
-   **Postman ou Insomnia** (para testar a API)

---

## 🚀 Passo a Passo para Instalação

### 1️⃣ **Clone o repositório do GitHub**

```bash
  git clone https://github.com/seu-usuario/api-produtos.git
  cd api-produtos
```

### 2️⃣ **Instale as dependências do projeto**

```bash
  composer install
```

### 3️⃣ **Copie o arquivo de variáveis de ambiente e configure**

```bash
  cp .env.example .env
```

Edite o arquivo `.env` e configure o banco de dados conforme sua necessidade:

```env
DB_CONNECTION=mysql  # Ou sqlite, pgsql, sqlsrv
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=produtos
DB_USERNAME=root
DB_PASSWORD=secret
```

### 4️⃣ **Gere a chave da aplicação**

```bash
  php artisan key:generate
```

### 5️⃣ **Execute as migrações do banco de dados**

```bash
  php artisan migrate
```

### 6️⃣ **Inicie o servidor local**

```bash
  php artisan serve
```

A API estará rodando em: [**http://127.0.0.1:8000**](http://127.0.0.1:8000)

---

## 🔐 **Autenticação com Laravel Sanctum**

A API utiliza **Laravel Sanctum** para proteger as rotas. Antes de acessar qualquer rota protegida, é necessário gerar um token de autenticação.

### 🔹 **Criar um usuário para login**

```bash
  php artisan tinker
```

```php
  \App\Models\User::create([
      'name' => 'Usuário Teste',
      'email' => 'teste@email.com',
      'password' => bcrypt('123456')
  ]);
```

### 🔹 **Fazer login e obter token**

```http
POST http://127.0.0.1:8000/api/login
```

**Body (JSON):**

```json
{
    "email": "teste@email.com",
    "password": "123456"
}
```

**Resposta:**

```json
{
    "token": "1|seu-token-aqui"
}
```

### 🔹 **Usar o token para acessar rotas protegidas**

Para acessar qualquer rota protegida, inclua o token no cabeçalho da requisição:

```
Authorization: Bearer seu-token-aqui
```

---

## 📌 **Testando as Rotas da API**

### 🔹 **Listar produtos (com paginação e filtros)**

```http
GET http://127.0.0.1:8000/api/produtos?per_page=5&nome=notebook
```

### 🔹 **Criar um novo produto**

```http
POST http://127.0.0.1:8000/api/produtos
```

**Body (JSON):**

```json
{
    "nome": "Notebook Dell",
    "descricao": "Intel Core i7, 16GB RAM",
    "preco": 5000.0,
    "estoque": 10
}
```

### 🔹 **Buscar um produto específico**

```http
GET http://127.0.0.1:8000/api/produtos/1
```

### 🔹 **Atualizar um produto**

```http
PUT http://127.0.0.1:8000/api/produtos/1
```

**Body (JSON):**

```json
{
    "preco": 4800.0,
    "estoque": 8
}
```

### 🔹 **Deletar um produto**

```http
DELETE http://127.0.0.1:8000/api/produtos/1
```

---

## 🔍 **Testes Automatizados**

A API possui testes automatizados para validar o funcionamento das rotas.

### 🔹 **Rodar os testes**

```bash
  php artisan test
```

Se tudo estiver correto, você verá a mensagem:

```
PASS  Tests\Feature\ProdutoTest
✓ listar produtos
✓ criar produto
✓ buscar produto
✓ atualizar produto
✓ deletar produto
```

---

## 🎯 **Conclusão**

Agora você tem uma API Laravel 100% funcional com CRUD, autenticação, paginação, filtros e testes automatizados.

**Dúvidas? Sugestões? Contribua no repositório!** 🚀

---

\*\*Desenvolvido por \*\*[**Lívia Gomes de Souza**](https://https://github.com/liviagomes30) 👨‍💻
