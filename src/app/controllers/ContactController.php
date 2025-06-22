<?php

namespace App\Controllers;

class ContactController
{
    public function index()
    {
        // Se for uma requisição POST, processar o formulário
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->handleFormSubmission();
        }
        
        // Para requisições GET, mostrar a página
        $this->showContactPage();
    }
    
    private function handleFormSubmission()
    {
        // Validar os dados do formulário
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $message = trim($_POST['message'] ?? '');
        
        $errors = [];
        
        // Validações
        if (empty($name)) {
            $errors[] = 'Nome é obrigatório';
        }
        
        if (empty($email)) {
            $errors[] = 'Email é obrigatório';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email inválido';
        }
        
        if (empty($message)) {
            $errors[] = 'Mensagem é obrigatória';
        } elseif (strlen($message) < 10) {
            $errors[] = 'Mensagem deve ter pelo menos 10 caracteres';
        }
        
        // Se há erros, mostrar a página com os erros
        if (!empty($errors)) {
            $_SESSION['error'] = implode(', ', $errors);
            $this->showContactPage();
            return;
        }
        
        // Simular envio bem-sucedido (não salva no banco)
        $_SESSION['success'] = 'Mensagem enviada com sucesso! Entraremos em contato em breve.';
        
        // Redirecionar para a página de contato
        header('Location: /contact');
        exit;
    }
    
    private function showContactPage()
    {
        // Incluir a página de contato independente
        require_once __DIR__ . '/../../views/contact/contact_page.php';
    }
} 