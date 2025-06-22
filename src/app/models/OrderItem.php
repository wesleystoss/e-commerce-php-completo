<?php

namespace App\Models;

use App\Config\Database;

class OrderItem
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function create($data)
    {
        $sql = "INSERT INTO order_items (order_id, product_id, quantity, price, created_at) 
                VALUES (?, ?, ?, ?, NOW())";
        
        $this->db->query($sql, [
            $data['order_id'],
            $data['product_id'],
            $data['quantity'],
            $data['price']
        ]);

        return $this->db->lastInsertId();
    }

    public function getByOrder($order_id)
    {
        $sql = "SELECT oi.*, p.name as product_name, p.image_url 
                FROM order_items oi 
                LEFT JOIN products p ON oi.product_id = p.id 
                WHERE oi.order_id = ?";
        return $this->db->fetchAll($sql, [$order_id]);
    }

    public function createFromCart($order_id, $cart_items)
    {
        foreach ($cart_items as $item) {
            $this->create([
                'order_id' => $order_id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }
    }
} 