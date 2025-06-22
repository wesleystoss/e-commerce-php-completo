<?php

namespace App\Controllers;

use App\Models\Newsletter;

class NewsletterController
{
    public function subscribe()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $name = $_POST['name'] ?? null;

            // Debug: Log dos dados recebidos
            error_log("Newsletter subscribe - Email: $email, Phone: $phone, Name: $name");

            $newsletter = new Newsletter();
            $result = $newsletter->subscribe($email, $phone, $name);

            // Debug: Log do resultado
            error_log("Newsletter result: " . json_encode($result));

            // Retornar JSON em vez de redirecionar
            header('Content-Type: application/json');
            echo json_encode($result);
            exit;
        }
        
        // Se não for POST, retornar erro
        header('Content-Type: application/json');
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Método não permitido']);
        exit;
    }
} 