<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Services\CartService;

class ProductController
{
    private $productModel;
    private $categoryModel;
    private $cartService;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
        $this->cartService = new CartService();
    }

    public function index()
    {
        $page = $_GET['page'] ?? 1;
        $limit = 12;
        $offset = ($page - 1) * $limit;

        $products = $this->productModel->getAll($limit, $offset);
        $categories = $this->categoryModel->getAll();
        $totalProducts = count($this->productModel->getAll());

        $totalPages = ceil($totalProducts / $limit);

        require_once __DIR__ . '/../../views/products/index.php';
    }

    public function show($id)
    {
        $product = $this->productModel->findById($id);
        
        if (!$product) {
            header('Location: /products');
            exit;
        }

        $relatedProducts = $this->productModel->getByCategory($product['category_id']);
        
        require_once __DIR__ . '/../../views/products/show.php';
    }

    public function search()
    {
        $query = $_GET['q'] ?? '';
        $category_id = $_GET['category'] ?? null;
        $min_price = $_GET['min_price'] ?? null;
        $max_price = $_GET['max_price'] ?? null;

        $products = $this->productModel->search($query, $category_id, $min_price, $max_price);
        $categories = $this->categoryModel->getAll();

        require_once __DIR__ . '/../../views/products/search.php';
    }

    public function category($category_id)
    {
        $category = $this->categoryModel->findById($category_id);
        
        if (!$category) {
            header('Location: /products');
            exit;
        }

        $products = $this->productModel->getByCategory($category_id);
        $categories = $this->categoryModel->getAll();

        require_once __DIR__ . '/../../views/products/category.php';
    }

    public function addToCart()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /products');
            exit;
        }

        $product_id = $_POST['product_id'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;

        if (!$product_id) {
            $_SESSION['error'] = 'Produto não especificado.';
            header('Location: /products');
            exit;
        }

        if ($this->cartService->add($product_id, $quantity)) {
            $_SESSION['success'] = 'Produto adicionado ao carrinho!';
        } else {
            $_SESSION['error'] = 'Erro ao adicionar produto ao carrinho.';
        }

        header('Location: /cart');
        exit;
    }

    // Métodos para administração (requerem autenticação)
    public function adminIndex()
    {
        $this->checkAdminAuth();
        
        $products = $this->productModel->getAll();
        require_once __DIR__ . '/../../views/admin/products/index.php';
    }

    public function adminCreate()
    {
        $this->checkAdminAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'stock' => $_POST['stock'],
                'category_id' => $_POST['category_id'],
                'image_url' => $_POST['image_url'] ?? null
            ];

            $product_id = $this->productModel->create($data);
            
            if ($product_id) {
                $_SESSION['success'] = 'Produto criado com sucesso!';
                header('Location: /admin/products');
            } else {
                $_SESSION['error'] = 'Erro ao criar produto.';
            }
            exit;
        }

        $categories = $this->categoryModel->getAll();
        require_once __DIR__ . '/../../views/admin/products/create.php';
    }

    public function adminEdit($id)
    {
        $this->checkAdminAuth();
        
        $product = $this->productModel->findById($id);
        
        if (!$product) {
            header('Location: /admin/products');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'stock' => $_POST['stock'],
                'category_id' => $_POST['category_id'],
                'image_url' => $_POST['image_url'] ?? null
            ];

            if ($this->productModel->update($id, $data)) {
                $_SESSION['success'] = 'Produto atualizado com sucesso!';
                header('Location: /admin/products');
            } else {
                $_SESSION['error'] = 'Erro ao atualizar produto.';
            }
            exit;
        }

        $categories = $this->categoryModel->getAll();
        require_once __DIR__ . '/../../views/admin/products/edit.php';
    }

    public function adminDelete($id)
    {
        $this->checkAdminAuth();
        
        if ($this->productModel->delete($id)) {
            $_SESSION['success'] = 'Produto excluído com sucesso!';
        } else {
            $_SESSION['error'] = 'Erro ao excluir produto.';
        }

        header('Location: /admin/products');
        exit;
    }

    private function checkAdminAuth()
    {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
            header('Location: /login');
            exit;
        }
    }
} 