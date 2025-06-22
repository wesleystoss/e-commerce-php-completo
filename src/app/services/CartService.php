<?php

namespace App\Services;

use App\Models\Product;

class CartService
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function add($product_id, $quantity = 1)
    {
        $productModel = new Product();
        $product = $productModel->findById($product_id);
        
        if (!$product) {
            return false;
        }

        if ($product['stock'] < $quantity) {
            return false;
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = [
                'product_id' => $product_id,
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity,
                'image_url' => $product['image_url']
            ];
        }

        return true;
    }

    public function update($product_id, $quantity)
    {
        if (!isset($_SESSION['cart'][$product_id])) {
            return false;
        }

        if ($quantity <= 0) {
            $this->remove($product_id);
            return true;
        }

        $productModel = new Product();
        $product = $productModel->findById($product_id);
        
        if ($product['stock'] < $quantity) {
            return false;
        }

        $_SESSION['cart'][$product_id]['quantity'] = $quantity;
        return true;
    }

    public function remove($product_id)
    {
        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
            return true;
        }
        return false;
    }

    public function clear()
    {
        $_SESSION['cart'] = [];
    }

    public function getItems()
    {
        return $_SESSION['cart'] ?? [];
    }

    public function getTotal()
    {
        $total = 0;
        foreach ($this->getItems() as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    public function getCount()
    {
        $count = 0;
        foreach ($this->getItems() as $item) {
            $count += $item['quantity'];
        }
        return $count;
    }

    public function isEmpty()
    {
        return empty($_SESSION['cart']);
    }

    public function getItem($product_id)
    {
        return $_SESSION['cart'][$product_id] ?? null;
    }

    public function validateStock()
    {
        $productModel = new Product();
        $errors = [];

        foreach ($this->getItems() as $product_id => $item) {
            $product = $productModel->findById($product_id);
            
            if (!$product) {
                $errors[] = "Produto '{$item['name']}' não encontrado.";
                $this->remove($product_id);
            } elseif ($product['stock'] < $item['quantity']) {
                $errors[] = "Estoque insuficiente para '{$item['name']}'. Disponível: {$product['stock']}";
                if ($product['stock'] == 0) {
                    $this->remove($product_id);
                } else {
                    $_SESSION['cart'][$product_id]['quantity'] = $product['stock'];
                }
            }
        }

        return $errors;
    }
} 