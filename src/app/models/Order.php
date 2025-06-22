<?php

namespace App\Models;

use App\Config\Database;

class Order
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function create($data)
    {
        $sql = "INSERT INTO orders (user_id, total_amount, status, shipping_address, payment_method, created_at) 
                VALUES (?, ?, ?, ?, ?, NOW())";
        
        $this->db->query($sql, [
            $data['user_id'],
            $data['total_amount'],
            $data['status'] ?? 'pending',
            $data['shipping_address'],
            $data['payment_method']
        ]);

        return $this->db->lastInsertId();
    }

    public function findById($id)
    {
        $sql = "SELECT o.*, u.name as user_name, u.email as user_email 
                FROM orders o 
                LEFT JOIN users u ON o.user_id = u.id 
                WHERE o.id = ?";
        return $this->db->fetch($sql, [$id]);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE orders SET status = ?, updated_at = NOW() WHERE id = ?";
        return $this->db->query($sql, [
            $data['status'],
            $id
        ]);
    }

    public function getByUser($user_id)
    {
        $sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";
        return $this->db->fetchAll($sql, [$user_id]);
    }

    public function getAll($limit = null, $offset = 0)
    {
        $sql = "SELECT o.*, u.name as user_name, u.email as user_email 
                FROM orders o 
                LEFT JOIN users u ON o.user_id = u.id 
                ORDER BY o.created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT ? OFFSET ?";
            return $this->db->fetchAll($sql, [$limit, $offset]);
        }
        
        return $this->db->fetchAll($sql);
    }

    public function getOrderWithItems($order_id)
    {
        $order = $this->findById($order_id);
        if (!$order) {
            return null;
        }

        $orderItemModel = new \App\Models\OrderItem();
        $order['items'] = $orderItemModel->getByOrder($order_id);

        return $order;
    }

    public function getOrdersByStatus($status)
    {
        $sql = "SELECT o.*, u.name as user_name, u.email as user_email 
                FROM orders o 
                LEFT JOIN users u ON o.user_id = u.id 
                WHERE o.status = ? 
                ORDER BY o.created_at DESC";
        return $this->db->fetchAll($sql, [$status]);
    }
} 