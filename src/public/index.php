<?php

// Ativar exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Carregar variáveis de ambiente
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

// Include manual dos arquivos principais (solução definitiva)
require_once __DIR__ . '/../app/controllers/HomeController.php';
require_once __DIR__ . '/../app/controllers/ProductController.php';
require_once __DIR__ . '/../app/controllers/CartController.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/OrderController.php';
require_once __DIR__ . '/../app/controllers/AdminController.php';
require_once __DIR__ . '/../app/controllers/ContactController.php';
require_once __DIR__ . '/../app/controllers/NewsletterController.php';

require_once __DIR__ . '/../app/models/Product.php';
require_once __DIR__ . '/../app/models/Category.php';
require_once __DIR__ . '/../app/models/User.php';
require_once __DIR__ . '/../app/models/Order.php';
require_once __DIR__ . '/../app/models/OrderItem.php';
require_once __DIR__ . '/../app/models/Newsletter.php';

require_once __DIR__ . '/../app/config/Database.php';
require_once __DIR__ . '/../app/services/CartService.php';

// Iniciar sessão
session_start();

// Configurar timezone
date_default_timezone_set('America/Sao_Paulo');

// Configurar encoding
mb_internal_encoding('UTF-8');

// Função para obter a URL base
function baseUrl($path = '') {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $base = $protocol . '://' . $_SERVER['HTTP_HOST'];
    
    // Adicionar o subdiretório se estiver em um
    $script_name = $_SERVER['SCRIPT_NAME'];
    $subdirectory = dirname($script_name);
    if ($subdirectory !== '/') {
        $base .= $subdirectory;
    }
    
    return $base . $path;
}

// Função para redirecionar
function redirect($path) {
    header('Location: ' . baseUrl($path));
    exit;
}

// Função para escapar HTML
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Função para formatar preço
function formatPrice($price) {
    return 'R$ ' . number_format($price, 2, ',', '.');
}

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

// Mapeamento de rotas com subações
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

// Mapeamento específico para rotas com subações
$specific_routes = [
    'cart/add' => ['CartController', 'addToCart'],
    'cart/update' => ['CartController', 'update'],
    'cart/remove' => ['CartController', 'remove'],
    'cart/clear' => ['CartController', 'clear'],
    'cart/checkout' => ['CartController', 'checkout'],
    'cart/processCheckout' => ['CartController', 'processCheckout'],
    'product/add-to-cart' => ['ProductController', 'addToCart'],
    'newsletter/subscribe' => ['NewsletterController', 'subscribe'],
];

// Verificar se é uma rota específica
$full_path = $controller . ($action !== 'index' ? '/' . $action : '');
if (isset($specific_routes[$full_path])) {
    $route = $specific_routes[$full_path];
    $controller_class = $route[0];
    $action_name = $route[1];
} else {
    // Verificar se a rota existe
    if (!isset($routes[$controller])) {
        http_response_code(404);
        require_once __DIR__ . '/../views/errors/404.php';
        exit;
    }

    // Instanciar controlador
    $controller_class = $routes[$controller][0];
    $action_name = $routes[$controller][1];
}

try {
    // Adicionar namespace aos controladores
    $controller_class = 'App\\Controllers\\' . $controller_class;
    $controller_instance = new $controller_class();
    
    // Verificar se o método existe
    if (!method_exists($controller_instance, $action_name)) {
        http_response_code(404);
        require_once __DIR__ . '/../views/errors/404.php';
        exit;
    }
    
    // Chamar método com parâmetro se existir
    if ($param) {
        $controller_instance->$action_name($param);
    } else {
        $controller_instance->$action_name();
    }
} catch (Exception $e) {
    // Log do erro
    error_log($e->getMessage());
    
    // Página de erro
    http_response_code(500);
    require_once __DIR__ . '/../views/errors/500.php';
    exit;
} 