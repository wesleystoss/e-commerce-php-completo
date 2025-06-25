<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Config\Database;
use App\Models\Category;

// Testar conexão com banco
try {
    $db = Database::getInstance();
    echo "Conexão com banco OK\n";
    
    // Testar consulta direta
    $sql = "SELECT c.*, COUNT(p.id) as product_count 
            FROM categories c 
            LEFT JOIN products p ON c.id = p.category_id 
            GROUP BY c.id 
            ORDER BY c.name ASC";
    
    $result = $db->fetchAll($sql);
    echo "Resultado da consulta:\n";
    print_r($result);
    
    // Testar modelo
    $categoryModel = new Category();
    $categories = $categoryModel->getWithProductCount();
    echo "\nResultado do modelo:\n";
    print_r($categories);
    
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
} 