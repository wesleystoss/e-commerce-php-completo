# Script de setup para Windows (PowerShell)

Write-Host "🚀 Iniciando setup do E-commerce Básico..." -ForegroundColor Green

# Verificar se o Docker está instalado
try {
    docker --version | Out-Null
    docker-compose --version | Out-Null
    Write-Host "✅ Docker e Docker Compose encontrados" -ForegroundColor Green
} catch {
    Write-Host "❌ Docker não está instalado ou não está no PATH. Por favor, instale o Docker primeiro." -ForegroundColor Red
    exit 1
}

# Copiar arquivo de ambiente
if (-not (Test-Path "src\.env")) {
    Write-Host "📝 Copiando arquivo de ambiente..." -ForegroundColor Yellow
    Copy-Item "src\env.example" "src\.env"
    Write-Host "✅ Arquivo .env criado. Edite se necessário." -ForegroundColor Green
} else {
    Write-Host "✅ Arquivo .env já existe" -ForegroundColor Green
}

# Subir containers
Write-Host "🐳 Subindo containers Docker..." -ForegroundColor Yellow
docker-compose up --build -d

# Aguardar containers estarem prontos
Write-Host "⏳ Aguardando containers estarem prontos..." -ForegroundColor Yellow
Start-Sleep -Seconds 10

# Instalar dependências do Composer
Write-Host "📦 Instalando dependências do PHP..." -ForegroundColor Yellow
docker-compose exec -T app composer install --no-interaction

# Criar tabelas do banco
Write-Host "🗄️ Criando tabelas do banco de dados..." -ForegroundColor Yellow
Get-Content "src\app\config\migrations.sql" | docker-compose exec -T db mysql -u ecommerce_user -ppassword ecommerce_db

# Perguntar se quer inserir dados de exemplo
$response = Read-Host "🤔 Deseja inserir dados de exemplo? (y/n)"
if ($response -eq "y" -or $response -eq "Y") {
    Write-Host "📊 Inserindo dados de exemplo..." -ForegroundColor Yellow
    Get-Content "src\app\config\sample_data.sql" | docker-compose exec -T db mysql -u ecommerce_user -ppassword ecommerce_db
    Write-Host "✅ Dados de exemplo inseridos" -ForegroundColor Green
}

Write-Host ""
Write-Host "🎉 Setup concluído!" -ForegroundColor Green
Write-Host ""
Write-Host "📱 Acesse o sistema:" -ForegroundColor Cyan
Write-Host "   - Front-end: http://localhost:8001" -ForegroundColor White
Write-Host "   - phpMyAdmin: http://localhost:8080 (usuário: ecommerce_user, senha: password)" -ForegroundColor White
Write-Host ""
Write-Host "💡 Para parar os containers: docker-compose down" -ForegroundColor Yellow
Write-Host "💡 Para ver logs: docker-compose logs -f" -ForegroundColor Yellow 