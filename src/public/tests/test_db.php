<?php
// Ativar exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Carregar variáveis de ambiente
$envFile = __DIR__ . '/../../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

echo "<h1>Teste de Conexão com Banco de Dados</h1>";

try {
    $host = $_ENV['DB_HOST'] ?? 'localhost';
    $dbname = $_ENV['DB_NAME'] ?? 'u474727782_ecommerce';
    $username = $_ENV['DB_USER'] ?? 'u474727782_ecommerce';
    $password = $_ENV['DB_PASS'] ?? 'Wesley@3258';
    $port = $_ENV['DB_PORT'] ?? '3306';

    echo "<p><strong>Configurações:</strong></p>";
    echo "<ul>";
    echo "<li>Host: $host</li>";
    echo "<li>Database: $dbname</li>";
    echo "<li>User: $username</li>";
    echo "<li>Port: $port</li>";
    echo "</ul>";

    $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";
    
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    echo "<p style='color: green;'><strong>✅ Conexão com banco de dados estabelecida com sucesso!</strong></p>";

    // Testar consulta simples
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM products");
    $result = $stmt->fetch();
    echo "<p><strong>Total de produtos:</strong> " . $result['total'] . "</p>";

    // Testar consulta de categorias
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM categories");
    $result = $stmt->fetch();
    echo "<p><strong>Total de categorias:</strong> " . $result['total'] . "</p>";

} catch (PDOException $e) {
    echo "<p style='color: red;'><strong>❌ Erro na conexão com o banco de dados:</strong> " . $e->getMessage() . "</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'><strong>❌ Erro geral:</strong> " . $e->getMessage() . "</p>";
}
?> 