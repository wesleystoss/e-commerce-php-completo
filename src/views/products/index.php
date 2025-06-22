<?php $pageTitle = 'Produtos'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-sophisticated-dark mb-2">Nossos Produtos</h1>
        <p class="text-sophisticated-muted">Descubra nossa coleção completa de produtos de tecnologia</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Filters Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-sophisticated-border sticky top-24">
                <div class="p-6 border-b border-sophisticated-border">
                    <h3 class="text-lg font-semibold text-sophisticated-dark">Filtros</h3>
                </div>
                <div class="p-6">
                    <form action="/products" method="GET" class="space-y-6">
                        <!-- Search -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-sophisticated-text mb-2">Buscar</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-sophisticated-muted"></i>
                                </div>
                                <input type="text" 
                                       id="search" 
                                       name="search" 
                                       value="<?= e($_GET['search'] ?? '') ?>" 
                                       placeholder="Nome do produto..."
                                       class="w-full pl-10 pr-4 py-3 border border-sophisticated-border rounded-xl focus:outline-none focus:ring-2 focus:ring-sophisticated-primary focus:border-transparent transition-all duration-200">
                            </div>
                        </div>
                        
                        <!-- Category Filter -->
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
                        
                        <!-- Price Range -->
                        <div>
                            <label class="block text-sm font-medium text-sophisticated-text mb-2">Faixa de Preço</label>
                            <div class="space-y-3">
                                <input type="number" 
                                       name="min_price" 
                                       value="<?= e($_GET['min_price'] ?? '') ?>" 
                                       placeholder="Preço mínimo"
                                       class="w-full px-4 py-3 border border-sophisticated-border rounded-xl focus:outline-none focus:ring-2 focus:ring-sophisticated-primary focus:border-transparent transition-all duration-200">
                                <input type="number" 
                                       name="max_price" 
                                       value="<?= e($_GET['max_price'] ?? '') ?>" 
                                       placeholder="Preço máximo"
                                       class="w-full px-4 py-3 border border-sophisticated-border rounded-xl focus:outline-none focus:ring-2 focus:ring-sophisticated-primary focus:border-transparent transition-all duration-200">
                            </div>
                        </div>
                        
                        <!-- Stock Filter -->
                        <div>
                            <label class="block text-sm font-medium text-sophisticated-text mb-2">Disponibilidade</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="in_stock" value="1" <?= isset($_GET['in_stock']) ? 'checked' : '' ?> 
                                           class="rounded border-sophisticated-border text-sophisticated-primary focus:ring-sophisticated-primary">
                                    <span class="ml-2 text-sm text-sophisticated-text">Apenas em estoque</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Apply Filters -->
                        <button type="submit" class="w-full btn-primary py-3 px-4 rounded-xl font-semibold text-white">
                            <i class="fas fa-filter mr-2"></i>Aplicar Filtros
                        </button>
                    </form>
                    
                    <!-- Clear Filters -->
                    <div class="mt-6 pt-6 border-t border-sophisticated-border">
                        <a href="/products" class="w-full py-3 px-4 border border-sophisticated-border text-sophisticated-text rounded-xl font-semibold hover:bg-sophisticated-gray transition-colors duration-200 text-center block">
                            <i class="fas fa-times mr-2"></i>Limpar Filtros
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Products Grid -->
        <div class="lg:col-span-3">
            <!-- Results Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                <div class="mb-4 sm:mb-0">
                    <h2 class="text-2xl font-semibold text-sophisticated-dark">
                        <?= count($products) ?> produtos encontrados
                    </h2>
                    <?php if (!empty($_GET['search']) || !empty($_GET['category'])): ?>
                        <p class="text-sophisticated-muted text-sm mt-1">
                            Filtros aplicados
                            <?php if (!empty($_GET['search'])): ?>
                                • Busca: "<?= e($_GET['search']) ?>"
                            <?php endif; ?>
                            <?php if (!empty($_GET['category'])): ?>
                                <?php 
                                $selectedCategory = array_filter($categories, function($cat) { 
                                    return $cat['id'] == $_GET['category']; 
                                });
                                if (!empty($selectedCategory)) {
                                    $category = reset($selectedCategory);
                                    echo '• Categoria: "' . e($category['name']) . '"';
                                }
                                ?>
                            <?php endif; ?>
                        </p>
                    <?php endif; ?>
                </div>
                
                <!-- Sort Options -->
                <div class="flex items-center space-x-4">
                    <label class="text-sm font-medium text-sophisticated-text">Ordenar por:</label>
                    <select class="px-4 py-2 border border-sophisticated-border rounded-xl focus:outline-none focus:ring-2 focus:ring-sophisticated-primary focus:border-transparent transition-all duration-200" 
                            onchange="window.location.href=this.value">
                        <option value="/products<?= !empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] . '&sort=name' : '?sort=name' ?>" <?= ($_GET['sort'] ?? '') === 'name' ? 'selected' : '' ?>>Nome A-Z</option>
                        <option value="/products<?= !empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] . '&sort=name_desc' : '?sort=name_desc' ?>" <?= ($_GET['sort'] ?? '') === 'name_desc' ? 'selected' : '' ?>>Nome Z-A</option>
                        <option value="/products<?= !empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] . '&sort=price' : '?sort=price' ?>" <?= ($_GET['sort'] ?? '') === 'price' ? 'selected' : '' ?>>Menor Preço</option>
                        <option value="/products<?= !empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] . '&sort=price_desc' : '?sort=price_desc' ?>" <?= ($_GET['sort'] ?? '') === 'price_desc' ? 'selected' : '' ?>>Maior Preço</option>
                        <option value="/products<?= !empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] . '&sort=newest' : '?sort=newest' ?>" <?= ($_GET['sort'] ?? '') === 'newest' ? 'selected' : '' ?>>Mais Recentes</option>
                    </select>
                </div>
            </div>
            
            <?php if (empty($products)): ?>
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-sophisticated-light rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-search text-sophisticated-muted text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-sophisticated-dark mb-2">Nenhum produto encontrado</h3>
                    <p class="text-sophisticated-muted mb-8">
                        Não encontramos produtos com os filtros aplicados. Tente ajustar os critérios de busca.
                    </p>
                    <a href="/products" class="btn-primary px-6 py-3 rounded-full text-white font-semibold">
                        Ver Todos os Produtos
                    </a>
                </div>
            <?php else: ?>
                <!-- Products Grid -->
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
                
                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                <div class="mt-12 flex justify-center">
                    <nav class="flex items-center space-x-2">
                        <?php if ($currentPage > 1): ?>
                            <a href="?<?= http_build_query(array_merge($_GET, ['page' => $currentPage - 1])) ?>" 
                               class="px-4 py-2 border border-sophisticated-border text-sophisticated-text rounded-xl hover:bg-sophisticated-gray transition-colors duration-200">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        <?php endif; ?>
                        
                        <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
                            <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>" 
                               class="px-4 py-2 rounded-xl <?= $i === $currentPage ? 'bg-sophisticated-primary text-white' : 'border border-sophisticated-border text-sophisticated-text hover:bg-sophisticated-gray' ?> transition-colors duration-200">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                        
                        <?php if ($currentPage < $totalPages): ?>
                            <a href="?<?= http_build_query(array_merge($_GET, ['page' => $currentPage + 1])) ?>" 
                               class="px-4 py-2 border border-sophisticated-border text-sophisticated-text rounded-xl hover:bg-sophisticated-gray transition-colors duration-200">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php endif; ?>
                    </nav>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?> 