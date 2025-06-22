# E-commerce Básico (Loja Virtual)

Este é um projeto completo de e-commerce desenvolvido em PHP, utilizando Docker, Composer, MySQL e um front-end moderno com Bootstrap. O sistema permite cadastro e login de usuários, listagem de produtos, carrinho de compras, checkout simplificado, gerenciamento de estoque, pesquisa e filtragem, além de um painel administrativo.

## Funcionalidades
- Cadastro e login de usuários
- Listagem e busca de produtos
- Filtros por categoria e preço
- Carrinho de compras com sessão
- Checkout simplificado (sem integração real de pagamento)
- Controle de estoque
- Relacionamento entre produtos, categorias, usuários, pedidos e itens de pedido
- Painel administrativo (CRUD de produtos e categorias)

## Tecnologias Utilizadas
- PHP 8.2
- MySQL 8
- Docker e Docker Compose
- Composer
- Bootstrap 5
- PDO (acesso ao banco)

## Como rodar o projeto

### Pré-requisitos
- [Docker](https://www.docker.com/) e [Docker Compose](https://docs.docker.com/compose/)

### Passos
1. Clone este repositório:
   ```bash
   git clone <url-do-repo>
   cd Portifólio
   ```
2. Copie o arquivo de variáveis de ambiente:
   ```bash
   cp src/env.example src/.env
   ```
   (Edite se desejar alterar configurações de banco ou SMTP)

3. Suba os containers Docker:
   ```bash
   docker-compose up --build
   ```

4. Instale as dependências do PHP (dentro do container):
   ```bash
   docker-compose exec app composer install
   ```

5. Crie as tabelas do banco de dados (dentro do container):
   ```bash
   docker-compose exec db mysql -u ecommerce_user -ppassword ecommerce_db < /var/www/app/config/migrations.sql
   ```

6. Acesse o sistema:
   - Front-end: [http://localhost:8001](http://localhost:8001)
   - phpMyAdmin: [http://localhost:8080](http://localhost:8080) (usuário: `ecommerce_user`, senha: `password`)

## Usuário Administrador
Para criar um usuário administrador, após cadastrar um usuário, altere o campo `is_admin` para `1` na tabela `users` via phpMyAdmin ou MySQL:

```sql
UPDATE users SET is_admin = 1 WHERE email = 'seu-email@exemplo.com';
```

## Estrutura de Pastas
- `src/app/models` - Modelos do banco de dados
- `src/app/controllers` - Controladores da aplicação
- `src/app/services` - Serviços auxiliares (ex: carrinho)
- `src/views` - Views (front-end)
- `src/public` - Arquivo de entrada (index.php)
- `src/app/config` - Configurações e migrations

## Personalização
- Adicione produtos, categorias e usuários pelo painel admin ou diretamente no banco.
- Imagens de produtos podem ser URLs externas.

## Observações
- O checkout é simplificado, não há integração real com gateways de pagamento.
- O sistema pode ser expandido facilmente para novas funcionalidades.

---

Desenvolvido para portfólio profissional. Dúvidas ou sugestões? Entre em contato! 