<?php

namespace App\Controllers;

use App\Services\CartService;

class CartController
{
    private $cartService;

    public function __construct()
    {
        $this->cartService = new CartService();
    }

    public function index()
    {
        $cartItems = $this->cartService->getItems();
        $total = $this->cartService->getTotal();
        
        require_once __DIR__ . '/../../views/cart/index.php';
    }

    public function addToCart()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /products');
            exit;
        }

        $product_id = $_POST['product_id'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;

        if (!$product_id) {
            $_SESSION['error'] = 'Produto não especificado.';
            header('Location: /products');
            exit;
        }

        if ($this->cartService->add($product_id, $quantity)) {
            $_SESSION['success'] = 'Produto adicionado ao carrinho!';
        } else {
            $_SESSION['error'] = 'Erro ao adicionar produto ao carrinho.';
        }

        header('Location: /cart');
        exit;
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /cart');
            exit;
        }

        $product_id = $_POST['product_id'] ?? null;
        $quantity = $_POST['quantity'] ?? 0;

        if (!$product_id) {
            $_SESSION['error'] = 'Produto não especificado.';
            header('Location: /cart');
            exit;
        }

        if ($this->cartService->update($product_id, $quantity)) {
            $_SESSION['success'] = 'Carrinho atualizado!';
        } else {
            $_SESSION['error'] = 'Erro ao atualizar carrinho.';
        }

        header('Location: /cart');
        exit;
    }

    public function remove()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /cart');
            exit;
        }

        $product_id = $_POST['product_id'] ?? null;

        if (!$product_id) {
            $_SESSION['error'] = 'Produto não especificado.';
            header('Location: /cart');
            exit;
        }

        if ($this->cartService->remove($product_id)) {
            $_SESSION['success'] = 'Produto removido do carrinho!';
        } else {
            $_SESSION['error'] = 'Erro ao remover produto.';
        }

        header('Location: /cart');
        exit;
    }

    public function clear()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /cart');
            exit;
        }

        $this->cartService->clear();
        $_SESSION['success'] = 'Carrinho limpo!';
        
        header('Location: /cart');
        exit;
    }

    public function checkout()
    {
        if ($this->cartService->isEmpty()) {
            $_SESSION['error'] = 'Seu carrinho está vazio.';
            header('Location: /cart');
            exit;
        }

        // Validar estoque
        $errors = $this->cartService->validateStock();
        if (!empty($errors)) {
            $_SESSION['error'] = implode('<br>', $errors);
            header('Location: /cart');
            exit;
        }

        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Você precisa estar logado para finalizar a compra.';
            header('Location: /login');
            exit;
        }

        $cartItems = $this->cartService->getItems();
        $total = $this->cartService->getTotal();
        
        require_once __DIR__ . '/../../views/cart/checkout.php';
    }

    public function processCheckout()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /cart');
            exit;
        }

        if ($this->cartService->isEmpty()) {
            $_SESSION['error'] = 'Seu carrinho está vazio.';
            header('Location: /cart');
            exit;
        }

        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Você precisa estar logado para finalizar a compra.';
            header('Location: /login');
            exit;
        }

        // Validar estoque novamente
        $errors = $this->cartService->validateStock();
        if (!empty($errors)) {
            $_SESSION['error'] = implode('<br>', $errors);
            header('Location: /cart');
            exit;
        }

        $shipping_address = $_POST['shipping_address'] ?? '';
        if (empty($shipping_address)) {
            $_SESSION['error'] = 'Endereço de entrega é obrigatório.';
            header('Location: /cart/checkout');
            exit;
        }

        $payment_method = $_POST['payment_method'] ?? '';
        if (!in_array($payment_method, ['boleto', 'pix', 'cartao'])) {
            $_SESSION['error'] = 'Escolha uma forma de pagamento válida.';
            header('Location: /cart/checkout');
            exit;
        }

        // Se for cartão, validar campos
        if ($payment_method === 'cartao') {
            $card_name = trim($_POST['card_name'] ?? '');
            $card_number = trim($_POST['card_number'] ?? '');
            $card_expiry = trim($_POST['card_expiry'] ?? '');
            $card_cvv = trim($_POST['card_cvv'] ?? '');
            $installments = (int)($_POST['installments'] ?? 1);
            
            if (empty($card_name) || empty($card_number) || empty($card_expiry) || empty($card_cvv)) {
                $_SESSION['error'] = 'Preencha todos os dados do cartão.';
                header('Location: /cart/checkout');
                exit;
            }
            
            // Validar número de parcelas
            if ($installments < 1 || $installments > 12) {
                $_SESSION['error'] = 'Número de parcelas inválido.';
                header('Location: /cart/checkout');
                exit;
            }
            
            // Calcular valor total com juros se necessário
            $total = $this->cartService->getTotal();
            if ($installments > 6) {
                $interestRate = 0.0299; // 2.99% ao mês
                $total = $total * pow(1 + $interestRate, $installments);
            }
        }

        try {
            $orderModel = new \App\Models\Order();
            $orderItemModel = new \App\Models\OrderItem();
            $productModel = new \App\Models\Product();

            $cartItems = $this->cartService->getItems();
            $total = $this->cartService->getTotal();

            // Criar pedido
            $orderData = [
                'user_id' => $_SESSION['user_id'],
                'total_amount' => $total,
                'status' => 'pending',
                'shipping_address' => $shipping_address,
                'payment_method' => $payment_method
            ];

            $order_id = $orderModel->create($orderData);

            if (!$order_id) {
                throw new \Exception('Erro ao criar pedido.');
            }

            // Criar itens do pedido e atualizar estoque
            foreach ($cartItems as $item) {
                $orderItemModel->create([
                    'order_id' => $order_id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);

                // Atualizar estoque
                $productModel->updateStock($item['product_id'], $item['quantity']);
            }

            // Limpar carrinho
            $this->cartService->clear();

            // Mensagem personalizada
            if ($payment_method === 'boleto') {
                $_SESSION['success'] = 'Pedido realizado! Número do pedido: #' . $order_id . '<br>Use o boleto gerado para pagamento.';
            } elseif ($payment_method === 'pix') {
                $_SESSION['success'] = 'Pedido realizado! Número do pedido: #' . $order_id . '<br>Use o QR Code do Pix para pagamento.';
            } else {
                $installmentText = $installments > 6 ? " em {$installments}x com juros" : " em {$installments}x sem juros";
                $_SESSION['success'] = 'Pedido realizado! Número do pedido: #' . $order_id . '<br>Pagamento com cartão de crédito aprovado' . $installmentText . '!';
            }
            header('Location: /orders/' . $order_id);

        } catch (\Exception $e) {
            $_SESSION['error'] = 'Erro ao processar pedido: ' . $e->getMessage();
            header('Location: /cart/checkout');
        }
        exit;
    }
} 