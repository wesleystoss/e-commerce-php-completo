<?php $pageTitle = $product['name']; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-8">
        <ol class="flex items-center space-x-2 text-sm">
            <li><a href="/" class="text-sophisticated-muted hover:text-sophisticated-primary transition-colors duration-200">Início</a></li>
            <li><i class="fas fa-chevron-right text-sophisticated-muted"></i></li>
            <li><a href="/products" class="text-sophisticated-muted hover:text-sophisticated-primary transition-colors duration-200">Produtos</a></li>
            <li><i class="fas fa-chevron-right text-sophisticated-muted"></i></li>
            <li><a href="/category/<?= $product['category_id'] ?>" class="text-sophisticated-muted hover:text-sophisticated-primary transition-colors duration-200"><?= e($product['category_name']) ?></a></li>
            <li><i class="fas fa-chevron-right text-sophisticated-muted"></i></li>
            <li class="text-sophisticated-dark font-medium"><?= e($product['name']) ?></li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Product Images -->
        <div class="space-y-6">
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-sophisticated-border">
                <?php if ($product['image_url']): ?>
                    <img src="<?= e($product['image_url']) ?>" 
                         alt="<?= e($product['name']) ?>" 
                         class="w-full h-96 object-cover">
                <?php else: ?>
                    <div class="w-full h-96 bg-gradient-to-br from-sophisticated-light to-sophisticated-border flex items-center justify-center">
                        <i class="fas fa-image text-sophisticated-muted text-6xl"></i>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Additional Images Placeholder -->
            <div class="grid grid-cols-4 gap-4">
                <?php for ($i = 0; $i < 4; $i++): ?>
                <div class="bg-sophisticated-light rounded-xl h-20 flex items-center justify-center">
                    <i class="fas fa-image text-sophisticated-muted"></i>
                </div>
                <?php endfor; ?>
            </div>
        </div>
        
        <!-- Product Info -->
        <div class="space-y-8">
            <!-- Product Header -->
            <div>
                <div class="flex items-center space-x-3 mb-4">
                    <span class="px-3 py-1 bg-sophisticated-primary/10 text-sophisticated-primary rounded-full text-sm font-semibold">
                        <?= e($product['category_name']) ?>
                    </span>
                    <span class="px-3 py-1 <?= $product['stock'] > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?> rounded-full text-sm font-semibold">
                        <?= $product['stock'] > 0 ? 'Em estoque' : 'Indisponível' ?>
                    </span>
                </div>
                
                <h1 class="text-3xl font-bold text-sophisticated-dark mb-4"><?= e($product['name']) ?></h1>
                
                <div class="flex items-center space-x-4 mb-6">
                    <div class="flex items-center text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <span class="text-sophisticated-muted ml-2">(4.8 - 127 avaliações)</span>
                    </div>
                </div>
                
                <div class="text-4xl font-bold text-sophisticated-dark mb-6">
                    <?= formatPrice($product['price']) ?>
                </div>
                
                <?php if ($product['stock'] > 0): ?>
                <p class="text-green-600 font-medium mb-6">
                    <i class="fas fa-check-circle mr-2"></i>
                    <?= $product['stock'] ?> unidades disponíveis
                </p>
                <?php endif; ?>
            </div>
            
            <!-- Product Description -->
            <div>
                <h3 class="text-lg font-semibold text-sophisticated-dark mb-4">Descrição</h3>
                <p class="text-sophisticated-muted leading-relaxed">
                    <?= nl2br(e($product['description'])) ?>
                </p>
            </div>
            
            <!-- Add to Cart -->
            <?php if ($product['stock'] > 0): ?>
            <div class="bg-sophisticated-gray rounded-2xl p-6">
                <form action="/cart/add" method="POST" class="space-y-4">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-sophisticated-text mb-2">Quantidade</label>
                        <div class="flex items-center space-x-3">
                            <button type="button" onclick="updateQuantity(-1)" class="w-10 h-10 border border-sophisticated-border rounded-lg flex items-center justify-center text-sophisticated-muted hover:bg-white transition-colors duration-200">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" 
                                   id="quantity" 
                                   name="quantity" 
                                   value="1" 
                                   min="1" 
                                   max="<?= $product['stock'] ?>"
                                   class="w-20 text-center border border-sophisticated-border rounded-lg py-2 focus:outline-none focus:ring-2 focus:ring-sophisticated-primary">
                            <button type="button" onclick="updateQuantity(1)" class="w-10 h-10 border border-sophisticated-border rounded-lg flex items-center justify-center text-sophisticated-muted hover:bg-white transition-colors duration-200">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full btn-primary py-4 px-6 rounded-xl font-semibold text-white text-lg">
                        <i class="fas fa-cart-plus mr-2"></i>
                        Adicionar ao Carrinho
                    </button>
                </form>
            </div>
            <?php else: ?>
            <div class="bg-red-50 border border-red-200 rounded-2xl p-6">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                    <div>
                        <h4 class="font-semibold text-red-800">Produto Indisponível</h4>
                        <p class="text-red-700 text-sm">Este produto está temporariamente fora de estoque.</p>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Product Features -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-sophisticated-dark">Características</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-shipping-fast text-sophisticated-primary"></i>
                        <span class="text-sophisticated-muted">Entrega gratuita</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-shield-alt text-sophisticated-primary"></i>
                        <span class="text-sophisticated-muted">Garantia de 1 ano</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-undo text-sophisticated-primary"></i>
                        <span class="text-sophisticated-muted">Devolução em 30 dias</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-headset text-sophisticated-primary"></i>
                        <span class="text-sophisticated-muted">Suporte 24/7</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    <?php if (!empty($relatedProducts)): ?>
    <section class="mt-20">
        <div class="mb-12">
            <h2 class="text-3xl font-bold text-sophisticated-dark mb-4">Produtos Relacionados</h2>
            <p class="text-sophisticated-muted">Você também pode gostar destes produtos</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($relatedProducts as $relatedProduct): ?>
            <div class="product-card bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col">
                <div class="relative">
                    <?php if ($relatedProduct['image_url']): ?>
                        <img src="<?= e($relatedProduct['image_url']) ?>" class="w-full h-48 object-cover" alt="<?= e($relatedProduct['name']) ?>">
                    <?php else: ?>
                        <div class="w-full h-48 bg-gradient-to-br from-sophisticated-light to-sophisticated-border flex items-center justify-center">
                            <i class="fas fa-image text-sophisticated-muted text-3xl"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold <?= getCategoryColorClass($relatedProduct['category_id']) ?>">
                            <?= e($relatedProduct['category_name']) ?>
                        </span>
                    </div>

                    <!-- Stock Badge -->
                    <div class="absolute top-3 right-3">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold <?= $relatedProduct['stock'] > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                            <?= $relatedProduct['stock'] > 0 ? 'Em estoque' : 'Indisponível' ?>
                        </span>
                    </div>
                </div>
                
                <div class="p-5 flex flex-col flex-grow">
                    <div class="flex-grow">
                        <h3 class="text-lg font-semibold text-sophisticated-dark mb-2 line-clamp-2 h-14"><?= e($relatedProduct['name']) ?></h3>
                        <p class="text-sophisticated-muted text-sm mb-4 line-clamp-3 h-20"><?= e(substr($relatedProduct['description'], 0, 100)) ?>...</p>
                    </div>

                    <div class="mt-auto">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xl font-bold text-sophisticated-dark"><?= formatPrice($relatedProduct['price']) ?></span>
                            <div class="flex items-center text-yellow-400">
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <span class="text-sophisticated-muted text-sm ml-1">(4.8)</span>
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            <a href="/product/<?= $relatedProduct['id'] ?>" class="w-full py-2.5 px-4 border border-sophisticated-primary text-sophisticated-primary rounded-xl font-semibold hover:bg-sophisticated-primary hover:text-white transition-all duration-200 text-center block">
                                Ver Detalhes
                            </a>
                            <?php if ($relatedProduct['stock'] > 0): ?>
                            <form action="/cart/add" method="POST">
                                <input type="hidden" name="product_id" value="<?= $relatedProduct['id'] ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="w-full btn-primary py-2.5 px-4 rounded-xl font-semibold text-white">
                                    <i class="fas fa-cart-plus mr-2"></i>Adicionar
                                </button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>
</div>

<script>
function updateQuantity(change) {
    const input = document.getElementById('quantity');
    const currentValue = parseInt(input.value);
    const newValue = Math.max(1, Math.min(<?= $product['stock'] ?>, currentValue + change));
    input.value = newValue;
}
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?> 