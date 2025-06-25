<?php
// Ativar exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Teste de Roteamento</h1>";

// Mapeamento de rotas (igual ao do index.php)
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

// Simular diferentes URLs
$test_urls = [
    '/',
    '/home',
    '/products',
    '/product/1',
    '/category/1',
    '/cart',
    '/login'
];

foreach ($test_urls as $test_url) {
    echo "<h3>Testando URL: $test_url</h3>";
    
    // Simular REQUEST_URI
    $_SERVER['REQUEST_URI'] = $test_url;
    $_SERVER['SCRIPT_NAME'] = '/portfolio/ecommerce/src/public/index.php';
    
    // Roteamento simples
    $request_uri = $_SERVER['REQUEST_URI'];
    $path = parse_url($request_uri, PHP_URL_PATH);

    // Remover o subdiretório do path se existir
    $script_name = $_SERVER['SCRIPT_NAME'];
    $subdirectory = dirname($script_name);
    if ($subdirectory !== '/') {
        $path = str_replace($subdirectory, '', $path);
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
        $action = 'show'; // Mudar action para 'show' quando há parâmetro numérico
        $param = $path_parts[1];
    }

    echo "<p><strong>Path processado:</strong> $path</p>";
    echo "<p><strong>Controller:</strong> $controller</p>";
    echo "<p><strong>Action:</strong> $action</p>";
    if ($param) {
        echo "<p><strong>Param:</strong> $param</p>";
    }
    
    // Verificar se a rota existe no mapeamento
    if (isset($routes[$controller])) {
        $controller_class = $routes[$controller][0];
        $action_name = $routes[$controller][1];
        echo "<p style='color: green;'>✅ Rota mapeada: $controller_class -> $action_name</p>";
        
        // Verificar se o arquivo do controlador existe
        $controller_file = __DIR__ . "/app/controllers/$controller_class.php";
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
?> 