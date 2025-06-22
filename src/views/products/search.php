<?php $pageTitle = 'Resultados da Busca'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Sidebar Filters -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-sophisticated-border sticky top-24">
                <div class="p-6 border-b border-sophisticated-border">
                    <h3 class="text-lg font-semibold text-sophisticated-dark">Filtros</h3>
                </div>
                <div class="p-6">
                    <form action="/search" method="GET" class="space-y-6">
                        <div>
                            <label for="search" class="block text-sm font-medium text-sophisticated-text mb-2">Buscar</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-sophisticated-muted"></i>
                                </div>
                                <input type="text" 
                                       id="search" 
                                       name="q" 
                                       value="<?= e($_GET['q'] ?? '') ?>" 
                                       placeholder="Nome do produto..."
                                       class="w-full pl-10 pr-4 py-3 border border-sophisticated-border rounded-xl focus:outline-none focus:ring-2 focus:ring-sophisticated-primary focus:border-transparent transition-all duration-200">
                            </div>
                        </div>
                        
                        <div>
                            <label for="category" class="block text-sm font-medium text-sophisticated-text mb-2">Categoria</label>
                            <select class="w-full px-4 py-3 border border-sophisticated-border rounded-xl focus:outline-none focus:ring-2 focus:ring-sophisticated-primary focus:border-transparent transition-all duration-200" 
                                    id="category" name="category">
                                <option value="">Todas as categorias</option>
                                <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>" <?= ($_GET['category'] ?? '') == $category['id'] ? 'selected' : '' ?>>
                                    <?= e($category['name']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div>
                            <label for="min_price" class="block text-sm font-medium text-sophisticated-text mb-2">Preço mínimo</label>
                            <input type="number" 
                                   id="min_price" 
                                   name="min_price" 
                                   value="<?= e($_GET['min_price'] ?? '') ?>" 
                                   step="0.01" 
                                   min="0"
                                   class="w-full px-4 py-3 border border-sophisticated-border rounded-xl focus:outline-none focus:ring-2 focus:ring-sophisticated-primary focus:border-transparent transition-all duration-200"
                                   placeholder="R$ 0,00">
                        </div>
                        
                        <div>
                            <label for="max_price" class="block text-sm font-medium text-sophisticated-text mb-2">Preço máximo</label>
                            <input type="number" 
                                   id="max_price" 
                                   name="max_price" 
                                   value="<?= e($_GET['max_price'] ?? '') ?>" 
                                   step="0.01" 
                                   min="0"
                                   class="w-full px-4 py-3 border border-sophisticated-border rounded-xl focus:outline-none focus:ring-2 focus:ring-sophisticated-primary focus:border-transparent transition-all duration-200"
                                   placeholder="R$ 999,99">
                        </div>
                        
                        <button type="submit" class="w-full btn-primary py-3 px-4 rounded-xl font-semibold text-white">
                            <i class="fas fa-search mr-2"></i>Filtrar
                        </button>
                    </form>
                    
                    <div class="mt-6 pt-6 border-t border-sophisticated-border">
                        <a href="/products" class="w-full py-3 px-4 border border-sophisticated-border text-sophisticated-text rounded-xl font-semibold hover:bg-sophisticated-gray transition-colors duration-200 text-center block">
                            <i class="fas fa-times mr-2"></i>Limpar Filtros
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Search Results -->
        <div class="lg:col-span-3">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-sophisticated-dark mb-2">
                        <i class="fas fa-search mr-3 text-sophisticated-primary"></i>
                        Resultados da Busca
                    </h1>
                    <?php if (!empty($_GET['q'])): ?>
                        <p class="text-sophisticated-muted">Resultados para "<span class="font-medium"><?= e($_GET['q']) ?></span>"</p>
                    <?php endif; ?>
                </div>
                <div class="flex items-center">
                    <span class="text-sophisticated-muted"><?= count($products) ?> produtos encontrados</span>
                </div>
            </div>
            
            <?php if (empty($products)): ?>
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-sophisticated-light rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-search text-sophisticated-muted text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-sophisticated-dark mb-2">Nenhum produto encontrado</h3>
                <p class="text-sophisticated-muted mb-4">
                    <?php if (!empty($_GET['q'])): ?>
                        Não encontramos produtos para "<span class="font-medium"><?= e($_GET['q']) ?></span>".
                    <?php else: ?>
                        Não encontramos produtos com os filtros aplicados.
                    <?php endif; ?>
                </p>
                <p class="text-sophisticated-muted mb-8">Tente ajustar os filtros ou buscar por outro termo.</p>
                <div class="space-x-4">
                    <a href="/products" class="btn-primary px-6 py-3 rounded-full text-white font-semibold">
                        Ver Todos os Produtos
                    </a>
                    <a href="/" class="px-6 py-3 border border-sophisticated-border text-sophisticated-text rounded-full font-semibold hover:bg-sophisticated-gray transition-colors duration-200">
                        Voltar ao Início
                    </a>
                </div>
            </div>
            <?php else: ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
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
                        
                        <!-- Category Badge -->
                        <div class="absolute top-3 left-3">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold <?= getCategoryColorClass($product['category_id']) ?>">
                                <?= e($product['category_name']) ?>
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
                            
                            <?php if ($product['stock'] > 0): ?>
                            <p class="text-sm text-sophisticated-muted mb-4"><?= $product['stock'] ?> unidades disponíveis</p>
                            <?php endif; ?>
                            
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
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
