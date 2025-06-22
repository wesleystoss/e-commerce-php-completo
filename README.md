# TechStore - E-commerce Sofisticado

Um e-commerce moderno e elegante inspirado no design minimalista da Apple, desenvolvido com PHP puro e Tailwind CSS.

## 🎨 Design System

### Paleta de Cores Sofisticada
- **Primária**: `#475569` (Slate-600) - Cor principal para botões e elementos de destaque
- **Secundária**: `#64748b` (Slate-500) - Cor de acento para gradientes e hover
- **Escura**: `#1e293b` (Slate-800) - Texto principal e títulos
- **Clara**: `#e2e8f0` (Slate-200) - Fundos de input e elementos secundários
- **Borda**: `#cbd5e1` (Slate-300) - Bordas e divisores
- **Texto**: `#475569` (Slate-600) - Texto secundário
- **Muted**: `#94a3b8` (Slate-400) - Texto terciário e placeholders

### Características do Design
- **Minimalista**: Foco na simplicidade e elegância
- **Sofisticado**: Paleta de cores neutras e profissionais
- **Responsivo**: Design adaptável para todos os dispositivos
- **Acessível**: Alto contraste e navegação intuitiva
- **Moderno**: Animações suaves e micro-interações

## 🚀 Tecnologias

- **Backend**: PHP 8.0+
- **Frontend**: Tailwind CSS
- **Banco de Dados**: MySQL
- **Ícones**: Font Awesome 6
- **Fontes**: Inter (Google Fonts)
- **Containerização**: Docker & Docker Compose

## 📁 Estrutura do Projeto

```
e-commerce-basico/
├── docker/                 # Configurações Docker
│   ├── mysql/             # Configurações MySQL
│   └── php/               # Configurações PHP
├── src/                   # Código fonte
│   ├── app/              # Aplicação principal
│   │   ├── config/       # Configurações
│   │   ├── controllers/  # Controladores
│   │   ├── models/       # Modelos
│   │   └── services/     # Serviços
│   ├── public/           # Arquivos públicos
│   ├── views/            # Templates
│   │   ├── auth/         # Páginas de autenticação
│   │   ├── cart/         # Páginas do carrinho
│   │   ├── home/         # Página inicial
│   │   ├── layouts/      # Layouts base
│   │   ├── orders/       # Páginas de pedidos
│   │   └── products/     # Páginas de produtos
│   └── vendor/           # Dependências Composer
├── docker-compose.yml    # Configuração Docker Compose
├── Dockerfile           # Dockerfile da aplicação
└── README.md           # Este arquivo
```

## ✨ Funcionalidades

### 🛍️ E-commerce
- **Catálogo de Produtos**: Visualização em grid com filtros avançados
- **Detalhes do Produto**: Páginas completas com imagens e descrições
- **Carrinho de Compras**: Gestão de itens com controles intuitivos
- **Sistema de Pedidos**: Histórico completo e rastreamento
- **Busca Inteligente**: Filtros por categoria, preço e disponibilidade

### 👤 Usuários
- **Autenticação**: Login e registro com validação
- **Perfil do Usuário**: Gestão de dados pessoais
- **Histórico de Pedidos**: Visualização detalhada de compras
- **Alteração de Senha**: Sistema seguro de troca de senha

### 🎨 Interface
- **Design Responsivo**: Adaptável para mobile, tablet e desktop
- **Navegação Intuitiva**: Menu dropdown e breadcrumbs
- **Animações Suaves**: Transições e hover effects
- **Loading States**: Indicadores de carregamento
- **Feedback Visual**: Mensagens de sucesso e erro

### 🔒 Segurança
- **Validação de Dados**: Sanitização e validação de inputs
- **Sessões Seguras**: Gestão segura de sessões de usuário
- **SQL Injection Protection**: Prepared statements
- **XSS Protection**: Escape de dados de saída

## 🎯 Páginas Principais

### 🏠 Página Inicial
- Hero section com call-to-action
- Produtos em destaque
- Categorias principais
- Newsletter signup
- Seção de benefícios

### 📱 Páginas de Produtos
- **Listagem**: Grid responsivo com filtros
- **Detalhes**: Layout em duas colunas com galeria
- **Busca**: Resultados com filtros avançados
- **Categoria**: Produtos por categoria

### 🛒 Carrinho e Checkout
- **Carrinho**: Resumo visual com controles
- **Checkout**: Formulário de finalização
- **Pagamento**: Múltiplas formas de pagamento

### 👤 Área do Usuário
- **Login/Registro**: Formulários minimalistas
- **Perfil**: Gestão de dados pessoais
- **Pedidos**: Histórico completo com timeline

## 🚀 Instalação

### Pré-requisitos
- Docker e Docker Compose
- Git

### Passos

1. **Clone o repositório**
```bash
git clone <url-do-repositorio>
cd e-commerce-basico
```

2. **Configure o ambiente**
```bash
# Windows
./setup.ps1

# Linux/Mac
./setup.sh
```

3. **Acesse a aplicação**
```
http://localhost:8080
```

### Configuração Manual

1. **Configure o banco de dados**
```bash
# Copie o arquivo de exemplo
cp src/env.example src/.env

# Edite as variáveis de ambiente
DB_HOST=localhost
DB_NAME=ecommerce
DB_USER=root
DB_PASS=password
```

2. **Instale as dependências**
```bash
cd src
composer install
```

3. **Execute as migrações**
```bash
# Crie as tabelas no banco de dados
# (Execute os scripts SQL fornecidos)
```

## 🎨 Personalização

### Cores
As cores podem ser personalizadas editando as variáveis CSS no arquivo `src/views/layouts/header.php`:

```css
colors: {
    'sophisticated-gray': '#f8fafc',
    'sophisticated-dark': '#1e293b',
    'sophisticated-accent': '#64748b',
    'sophisticated-primary': '#475569',
    // ... outras cores
}
```

### Componentes
Todos os componentes são construídos com Tailwind CSS e podem ser facilmente customizados através das classes utilitárias.

## 📱 Responsividade

O design é totalmente responsivo com breakpoints:
- **Mobile**: < 768px
- **Tablet**: 768px - 1024px
- **Desktop**: > 1024px

## 🔧 Desenvolvimento

### Estrutura MVC
- **Models**: Lógica de negócio e acesso a dados
- **Views**: Templates e apresentação
- **Controllers**: Controle de fluxo e requisições

### Padrões Utilizados
- **Singleton**: Para conexão com banco de dados
- **Factory**: Para criação de objetos
- **Service Layer**: Para lógica de negócio complexa

## 🚀 Deploy

### Docker
```bash
docker-compose up -d
```

### Produção
1. Configure um servidor web (Apache/Nginx)
2. Configure o banco de dados MySQL
3. Configure as variáveis de ambiente
4. Execute `composer install --optimize-autoloader --no-dev`

## 🤝 Contribuição

1. Fork o projeto
2. Crie uma branch para sua feature
3. Commit suas mudanças
4. Push para a branch
5. Abra um Pull Request

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo `LICENSE` para mais detalhes.

## 🆘 Suporte

Para suporte, entre em contato através de:
- Email: contato@techstore.com
- Issues: GitHub Issues

---

**TechStore** - Tecnologia reimaginada com design sofisticado e funcionalidade excepcional. 