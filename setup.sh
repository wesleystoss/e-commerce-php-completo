#!/bin/bash

echo "🚀 Iniciando setup do E-commerce Básico..."

# Verificar se o Docker está instalado
if ! command -v docker &> /dev/null; then
    echo "❌ Docker não está instalado. Por favor, instale o Docker primeiro."
    exit 1
fi

if ! command -v docker-compose &> /dev/null; then
    echo "❌ Docker Compose não está instalado. Por favor, instale o Docker Compose primeiro."
    exit 1
fi

echo "✅ Docker e Docker Compose encontrados"

# Copiar arquivo de ambiente
if [ ! -f "src/.env" ]; then
    echo "📝 Copiando arquivo de ambiente..."
    cp src/env.example src/.env
    echo "✅ Arquivo .env criado. Edite se necessário."
else
    echo "✅ Arquivo .env já existe"
fi

# Subir containers
echo "🐳 Subindo containers Docker..."
docker-compose up --build -d

# Aguardar containers estarem prontos
echo "⏳ Aguardando containers estarem prontos..."
sleep 10

# Instalar dependências do Composer
echo "📦 Instalando dependências do PHP..."
docker-compose exec -T app composer install --no-interaction

# Criar tabelas do banco
echo "🗄️ Criando tabelas do banco de dados..."
docker-compose exec -T db mysql -u ecommerce_user -ppassword ecommerce_db < src/app/config/migrations.sql

# Perguntar se quer inserir dados de exemplo
read -p "🤔 Deseja inserir dados de exemplo? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo "📊 Inserindo dados de exemplo..."
    docker-compose exec -T db mysql -u ecommerce_user -ppassword ecommerce_db < src/app/config/sample_data.sql
    echo "✅ Dados de exemplo inseridos"
fi

echo ""
echo "🎉 Setup concluído!"
echo ""
echo "📱 Acesse o sistema:"
echo "   - Front-end: http://localhost:8001"
echo "   - phpMyAdmin: http://localhost:8080 (usuário: ecommerce_user, senha: password)"
echo ""
echo "💡 Para parar os containers: docker-compose down"
echo "💡 Para ver logs: docker-compose logs -f" 