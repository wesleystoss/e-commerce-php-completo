<?php $pageTitle = e($category['name']); ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-8">
        <ol class="flex items-center space-x-2 text-sm">
            <li><a href="/" class="text-sophisticated-muted hover:text-sophisticated-primary transition-colors duration-200">Início</a></li>
            <li><i class="fas fa-chevron-right text-sophisticated-muted"></i></li>
            <li><a href="/products" class="text-sophisticated-muted hover:text-sophisticated-primary transition-colors duration-200">Produtos</a></li>
            <li><i class="fas fa-chevron-right text-sophisticated-muted"></i></li>
            <li class="text-sophisticated-dark font-medium"><?= e($category['name']) ?></li>
        </ol>
    </nav>
    
    <!-- Header -->
    <div class="mb-8 flex items-center space-x-4">
        <div class="w-16 h-16 <?= getCategoryColorClass($category['id']) ?> rounded-2xl flex items-center justify-center">
            <i class="fas fa-tag text-2xl"></i>
        </div>
        <div>
            <h1 class="text-3xl font-bold text-sophisticated-dark mb-1">Categoria: <?= e($category['name']) ?></h1>
            <p class="text-sophisticated-muted">Encontre os melhores produtos em <?= e($category['name']) ?></p>
        </div>
    </div>

    <?php if (empty($products)): ?>
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-sophisticated-light rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-box-open text-sophisticated-muted text-3xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-sophisticated-dark mb-2">Nenhum produto encontrado</h3>
            <p class="text-sophisticated-muted mb-8">Não há produtos disponíveis nesta categoria no momento.</p>
            <a href="/products" class="btn-primary px-8 py-4 rounded-full text-white font-semibold text-lg inline-flex items-center">
                <i class="fas fa-shopping-bag mr-2"></i>
                Ver todos os produtos
            </a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php foreach ($products as $product): ?>
            <div class="product-card bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col">
                <div class="relative">
                    <?php if ($product['image_url']): ?>
                        <img src="<?= e($product['image_url']) ?>" class="w-full h-48 object-cover" alt="<?= e($product['name']) ?>">
                    <?php else: ?>
                        <div class="w-full h-48 bg-gradient-to-br from-sophisticated-light to-sophisticated-border flex items-center justify-center">
                            <i class="fas fa-image text-sophisticated-muted text-3xl"></i>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Stock Badge -->
                    <div class="absolute top-3 right-3">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold <?= $product['stock'] > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                            <?= $product['stock'] > 0 ? 'Em estoque' : 'Indisponível' ?>
                        </span>
                    </div>
                </div>
                
                <div class="p-5 flex flex-col flex-grow">
                    <div class="flex-grow">
                        <h3 class="text-lg font-semibold text-sophisticated-dark mb-2 line-clamp-2 h-14"><?= e($product['name']) ?></h3>
                        <p class="text-sophisticated-muted text-sm mb-4 line-clamp-3 h-20"><?= e(substr($product['description'], 0, 100)) ?>...</p>
                    </div>

                    <div class="mt-auto">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xl font-bold text-sophisticated-dark"><?= formatPrice($product['price']) ?></span>
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
                            <a href="/product/<?= $product['id'] ?>" class="w-full py-2.5 px-4 border border-sophisticated-primary text-sophisticated-primary rounded-xl font-semibold hover:bg-sophisticated-primary hover:text-white transition-all duration-200 text-center block">
                                Ver Detalhes
                            </a>
                            <?php if ($product['stock'] > 0): ?>
                            <form action="/cart/add" method="POST">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="w-full btn-primary py-2.5 px-4 rounded-xl font-semibold text-white">
                                    <i class="fas fa-cart-plus mr-2"></i>Adicionar ao Carrinho
                                </button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?> 