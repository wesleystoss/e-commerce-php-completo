<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Iniciar sessão
session_start();

// Configurar timezone
date_default_timezone_set('America/Sao_Paulo');

// Configurar encoding
mb_internal_encoding('UTF-8');

// Função para obter a URL base
function baseUrl($path = '') {
    $base = 'http://' . $_SERVER['HTTP_HOST'];
    if (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != '80') {
        $base .= ':' . $_SERVER['SERVER_PORT'];
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
    $action = $controller;
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
    $controller_class = 'App\\Controllers\\' . $route[0];
    $action_name = $route[1];
} else {
    // Verificar se a rota existe
    if (!isset($routes[$controller])) {
        http_response_code(404);
        require_once __DIR__ . '/../views/errors/404.php';
        exit;
    }

    // Instanciar controlador
    $controller_class = 'App\\Controllers\\' . $routes[$controller][0];
    $action_name = $routes[$controller][1];
}

try {
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