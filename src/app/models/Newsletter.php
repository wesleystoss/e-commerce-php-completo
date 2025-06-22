<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class Newsletter
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Inscreve um email na newsletter
     */
    public function subscribe($email, $phone, $name = null)
    {
        try {
            // Debug: Log dos dados recebidos
            error_log("Newsletter Model - Email: $email, Phone: $phone, Name: $name");

            // Verifica se o email já está inscrito
            if ($this->isSubscribed($email)) {
                error_log("Newsletter Model - Email já inscrito: $email");
                return ['success' => false, 'message' => 'Este email já está inscrito na newsletter.'];
            }

            // Valida o email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                error_log("Newsletter Model - Email inválido: $email");
                return ['success' => false, 'message' => 'Por favor, insira um email válido.'];
            }

            // Valida o telefone (simples, pode ser melhorado)
            $phoneDigits = preg_replace('/\D/', '', $phone);
            if (empty($phone) || strlen($phoneDigits) < 10) {
                error_log("Newsletter Model - Telefone inválido: $phone (digits: $phoneDigits)");
                return ['success' => false, 'message' => 'Por favor, insira um número de WhatsApp válido.'];
            }

            $sql = "INSERT INTO newsletter_subscribers (email, phone, name, subscribed_at, status) VALUES (?, ?, ?, NOW(), 'active')";
            error_log("Newsletter Model - Executando SQL: $sql");
            
            $this->db->query($sql, [$email, $phone, $name]);
            
            error_log("Newsletter Model - Inscrição realizada com sucesso para: $email");
            return ['success' => true, 'message' => 'Inscrição realizada com sucesso! Você receberá nossas novidades em breve.'];
        } catch (\Exception $e) {
            error_log("Newsletter Model - Erro na inscrição: " . $e->getMessage());
            return ['success' => false, 'message' => 'Erro ao processar inscrição. Tente novamente.'];
        }
    }

    /**
     * Verifica se um email já está inscrito
     */
    public function isSubscribed($email)
    {
        $sql = "SELECT id FROM newsletter_subscribers WHERE email = ? AND status = 'active'";
        $result = $this->db->fetch($sql, [$email]);
        return $result !== false;
    }

    /**
     * Cancela inscrição de um email
     */
    public function unsubscribe($email)
    {
        try {
            $sql = "UPDATE newsletter_subscribers SET status = 'unsubscribed', unsubscribed_at = NOW() WHERE email = ?";
            $this->db->query($sql, [$email]);
            
            return ['success' => true, 'message' => 'Inscrição cancelada com sucesso.'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Erro ao cancelar inscrição.'];
        }
    }

    /**
     * Lista todos os inscritos ativos
     */
    public function getAllActiveSubscribers()
    {
        $sql = "SELECT id, email, name, subscribed_at FROM newsletter_subscribers WHERE status = 'active' ORDER BY subscribed_at DESC";
        return $this->db->fetchAll($sql);
    }

    /**
     * Obtém estatísticas da newsletter
     */
    public function getStats()
    {
        $stats = [];
        
        // Total de inscritos ativos
        $sql = "SELECT COUNT(*) as total FROM newsletter_subscribers WHERE status = 'active'";
        $result = $this->db->fetch($sql);
        $stats['active_subscribers'] = $result['total'];

        // Total de inscritos cancelados
        $sql = "SELECT COUNT(*) as total FROM newsletter_subscribers WHERE status = 'unsubscribed'";
        $result = $this->db->fetch($sql);
        $stats['unsubscribed'] = $result['total'];

        // Inscrições do mês atual
        $sql = "SELECT COUNT(*) as total FROM newsletter_subscribers WHERE status = 'active' AND MONTH(subscribed_at) = MONTH(NOW()) AND YEAR(subscribed_at) = YEAR(NOW())";
        $result = $this->db->fetch($sql);
        $stats['this_month'] = $result['total'];

        return $stats;
    }

    /**
     * Cria a tabela newsletter_subscribers se não existir
     */
    public function createTable()
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS newsletter_subscribers (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL UNIQUE,
            phone VARCHAR(30) NOT NULL,
            name VARCHAR(255) NULL,
            subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            unsubscribed_at TIMESTAMP NULL,
            status ENUM('active', 'unsubscribed') DEFAULT 'active',
            INDEX idx_email (email),
            INDEX idx_phone (phone),
            INDEX idx_status (status),
            INDEX idx_subscribed_at (subscribed_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";

        try {
            $this->db->query($sql);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
} 