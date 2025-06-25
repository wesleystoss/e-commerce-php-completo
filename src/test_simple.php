<?php
// Ativar exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Teste Simples do Sistema</h1>";

// 1. Teste de carregamento de variáveis de ambiente
echo "<h2>1. Teste de Variáveis de Ambiente</h2>";
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    echo "<p style='color: green;'>✅ Arquivo .env encontrado</p>";
    
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
    
    echo "<p><strong>DB_HOST:</strong> " . ($_ENV['DB_HOST'] ?? 'não definido') . "</p>";
    echo "<p><strong>DB_NAME:</strong> " . ($_ENV['DB_NAME'] ?? 'não definido') . "</p>";
    echo "<p><strong>APP_URL:</strong> " . ($_ENV['APP_URL'] ?? 'não definido') . "</p>";
} else {
    echo "<p style='color: red;'>❌ Arquivo .env não encontrado</p>";
}

// 2. Teste de conexão com banco de dados
echo "<h2>2. Teste de Conexão com Banco de Dados</h2>";
try {
    require_once __DIR__ . '/app/config/Database.php';
    $db = App\Config\Database::getInstance();
    echo "<p style='color: green;'>✅ Conexão com banco de dados estabelecida</p>";
    
    // Testar consulta
    $result = $db->fetch("SELECT COUNT(*) as total FROM products");
    echo "<p><strong>Total de produtos:</strong> " . $result['total'] . "</p>";
    
    $result = $db->fetch("SELECT COUNT(*) as total FROM categories");
    echo "<p><strong>Total de categorias:</strong> " . $result['total'] . "</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Erro na conexão com banco: " . $e->getMessage() . "</p>";
}

// 3. Teste de carregamento de arquivos (sem instanciação)
echo "<h2>3. Teste de Carregamento de Arquivos</h2>";
$files = [
    'app/controllers/HomeController.php',
    'app/controllers/ProductController.php',
    'app/controllers/CartController.php',
    'app/controllers/AuthController.php',
    'app/controllers/OrderController.php',
    'app/controllers/AdminController.php',
    'app/controllers/ContactController.php',
    'app/controllers/NewsletterController.php',
    'app/models/Product.php',
    'app/models/Category.php',
    'app/models/User.php',
    'app/models/Order.php',
    'app/models/OrderItem.php',
    'app/models/Newsletter.php',
    'app/config/Database.php',
    'app/services/CartService.php'
];

foreach ($files as $file) {
    $full_path = __DIR__ . "/$file";
    if (file_exists($full_path)) {
        // Tentar incluir o arquivo
        try {
            require_once $full_path;
            echo "<p style='color: green;'>✅ $file carregado com sucesso</p>";
        } catch (Exception $e) {
            echo "<p style='color: orange;'>⚠️ $file carregado com aviso: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p style='color: red;'>❌ $file não encontrado</p>";
    }
}

// 4. Teste de carregamento de views
echo "<h2>4. Teste de Carregamento de Views</h2>";
$views = [
    'views/home/index.php',
    'views/layouts/header.php',
    'views/layouts/footer.php',
    'views/errors/404.php',
    'views/errors/500.php',
    'views/products/index.php',
    'views/auth/login.php'
];

foreach ($views as $view) {
    $file = __DIR__ . "/$view";
    if (file_exists($file)) {
        echo "<p style='color: green;'>✅ $view</p>";
    } else {
        echo "<p style='color: red;'>❌ $view</p>";
    }
}

echo "<h2>🎉 Teste Simples Concluído!</h2>";
echo "<p>Se todos os testes passaram, o sistema deve estar funcionando.</p>";
echo "<p><strong>Próximos passos:</strong></p>";
echo "<ul>";
echo "<li><a href='public/'>Acessar o site principal</a></li>";
echo "<li><a href='public/products'>Ver produtos</a></li>";
echo "<li><a href='public/login'>Página de login</a></li>";
echo "<li><a href='public/cart'>Carrinho</a></li>";
echo "</ul>";
?> 