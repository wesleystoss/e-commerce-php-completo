<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;

class AdminController
{
    private $productModel;
    private $categoryModel;
    private $orderModel;
    private $userModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
        $this->orderModel = new Order();
        $this->userModel = new User();
    }

    public function index()
    {
        $this->checkAdminAuth();
        
        // Estatísticas do dashboard
        $totalProducts = count($this->productModel->getAll());
        $totalCategories = count($this->categoryModel->getAll());
        $totalOrders = count($this->orderModel->getAll());
        $totalUsers = count($this->userModel->getAll());
        
        // Produtos com baixo estoque
        $lowStockProducts = $this->productModel->getLowStock(5);
        
        // Últimos pedidos
        $recentOrders = $this->orderModel->getAll(5);
        
        require_once __DIR__ . '/../../views/admin/dashboard.php';
    }

    public function products()
    {
        $this->checkAdminAuth();
        
        $products = $this->productModel->getAll();
        require_once __DIR__ . '/../../views/admin/products/index.php';
    }

    public function categories()
    {
        $this->checkAdminAuth();
        
        $categories = $this->categoryModel->getAll();
        require_once __DIR__ . '/../../views/admin/categories/index.php';
    }

    public function orders()
    {
        $this->checkAdminAuth();
        
        $orders = $this->orderModel->getAll();
        require_once __DIR__ . '/../../views/admin/orders/index.php';
    }

    public function users()
    {
        $this->checkAdminAuth();
        
        $users = $this->userModel->getAll();
        require_once __DIR__ . '/../../views/admin/users/index.php';
    }

    private function checkAdminAuth()
    {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
            header('Location: /login');
            exit;
        }
    }
} 