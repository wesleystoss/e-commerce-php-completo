<?php

namespace App\Models;

use App\Config\Database;

class Product
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function create($data)
    {
        $sql = "INSERT INTO products (name, description, price, stock, category_id, image_url, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, NOW())";
        
        $this->db->query($sql, [
            $data['name'],
            $data['description'],
            $data['price'],
            $data['stock'],
            $data['category_id'],
            $data['image_url'] ?? null
        ]);

        return $this->db->lastInsertId();
    }

    public function findById($id)
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.id = ?";
        return $this->db->fetch($sql, [$id]);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE products SET name = ?, description = ?, price = ?, stock = ?, 
                category_id = ?, image_url = ?, updated_at = NOW() WHERE id = ?";
        
        return $this->db->query($sql, [
            $data['name'],
            $data['description'],
            $data['price'],
            $data['stock'],
            $data['category_id'],
            $data['image_url'] ?? null,
            $id
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM products WHERE id = ?";
        return $this->db->query($sql, [$id]);
    }

    public function getAll($limit = null, $offset = 0)
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                ORDER BY p.created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT ? OFFSET ?";
            return $this->db->fetchAll($sql, [$limit, $offset]);
        }
        
        return $this->db->fetchAll($sql);
    }

    public function search($query, $category_id = null, $min_price = null, $max_price = null)
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE 1=1";
        
        $params = [];
        
        if ($query) {
            $sql .= " AND (p.name LIKE ? OR p.description LIKE ?)";
            $params[] = "%{$query}%";
            $params[] = "%{$query}%";
        }
        
        if ($category_id) {
            $sql .= " AND p.category_id = ?";
            $params[] = $category_id;
        }
        
        if ($min_price !== null) {
            $sql .= " AND p.price >= ?";
            $params[] = $min_price;
        }
        
        if ($max_price !== null) {
            $sql .= " AND p.price <= ?";
            $params[] = $max_price;
        }
        
        $sql .= " ORDER BY p.name ASC";
        
        return $this->db->fetchAll($sql, $params);
    }

    public function updateStock($id, $quantity)
    {
        $sql = "UPDATE products SET stock = stock - ?, updated_at = NOW() WHERE id = ? AND stock >= ?";
        $stmt = $this->db->query($sql, [$quantity, $id, $quantity]);
        return $stmt->rowCount() > 0;
    }

    public function getByCategory($category_id)
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.category_id = ? 
                ORDER BY p.name ASC";
        return $this->db->fetchAll($sql, [$category_id]);
    }

    public function getLowStock($threshold = 10)
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.stock <= ? 
                ORDER BY p.stock ASC";
        return $this->db->fetchAll($sql, [$threshold]);
    }
} 