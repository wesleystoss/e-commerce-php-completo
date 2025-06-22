<?php

namespace App\Controllers;

use App\Models\Order;

class OrderController
{
    private $orderModel;

    public function __construct()
    {
        $this->orderModel = new Order();
    }

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $orders = $this->orderModel->getByUser($_SESSION['user_id']);
        require_once __DIR__ . '/../../views/orders/index.php';
    }

    public function show($id)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $order = $this->orderModel->getOrderWithItems($id);
        
        if (!$order || $order['user_id'] != $_SESSION['user_id']) {
            header('Location: /orders');
            exit;
        }

        require_once __DIR__ . '/../../views/orders/show.php';
    }
} 