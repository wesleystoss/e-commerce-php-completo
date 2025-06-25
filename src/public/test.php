<?php
// Ativar exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Teste do Sistema no Subdomínio</h1>";

// 1. Teste de variáveis de ambiente
echo "<h2>1. Teste de Variáveis de Ambiente</h2>";
$envFile = __DIR__ . '/../.env';
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
    require_once __DIR__ . '/../app/config/Database.php';
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

// 3. Teste de roteamento no subdomínio
echo "<h2>3. Teste de Roteamento no Subdomínio</h2>";
$test_urls = [
    '/',
    '/home',
    '/products',
    '/product/1',
    '/category/1',
    '/cart',
    '/login',
    '/register'
];

foreach ($test_urls as $test_url) {
    echo "<h4>Testando URL: $test_url</h4>";
    
    // Simular REQUEST_URI no subdomínio
    $_SERVER['REQUEST_URI'] = $test_url;
    $_SERVER['SCRIPT_NAME'] = '/index.php';
    $_SERVER['HTTP_HOST'] = 'ecommerce.wesleystoss.com.br';
    
    // Roteamento simples
    $request_uri = $_SERVER['REQUEST_URI'];
    $path = parse_url($request_uri, PHP_URL_PATH);

    // Se estiver no subdomínio, não remover subdiretório
    if ($_SERVER['HTTP_HOST'] !== 'ecommerce.wesleystoss.com.br') {
        // Remover o subdiretório do path se existir
        $script_name = $_SERVER['SCRIPT_NAME'];
        $subdirectory = dirname($script_name);
        if ($subdirectory !== '/') {
            $path = str_replace($subdirectory, '', $path);
        }
    }

    // Remover base path se necessário
    $base_path = '/';
    if (strpos($path, $base_path) === 0) {
        $path = substr($path, strlen($base_path));
    }

    // Remover trailing slash
    $path = rtrim($path, '/');

    // Se path estiver vazio, definir como home
    if (empty($path)) {
        $path = 'home';
    }

    // Dividir path em partes
    $path_parts = explode('/', $path);
    $controller = $path_parts[0] ?? 'home';
    $action = $path_parts[1] ?? 'index';
    $param = $path_parts[2] ?? null;

    // Ajuste para rotas do tipo /category/6, /product/1, /order/2
    $controllers_with_param = ['category', 'product', 'order'];
    if (in_array($controller, $controllers_with_param) && isset($path_parts[1]) && is_numeric($path_parts[1])) {
        $action = 'show';
        $param = $path_parts[1];
    }

    echo "<p><strong>Path processado:</strong> $path</p>";
    echo "<p><strong>Controller:</strong> $controller</p>";
    echo "<p><strong>Action:</strong> $action</p>";
    if ($param) {
        echo "<p><strong>Param:</strong> $param</p>";
    }
    
    // Verificar se a rota existe no mapeamento
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
    
    if (isset($routes[$controller])) {
        $controller_class = $routes[$controller][0];
        $action_name = $routes[$controller][1];
        echo "<p style='color: green;'>✅ Rota mapeada: $controller_class -> $action_name</p>";
        
        // Verificar se o arquivo do controlador existe
        $controller_file = __DIR__ . "/../app/controllers/$controller_class.php";
        if (file_exists($controller_file)) {
            echo "<p style='color: green;'>✅ Arquivo do controlador existe: $controller_class.php</p>";
        } else {
            echo "<p style='color: red;'>❌ Arquivo do controlador não encontrado: $controller_class.php</p>";
        }
    } else {
        echo "<p style='color: red;'>❌ Rota não encontrada no mapeamento</p>";
    }
    
    echo "<hr>";
}

// 4. Teste de baseUrl no Subdomínio
echo "<h2>4. Teste de baseUrl no Subdomínio</h2>";
$_SERVER['HTTP_HOST'] = 'ecommerce.wesleystoss.com.br';
$_SERVER['SCRIPT_NAME'] = '/index.php';

// Função baseUrl para teste
function baseUrl($path = '') {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $base = $protocol . '://' . $_SERVER['HTTP_HOST'];
    
    // Se estiver no subdomínio ecommerce.wesleystoss.com.br, não adicionar subdiretório
    if ($_SERVER['HTTP_HOST'] === 'ecommerce.wesleystoss.com.br') {
        return $base . $path;
    }
    
    // Adicionar o subdiretório se estiver em um
    $script_name = $_SERVER['SCRIPT_NAME'];
    $subdirectory = dirname($script_name);
    if ($subdirectory !== '/') {
        $base .= $subdirectory;
    }
    
    return $base . $path;
}

echo "<p><strong>baseUrl('/'):</strong> " . baseUrl('/') . "</p>";
echo "<p><strong>baseUrl('/login'):</strong> " . baseUrl('/login') . "</p>";
echo "<p><strong>baseUrl('/products'):</strong> " . baseUrl('/products') . "</p>";

echo "<h2>🎉 Teste do Sistema Concluído!</h2>";
echo "<p>Se todos os testes passaram, o sistema está funcionando corretamente no subdomínio.</p>";
echo "<p><strong>URLs para testar:</strong></p>";
echo "<ul>";
echo "<li><a href='/'>Página inicial</a></li>";
echo "<li><a href='/login'>Login</a></li>";
echo "<li><a href='/products'>Produtos</a></li>";
echo "<li><a href='/cart'>Carrinho</a></li>";
echo "<li><a href='/register'>Cadastro</a></li>";
echo "</ul>";
?> 