<?php
// Ativar exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Teste Completo do Sistema</h1>";

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

// 2. Teste de carregamento de controladores
echo "<h2>2. Teste de Carregamento de Controladores</h2>";
$controllers = [
    'HomeController.php',
    'ProductController.php',
    'CartController.php',
    'AuthController.php',
    'OrderController.php',
    'AdminController.php',
    'ContactController.php',
    'NewsletterController.php'
];

foreach ($controllers as $controller) {
    $file = __DIR__ . "/app/controllers/$controller";
    if (file_exists($file)) {
        echo "<p style='color: green;'>✅ $controller</p>";
    } else {
        echo "<p style='color: red;'>❌ $controller</p>";
    }
}

// 3. Teste de carregamento de modelos
echo "<h2>3. Teste de Carregamento de Modelos</h2>";
$models = [
    'Product.php',
    'Category.php',
    'User.php',
    'Order.php',
    'OrderItem.php',
    'Newsletter.php'
];

foreach ($models as $model) {
    $file = __DIR__ . "/app/models/$model";
    if (file_exists($file)) {
        echo "<p style='color: green;'>✅ $model</p>";
    } else {
        echo "<p style='color: red;'>❌ $model</p>";
    }
}

// 4. Teste de carregamento de views
echo "<h2>4. Teste de Carregamento de Views</h2>";
$views = [
    'views/home/index.php',
    'views/layouts/header.php',
    'views/layouts/footer.php',
    'views/errors/404.php',
    'views/errors/500.php'
];

foreach ($views as $view) {
    $file = __DIR__ . "/$view";
    if (file_exists($file)) {
        echo "<p style='color: green;'>✅ $view</p>";
    } else {
        echo "<p style='color: red;'>❌ $view</p>";
    }
}

// 5. Teste de conexão com banco de dados
echo "<h2>5. Teste de Conexão com Banco de Dados</h2>";
try {
    require_once __DIR__ . '/app/config/Database.php';
    $db = App\Config\Database::getInstance();
    echo "<p style='color: green;'>✅ Conexão com banco de dados estabelecida</p>";
    
    // Testar consulta
    $result = $db->fetch("SELECT COUNT(*) as total FROM products");
    echo "<p><strong>Total de produtos:</strong> " . $result['total'] . "</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Erro na conexão com banco: " . $e->getMessage() . "</p>";
}

// 6. Teste de instanciação de controladores
echo "<h2>6. Teste de Instanciação de Controladores</h2>";
try {
    require_once __DIR__ . '/app/controllers/HomeController.php';
    $homeController = new HomeController();
    echo "<p style='color: green;'>✅ HomeController instanciado com sucesso</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Erro ao instanciar HomeController: " . $e->getMessage() . "</p>";
}

echo "<h2>Teste Concluído!</h2>";
echo "<p>Se todos os testes passaram, o sistema deve estar funcionando corretamente.</p>";
echo "<p><a href='public/'>Acessar o site</a></p>";
?> 