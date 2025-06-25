<?php
// Ativar exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Teste Final do Sistema</h1>";

// 1. Teste de carregamento de variáveis de ambiente
echo "<h2>1. Teste de Variáveis de Ambiente</h2>";
$envFile = __DIR__ . '/../../.env';
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
    require_once __DIR__ . '/../../app/config/Database.php';
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

// 3. Teste de instanciação de controladores
echo "<h2>3. Teste de Instanciação de Controladores</h2>";
$controllers = [
    'App\\Controllers\\HomeController',
    'App\\Controllers\\ProductController', 
    'App\\Controllers\\CartController',
    'App\\Controllers\\AuthController',
    'App\\Controllers\\OrderController',
    'App\\Controllers\\AdminController',
    'App\\Controllers\\ContactController',
    'App\\Controllers\\NewsletterController'
];

foreach ($controllers as $controller) {
    try {
        // Extrair o nome da classe sem namespace para o require
        $class_name = basename(str_replace('\\', '/', $controller));
        require_once __DIR__ . "/../../app/controllers/$class_name.php";
        $instance = new $controller();
        echo "<p style='color: green;'>✅ $class_name instanciado com sucesso</p>";
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Erro ao instanciar $class_name: " . $e->getMessage() . "</p>";
    }
}

// 4. Teste de mapeamento de rotas
echo "<h2>4. Teste de Mapeamento de Rotas</h2>";
$routes = [
    'home' => ['HomeController', 'index'],
    'products' => ['ProductController', 'index'],
    'product' => ['ProductController', 'show'],
    'search' => ['ProductController', 'search'],
    'category' => ['ProductController', 'category'],
    'cart' => ['CartController', 'index'],
    'checkout' => ['CartController', 'checkout'],
    'login' => ['AuthController', 'login'],
    'register' => ['AuthController', 'register'],
    'logout' => ['AuthController', 'logout'],
    'profile' => ['AuthController', 'profile'],
    'orders' => ['OrderController', 'index'],
    'order' => ['OrderController', 'show'],
    'admin' => ['AdminController', 'index'],
    'contact' => ['ContactController', 'index']
];

foreach ($routes as $route => $mapping) {
    $controller_class = $mapping[0];
    $action_name = $mapping[1];
    
    // Verificar se o arquivo existe
    $controller_file = __DIR__ . "/../../app/controllers/$controller_class.php";
    if (file_exists($controller_file)) {
        echo "<p style='color: green;'>✅ Rota '$route' -> $controller_class::$action_name</p>";
    } else {
        echo "<p style='color: red;'>❌ Rota '$route' -> $controller_class::$action_name (arquivo não encontrado)</p>";
    }
}

// 5. Teste de carregamento de views principais
echo "<h2>5. Teste de Carregamento de Views</h2>";
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
    $file = __DIR__ . "/../../$view";
    if (file_exists($file)) {
        echo "<p style='color: green;'>✅ $view</p>";
    } else {
        echo "<p style='color: red;'>❌ $view</p>";
    }
}

echo "<h2>🎉 Teste Final Concluído!</h2>";
echo "<p>Se todos os testes passaram, o sistema está pronto para uso.</p>";
echo "<p><strong>Próximos passos:</strong></p>";
echo "<ul>";
echo "<li><a href='public/'>Acessar o site principal</a></li>";
echo "<li><a href='public/products'>Ver produtos</a></li>";
echo "<li><a href='public/login'>Página de login</a></li>";
echo "<li><a href='public/cart'>Carrinho</a></li>";
echo "</ul>";
?> 