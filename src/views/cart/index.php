<?php $pageTitle = 'Carrinho de Compras'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-apple-dark mb-2">Carrinho de Compras</h1>
        <p class="text-gray-600">Revise seus itens antes de finalizar a compra</p>
    </div>

    <?php if (empty($cartItems)): ?>
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-shopping-cart text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Seu carrinho está vazio</h3>
            <p class="text-gray-600 mb-8">Adicione alguns produtos para começar suas compras</p>
            <a href="/products" class="btn-primary px-8 py-4 rounded-full text-white font-semibold text-lg inline-flex items-center">
                <i class="fas fa-shopping-bag mr-2"></i>
                Explorar Produtos
            </a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h2 class="text-xl font-semibold text-apple-dark">Itens do Carrinho (<?= count($cartItems) ?>)</h2>
                    </div>
                    
                    <div class="divide-y divide-gray-100">
                        <?php foreach ($cartItems as $item): ?>
                        <div class="p-6">
                            <div class="flex items-center space-x-4">
                                <!-- Product Image -->
                                <div class="flex-shrink-0">
                                    <?php if ($item['image_url']): ?>
                                        <img src="<?= e($item['image_url']) ?>" 
                                             alt="<?= e($item['name']) ?>" 
                                             class="w-20 h-20 object-cover rounded-xl">
                                    <?php else: ?>
                                        <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Product Details -->
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-semibold text-apple-dark mb-1"><?= e($item['name']) ?></h3>
                                    <p class="text-gray-600 text-sm mb-2"><?= e($item['category_name'] ?? 'Sem categoria') ?></p>
                                    <div class="text-xl font-bold text-apple-dark"><?= formatPrice($item['price']) ?></div>
                                </div>
                                
                                <!-- Quantity Controls -->
                                <div class="flex items-center space-x-3">
                                    <form action="/cart/update" method="POST" class="flex items-center border border-gray-200 rounded-xl overflow-hidden">
                                        <button type="button" class="px-3 py-2 text-gray-600 hover:bg-gray-100 transition-colors duration-200" 
                                                onclick="updateQuantity(<?= $item['product_id'] ?>, -1)">
                                            <i class="fas fa-minus text-sm"></i>
                                        </button>
                                        <input type="number" 
                                               name="quantity" 
                                               value="<?= $item['quantity'] ?>" 
                                               min="1" 
                                               class="w-16 text-center border-0 focus:outline-none focus:ring-0 bg-transparent"
                                               onchange="updateQuantity(<?= $item['product_id'] ?>, 0, this.value)">
                                        <button type="button" class="px-3 py-2 text-gray-600 hover:bg-gray-100 transition-colors duration-200"
                                                onclick="updateQuantity(<?= $item['product_id'] ?>, 1)">
                                            <i class="fas fa-plus text-sm"></i>
                                        </button>
                                        <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                    </form>
                                    
                                    <!-- Remove Button -->
                                    <form action="/cart/remove" method="POST" class="inline">
                                        <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                        <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors duration-200">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                
                                <!-- Subtotal -->
                                <div class="text-right">
                                    <div class="text-lg font-bold text-apple-dark"><?= formatPrice($item['price'] * $item['quantity']) ?></div>
                                    <div class="text-sm text-gray-500"><?= $item['quantity'] ?> unidade<?= $item['quantity'] > 1 ? 's' : '' ?></div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Clear Cart -->
                    <div class="p-6 border-t border-gray-100">
                        <form action="/cart/clear" method="POST">
                            <button type="submit" class="text-red-600 hover:text-red-700 font-medium transition-colors duration-200">
                                <i class="fas fa-trash mr-2"></i>
                                Limpar Carrinho
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 sticky top-24">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-apple-dark">Resumo do Pedido</h3>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Subtotal:</span>
                            <span class="font-medium text-apple-dark"><?= formatPrice($total) ?></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Frete:</span>
                            <span class="font-medium text-green-600">Grátis</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Taxas:</span>
                            <span class="font-medium text-apple-dark">R$ 0,00</span>
                        </div>
                        
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold text-apple-dark">Total:</span>
                                <span class="text-2xl font-bold text-apple-dark"><?= formatPrice($total) ?></span>
                            </div>
                        </div>
                        
                        <form action="/cart/checkout" method="GET" class="pt-4">
                            <button type="submit" class="w-full btn-primary py-4 px-6 rounded-xl font-semibold text-white text-lg">
                                <i class="fas fa-credit-card mr-2"></i>
                                Finalizar Compra
                            </button>
                        </form>
                        
                        <div class="text-center">
                            <a href="/products" class="text-apple-blue hover:text-apple-blue-hover font-medium transition-colors duration-200">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Continuar Comprando
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Security Info -->
                <div class="mt-6 bg-green-50 border border-green-200 rounded-xl p-4">
                    <div class="flex items-start">
                        <i class="fas fa-shield-alt text-green-500 mt-1 mr-3"></i>
                        <div>
                            <h4 class="font-semibold text-green-800 mb-1">Compra Segura</h4>
                            <p class="text-sm text-green-700">Seus dados estão protegidos com criptografia SSL de 256 bits.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
function updateQuantity(productId, change, newValue = null) {
    const form = document.querySelector(`form[action="/cart/update"]`);
    const quantityInput = form.querySelector(`input[name="quantity"]`);
    const productIdInput = form.querySelector(`input[name="product_id"]`);
    
    if (newValue !== null) {
        quantityInput.value = newValue;
    } else {
        quantityInput.value = Math.max(1, parseInt(quantityInput.value) + change);
    }
    
    productIdInput.value = productId;
    form.submit();
}
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?> 