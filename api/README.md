# FeiraFácil - Documentação da API

## Objetivo da API

A API foi criada para permitir a comunicação entre o sistema FeiraFácil e outras interfaces, como o site (front-end) e o aplicativo mobile. Com ela, é possível acessar, cadastrar, atualizar e excluir dados dos produtos, usuários, feiras e outros recursos do sistema.

---

## Entidades e Rotas

### Produtos (`/products`)

* `GET /products` – Lista todos os produtos.
* `GET /products/id/{id}` – Mostra os dados de um produto específico.
* `POST /products` – Cadastra um produto (`idCategory`, `name`, `price`).
* `PUT /products/id/{id}` – Atualiza um produto existente.
* `DELETE /products/id/{id}` – Exclui um produto pelo ID.

---

### Usuários (`/users`)

* `GET /users` – Lista todos os usuários.
* `GET /users/id/{id}` – Mostra os dados de um usuário específico.
* `POST /users` – Cadastra um usuário (`idType`, `name`, `email`, `password`).
* `PUT /users/id/{id}` – Atualiza os dados do usuário.
* `DELETE /users/id/{id}` – Remove um usuário.

---

### Feiras (`/markets`)

* `GET /markets` – Lista todas as feiras.
* `GET /markets/id/{id}` – Mostra os dados de uma feira específica.
* `POST /markets` – Cria uma nova feira (`name`, `location`, `date`, etc).
* `PUT /markets/id/{id}` – Atualiza os dados de uma feira.
* `DELETE /markets/id/{id}` – Remove uma feira.

---

### Pedidos (`/orders`)

* `GET /orders` – Lista todos os pedidos.
* `GET /orders/id/{id}` – Mostra os dados de um pedido específico.
* `POST /orders` – Cria um novo pedido (`idUser`, `idMarket`, `totalValue`).
* `DELETE /orders/id/{id}` – Remove um pedido.

---

### Itens do Pedido (`/order-items`)

* `GET /order-items/order/{id}` – Lista os itens de um pedido.
* `POST /order-items` – Adiciona um item ao pedido (`idOrder`, `idProduct`, `quantity`, `unitPrice`).

---

### Estoque de Produtos (`/product-stock`)

* `GET /product-stock/product/{id}` – Consulta o estoque de um produto.
* `PUT /product-stock/product/{id}` – Atualiza o estoque de um produto.

---

### Endereços (`/addresses`)

* `GET /addresses/user/{id}` – Lista endereços de um usuário.
* `POST /addresses` – Cadastra um novo endereço (`idUser`, `street`, `number`, `city`, etc).
* `PUT /addresses/id/{id}` – Atualiza um endereço.
* `DELETE /addresses/id/{id}` – Remove um endereço.

---

### Horários das Feiras (`/market-schedules`)

* `GET /market-schedules/market/{id}` – Lista horários de uma feira.
* `POST /market-schedules` – Cadastra um novo horário.
* `PUT /market-schedules/id/{id}` – Atualiza um horário.
* `DELETE /market-schedules/id/{id}` – Remove um horário.

---

### Avaliações (`/reviews`)

* `GET /reviews/product/{id}` – Lista avaliações de um produto.
* `GET /reviews/market/{id}` – Lista avaliações de uma feira.
* `POST /reviews` – Cria uma nova avaliação (`idUser`, `idProduct` ou `idMarket`, `rating`, `comment`).

---

## Autenticação

Algumas rotas exigem **autenticação com JWT (JSON Web Token)**. O token deve ser enviado no cabeçalho da requisição como:

```http
Authorization: Bearer {seu_token}
```

---

## Códigos de Resposta

* `200` – Requisição feita com sucesso
* `201` – Recurso criado com sucesso
* `400` – Dados inválidos ou incompletos
* `401` – Não autorizado (token ausente ou inválido)
* `404` – Recurso não encontrado
* `500` – Erro interno do servidor

---

## Observações

* Todas as requisições e testes foram feitos com o Postman.
* O projeto está organizado em pastas diferentes para Web (`/web`), App (`/app`) e Admin (`/adm`).
* A API está na pasta `/api` e usa o CoffeeCode Router para rotas amigáveis.

---

## Autores

João Vitor Flores de Lima e Gabriel Fonseca Salcedo Chaves.
Professor: Fábio.
