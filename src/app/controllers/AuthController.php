<?php

namespace App\Controllers;

use App\Models\User;

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $_SESSION['error'] = 'Email e senha são obrigatórios.';
                require_once __DIR__ . '/../../views/auth/login.php';
                return;
            }

            $user = $this->userModel->authenticate($email, $password);

            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['is_admin'] = $user['is_admin'] ?? false;

                $_SESSION['success'] = 'Login realizado com sucesso!';
                header('Location: /');
            } else {
                $_SESSION['error'] = 'Email ou senha incorretos.';
            }
        }

        require_once __DIR__ . '/../../views/auth/login.php';
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            // Validações
            if (empty($name) || empty($email) || empty($password)) {
                $_SESSION['error'] = 'Todos os campos são obrigatórios.';
                require_once __DIR__ . '/../../views/auth/register.php';
                return;
            }

            if ($password !== $confirm_password) {
                $_SESSION['error'] = 'As senhas não coincidem.';
                require_once __DIR__ . '/../../views/auth/register.php';
                return;
            }

            if (strlen($password) < 6) {
                $_SESSION['error'] = 'A senha deve ter pelo menos 6 caracteres.';
                require_once __DIR__ . '/../../views/auth/register.php';
                return;
            }

            // Verificar se email já existe
            $existingUser = $this->userModel->findByEmail($email);
            if ($existingUser) {
                $_SESSION['error'] = 'Este email já está cadastrado.';
                require_once __DIR__ . '/../../views/auth/register.php';
                return;
            }

            // Criar usuário
            $userData = [
                'name' => $name,
                'email' => $email,
                'password' => $password
            ];

            $user_id = $this->userModel->create($userData);

            if ($user_id) {
                $_SESSION['success'] = 'Conta criada com sucesso! Faça login para continuar.';
                header('Location: /login');
            } else {
                $_SESSION['error'] = 'Erro ao criar conta.';
            }
            exit;
        }

        require_once __DIR__ . '/../../views/auth/register.php';
    }

    public function logout()
    {
        session_destroy();
        header('Location: /');
        exit;
    }

    public function profile()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $user = $this->userModel->findById($_SESSION['user_id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';

            if (empty($name) || empty($email)) {
                $_SESSION['error'] = 'Nome e email são obrigatórios.';
            } else {
                $updateData = [
                    'name' => $name,
                    'email' => $email
                ];

                if ($this->userModel->update($_SESSION['user_id'], $updateData)) {
                    $_SESSION['user_name'] = $name;
                    $_SESSION['user_email'] = $email;
                    $_SESSION['success'] = 'Perfil atualizado com sucesso!';
                } else {
                    $_SESSION['error'] = 'Erro ao atualizar perfil.';
                }
            }
        }

        require_once __DIR__ . '/../../views/auth/profile.php';
    }
} 