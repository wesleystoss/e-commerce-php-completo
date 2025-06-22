<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\Category;

try {
    $categoryModel = new Category();
    echo "Modelo instanciado com sucesso\n";
    
    $categories = $categoryModel->getWithProductCount();
    echo "Resultado do getWithProductCount:\n";
    print_r($categories);
    
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
} 