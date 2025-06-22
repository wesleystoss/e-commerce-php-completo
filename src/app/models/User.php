<?php

namespace App\Models;

use App\Config\Database;

class User
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function create($data)
    {
        $sql = "INSERT INTO users (name, email, password, created_at) VALUES (?, ?, ?, NOW())";
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        
        $this->db->query($sql, [
            $data['name'],
            $data['email'],
            $hashedPassword
        ]);

        return $this->db->lastInsertId();
    }

    public function findByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        return $this->db->fetch($sql, [$email]);
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        return $this->db->fetch($sql, [$id]);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE users SET name = ?, email = ?, updated_at = NOW() WHERE id = ?";
        return $this->db->query($sql, [
            $data['name'],
            $data['email'],
            $id
        ]);
    }

    public function authenticate($email, $password)
    {
        $user = $this->findByEmail($email);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }

    public function getAll()
    {
        $sql = "SELECT id, name, email, created_at FROM users ORDER BY created_at DESC";
        return $this->db->fetchAll($sql);
    }
} 