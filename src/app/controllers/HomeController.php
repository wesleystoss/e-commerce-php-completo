<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\Category;

class HomeController
{
    private $productModel;
    private $categoryModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
    }

    public function index()
    {
        // Produtos em destaque (últimos adicionados)
        $featuredProducts = $this->productModel->getAll(8);
        
        // Categorias com contagem de produtos
        $categories = $this->categoryModel->getWithProductCount();
        
        // Produtos com baixo estoque (para admin)
        $lowStockProducts = [];
        if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
            $lowStockProducts = $this->productModel->getLowStock(5);
        }
        
        require_once __DIR__ . '/../../views/home/index.php';
    }
} 