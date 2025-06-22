<?php

namespace App\Models;

use App\Config\Database;

class Category
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function create($data)
    {
        $sql = "INSERT INTO categories (name, description, created_at) VALUES (?, ?, NOW())";
        
        $this->db->query($sql, [
            $data['name'],
            $data['description'] ?? null
        ]);

        return $this->db->lastInsertId();
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM categories WHERE id = ?";
        return $this->db->fetch($sql, [$id]);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE categories SET name = ?, description = ?, updated_at = NOW() WHERE id = ?";
        return $this->db->query($sql, [
            $data['name'],
            $data['description'] ?? null,
            $id
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM categories WHERE id = ?";
        return $this->db->query($sql, [$id]);
    }

    public function getAll()
    {
        $sql = "SELECT * FROM categories ORDER BY name ASC";
        return $this->db->fetchAll($sql);
    }

    public function getWithProductCount()
    {
        $sql = "SELECT c.*, COUNT(p.id) as product_count 
                FROM categories c 
                LEFT JOIN products p ON c.id = p.category_id 
                GROUP BY c.id 
                ORDER BY c.name ASC";
        return $this->db->fetchAll($sql);
    }
} 