<?php $pageTitle = 'Checkout'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>
<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-sophisticated-dark mb-2">Finalizar Compra</h1>
        <p class="text-sophisticated-muted">Complete suas informações para finalizar o pedido</p>
    </div>

    <form action="/cart/processCheckout" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8" id="checkout-form">
        <!-- Formulário Principal -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-sophisticated-border overflow-hidden">
                <div class="bg-sophisticated-gray px-6 py-4 border-b border-sophisticated-border">
                    <h2 class="text-xl font-semibold text-sophisticated-dark">Endereço de Entrega</h2>
                </div>
                <div class="p-6 space-y-6">
                    <div>
                        <label for="shipping_address" class="block text-sm font-medium text-sophisticated-dark mb-2">
                            Endereço Completo
                        </label>
                        <textarea 
                            name="shipping_address" 
                            id="shipping_address" 
                            class="w-full px-4 py-3 border border-sophisticated-border rounded-xl focus:outline-none focus:ring-2 focus:ring-sophisticated-primary focus:border-transparent transition-all duration-200 resize-none" 
                            rows="3" 
                            required
                            placeholder="Digite seu endereço completo..."
                        ><?= e($_POST['shipping_address'] ?? '') ?></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-sophisticated-dark mb-4">
                            Forma de Pagamento
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Boleto -->
                            <div class="payment-option cursor-pointer border-2 border-sophisticated-border rounded-xl p-4 transition-all duration-200 hover:border-sophisticated-primary hover:shadow-md" data-payment="boleto">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-barcode text-white text-lg"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-sophisticated-dark">Boleto</h4>
                                        <p class="text-sm text-sophisticated-muted">Pagamento via boleto bancário</p>
                                    </div>
                                    <div class="payment-check hidden">
                                        <i class="fas fa-check-circle text-green-500 text-xl"></i>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- PIX -->
                            <div class="payment-option cursor-pointer border-2 border-sophisticated-border rounded-xl p-4 transition-all duration-200 hover:border-sophisticated-primary hover:shadow-md" data-payment="pix">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-qrcode text-white text-lg"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-sophisticated-dark">PIX</h4>
                                        <p class="text-sm text-sophisticated-muted">Pagamento instantâneo</p>
                                    </div>
                                    <div class="payment-check hidden">
                                        <i class="fas fa-check-circle text-green-500 text-xl"></i>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Cartão -->
                            <div class="payment-option cursor-pointer border-2 border-sophisticated-border rounded-xl p-4 transition-all duration-200 hover:border-sophisticated-primary hover:shadow-md" data-payment="cartao">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-credit-card text-white text-lg"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-sophisticated-dark">Cartão</h4>
                                        <p class="text-sm text-sophisticated-muted">Cartão de crédito</p>
                                    </div>
                                    <div class="payment-check hidden">
                                        <i class="fas fa-check-circle text-green-500 text-xl"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="payment_method" id="payment_method" value="" required>
                    </div>
                    
                    <!-- Campos do Cartão de Crédito -->
                    <div id="credit-card-fields" class="hidden space-y-6 p-6 bg-sophisticated-gray/50 rounded-xl border border-sophisticated-border/50">
                        <h3 class="text-lg font-semibold text-sophisticated-dark mb-4">Dados do Cartão</h3>
                        
                        <div>
                            <label for="card_name" class="block text-sm font-medium text-sophisticated-dark mb-2">
                                Nome no Cartão
                            </label>
                            <input 
                                type="text" 
                                name="card_name" 
                                id="card_name" 
                                class="w-full px-4 py-3 border border-sophisticated-border rounded-xl focus:outline-none focus:ring-2 focus:ring-sophisticated-primary focus:border-transparent transition-all duration-200" 
                                placeholder="Nome como está no cartão"
                                value="<?= e($_POST['card_name'] ?? '') ?>"
                            >
                        </div>
                        
                        <div>
                            <label for="card_number" class="block text-sm font-medium text-sophisticated-dark mb-2">
                                Número do Cartão
                            </label>
                            <input 
                                type="text" 
                                name="card_number" 
                                id="card_number" 
                                class="w-full px-4 py-3 border border-sophisticated-border rounded-xl focus:outline-none focus:ring-2 focus:ring-sophisticated-primary focus:border-transparent transition-all duration-200" 
                                maxlength="19" 
                                placeholder="0000 0000 0000 0000"
                                value="<?= e($_POST['card_number'] ?? '') ?>"
                            >
                        </div>
                        
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label for="card_expiry" class="block text-sm font-medium text-sophisticated-dark mb-2">
                                    Validade (MM/AA)
                                </label>
                                <input 
                                    type="text" 
                                    name="card_expiry" 
                                    id="card_expiry" 
                                    class="w-full px-4 py-3 border border-sophisticated-border rounded-xl focus:outline-none focus:ring-2 focus:ring-sophisticated-primary focus:border-transparent transition-all duration-200" 
                                    maxlength="5" 
                                    placeholder="MM/AA"
                                    value="<?= e($_POST['card_expiry'] ?? '') ?>"
                                >
                            </div>
                            <div>
                                <label for="card_cvv" class="block text-sm font-medium text-sophisticated-dark mb-2">
                                    CVV
                                </label>
                                <input 
                                    type="text" 
                                    name="card_cvv" 
                                    id="card_cvv" 
                                    class="w-full px-4 py-3 border border-sophisticated-border rounded-xl focus:outline-none focus:ring-2 focus:ring-sophisticated-primary focus:border-transparent transition-all duration-200" 
                                    maxlength="4" 
                                    placeholder="123"
                                    value="<?= e($_POST['card_cvv'] ?? '') ?>"
                                >
                            </div>
                            <div>
                                <label for="installments" class="block text-sm font-medium text-sophisticated-dark mb-2">
                                    Parcelas
                                </label>
                                <select 
                                    name="installments" 
                                    id="installments" 
                                    class="w-full px-4 py-3 border border-sophisticated-border rounded-xl focus:outline-none focus:ring-2 focus:ring-sophisticated-primary focus:border-transparent transition-all duration-200 bg-white"
                                >
                                    <option value="1">1x sem juros</option>
                                    <option value="2">2x sem juros</option>
                                    <option value="3">3x sem juros</option>
                                    <option value="4">4x sem juros</option>
                                    <option value="5">5x sem juros</option>
                                    <option value="6">6x sem juros</option>
                                    <option value="7">7x com juros</option>
                                    <option value="8">8x com juros</option>
                                    <option value="9">9x com juros</option>
                                    <option value="10">10x com juros</option>
                                    <option value="11">11x com juros</option>
                                    <option value="12">12x com juros</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Resumo do Parcelamento -->
                        <div id="installment-summary" class="bg-white rounded-xl p-4 border border-sophisticated-border/50">
                            <h4 class="font-semibold text-sophisticated-dark mb-2">Resumo do Parcelamento</h4>
                            <div class="text-sm text-sophisticated-muted">
                                <div class="flex justify-between items-center">
                                    <span>Valor total:</span>
                                    <span class="font-medium text-sophisticated-dark"><?= formatPrice($total) ?></span>
                                </div>
                                <div class="flex justify-between items-center mt-1">
                                    <span>Número de parcelas:</span>
                                    <span class="font-medium text-sophisticated-dark" id="installment-count">1x</span>
                                </div>
                                <div class="flex justify-between items-center mt-1">
                                    <span>Valor da parcela:</span>
                                    <span class="font-medium text-sophisticated-dark" id="installment-value"><?= formatPrice($total) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Resumo do Pedido -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-sophisticated-border overflow-hidden sticky top-24">
                <div class="bg-sophisticated-gray px-6 py-4 border-b border-sophisticated-border">
                    <h2 class="text-xl font-semibold text-sophisticated-dark">Resumo do Pedido</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4 mb-6">
                        <?php foreach ($cartItems as $item): ?>
                        <div class="flex justify-between items-start py-3 border-b border-sophisticated-border/50 last:border-b-0">
                            <div class="flex-1">
                                <h4 class="font-medium text-sophisticated-dark"><?= e($item['name']) ?></h4>
                                <p class="text-sm text-sophisticated-muted">Quantidade: <?= $item['quantity'] ?></p>
                            </div>
                            <span class="font-semibold text-sophisticated-dark"><?= formatPrice($item['price'] * $item['quantity']) ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="border-t border-sophisticated-border pt-4 mb-6">
                        <div class="flex justify-between items-center text-lg font-bold text-sophisticated-dark">
                            <span>Total</span>
                            <span><?= formatPrice($total) ?></span>
                        </div>
                    </div>
                    
                    <button 
                        type="submit" 
                        class="w-full bg-gradient-to-r from-sophisticated-primary to-sophisticated-accent hover:from-sophisticated-accent hover:to-sophisticated-primary text-white font-semibold py-4 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 hover:shadow-lg"
                    >
                        <i class="fas fa-lock mr-2"></i>
                        Confirmar Pedido
                    </button>
                    
                    <p class="text-xs text-sophisticated-muted text-center mt-4">
                        <i class="fas fa-shield-alt mr-1"></i>
                        Pagamento seguro e criptografado
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Seleção de forma de pagamento
    document.querySelectorAll('.payment-option').forEach(option => {
        option.addEventListener('click', function() {
            const paymentMethod = this.dataset.payment;
            
            // Remover seleção anterior
            document.querySelectorAll('.payment-option').forEach(opt => {
                opt.classList.remove('border-sophisticated-primary', 'bg-sophisticated-primary/5');
                opt.classList.add('border-sophisticated-border');
                opt.querySelector('.payment-check').classList.add('hidden');
            });
            
            // Selecionar opção atual
            this.classList.remove('border-sophisticated-border');
            this.classList.add('border-sophisticated-primary', 'bg-sophisticated-primary/5');
            this.querySelector('.payment-check').classList.remove('hidden');
            
            // Atualizar campo hidden
            document.getElementById('payment_method').value = paymentMethod;
            
            // Mostrar/ocultar campos do cartão
            toggleCardFields();
        });
    });
    
    function toggleCardFields() {
        var payment = document.getElementById('payment_method').value;
        var cardFields = document.getElementById('credit-card-fields');
        
        if (payment === 'cartao') {
            cardFields.classList.remove('hidden');
            cardFields.classList.add('block');
        } else {
            cardFields.classList.add('hidden');
            cardFields.classList.remove('block');
        }
    }
    
    // Formatar número do cartão
    document.getElementById('card_number').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
        e.target.value = value;
    });
    
    // Formatar data de validade
    document.getElementById('card_expiry').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 2) {
            value = value.substring(0, 2) + '/' + value.substring(2, 4);
        }
        e.target.value = value;
    });
    
    // Formatar CVV
    document.getElementById('card_cvv').addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/\D/g, '');
    });
    
    // Calcular parcelas
    function updateInstallmentSummary() {
        const total = <?= $total ?>; // Valor total do PHP
        const installments = parseInt(document.getElementById('installments').value);
        const installmentCount = document.getElementById('installment-count');
        const installmentValue = document.getElementById('installment-value');
        
        let installmentAmount = total;
        let installmentText = `${installments}x`;
        
        // Aplicar juros para parcelas acima de 6x (taxa de 2.99% ao mês)
        if (installments > 6) {
            const interestRate = 0.0299; // 2.99% ao mês
            const totalWithInterest = total * Math.pow(1 + interestRate, installments);
            installmentAmount = totalWithInterest / installments;
            installmentText = `${installments}x com juros`;
        } else {
            installmentAmount = total / installments;
            installmentText = `${installments}x sem juros`;
        }
        
        installmentCount.textContent = installmentText;
        installmentValue.textContent = formatCurrency(installmentAmount);
    }
    
    // Função para formatar moeda
    function formatCurrency(value) {
        return 'R$ ' + value.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }
    
    // Event listener para mudança de parcelas
    document.getElementById('installments').addEventListener('change', updateInstallmentSummary);
    
    // Inicializar campos do cartão
    window.addEventListener('DOMContentLoaded', function() {
        toggleCardFields();
        
        // Se houver valor pré-selecionado (ex: após erro de validação)
        const savedPayment = '<?= e($_POST['payment_method'] ?? '') ?>';
        if (savedPayment) {
            const option = document.querySelector(`[data-payment="${savedPayment}"]`);
            if (option) {
                option.click();
            }
        }
        
        // Inicializar resumo de parcelas
        updateInstallmentSummary();
    });
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?> 