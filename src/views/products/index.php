<?php $pageTitle = 'Produtos'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="row">
    <!-- Sidebar Filters -->
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Filtros</h5>
            </div>
            <div class="card-body">
                <form action="/search" method="GET">
                    <div class="mb-3">
                        <label for="search" class="form-label">Buscar</label>
                        <input type="text" class="form-control" id="search" name="q" value="<?= e($_GET['q'] ?? '') ?>" placeholder="Nome do produto...">
                    </div>
                    
                    <div class="mb-3">
                        <label for="category" class="form-label">Categoria</label>
                        <select class="form-select" id="category" name="category">
                            <option value="">Todas as categorias</option>
                            <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>" <?= ($_GET['category'] ?? '') == $category['id'] ? 'selected' : '' ?>>
                                <?= e($category['name']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="min_price" class="form-label">Preço mínimo</label>
                        <input type="number" class="form-control" id="min_price" name="min_price" value="<?= e($_GET['min_price'] ?? '') ?>" step="0.01" min="0">
                    </div>
                    
                    <div class="mb-3">
                        <label for="max_price" class="form-label">Preço máximo</label>
                        <input type="number" class="form-control" id="max_price" name="max_price" value="<?= e($_GET['max_price'] ?? '') ?>" step="0.01" min="0">
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i>Filtrar
                    </button>
                </form>
                
                <hr>
                
                <a href="/products" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-times me-1"></i>Limpar Filtros
                </a>
            </div>
        </div>
    </div>
    
    <!-- Products Grid -->
    <div class="col-md-9">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Produtos</h2>
            <div class="d-flex align-items-center">
                <span class="text-muted me-3"><?= count($products) ?> produtos encontrados</span>
            </div>
        </div>
        
        <?php if (empty($products)): ?>
        <div class="text-center py-5">
            <i class="fas fa-search text-muted mb-3" style="font-size: 4rem;"></i>
            <h4 class="text-muted">Nenhum produto encontrado</h4>
            <p class="text-muted">Tente ajustar os filtros ou buscar por outro termo.</p>
            <a href="/products" class="btn btn-primary">Ver Todos os Produtos</a>
        </div>
        <?php else: ?>
        
        <div class="row">
            <?php foreach ($products as $product): ?>
            <div class="col-md-4 mb-4">
                <div class="card product-card h-100">
                    <?php if ($product['image_url']): ?>
                        <img src="<?= e($product['image_url']) ?>" class="card-img-top" alt="<?= e($product['name']) ?>">
                    <?php else: ?>
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center">
                            <i class="fas fa-image text-muted" style="font-size: 3rem;"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= e($product['name']) ?></h5>
                        <p class="card-text text-muted small"><?= e($product['category_name']) ?></p>
                        <p class="card-text flex-grow-1"><?= e(substr($product['description'], 0, 100)) ?>...</p>
                        
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="h5 text-primary mb-0"><?= formatPrice($product['price']) ?></span>
                            <span class="badge bg-<?= $product['stock'] > 0 ? 'success' : 'danger' ?>">
                                <?= $product['stock'] > 0 ? 'Em estoque' : 'Indisponível' ?>
                            </span>
                        </div>
                        
                        <?php if ($product['stock'] > 0): ?>
                        <small class="text-muted"><?= $product['stock'] ?> unidades disponíveis</small>
                        <?php endif; ?>
                    </div>
                    
                    <div class="card-footer bg-transparent">
                        <div class="d-grid gap-2">
                            <a href="/product/<?= $product['id'] ?>" class="btn btn-outline-primary btn-sm">Ver Detalhes</a>
                            <?php if ($product['stock'] > 0): ?>
                            <form action="/cart/add" method="POST" class="d-inline">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-primary btn-sm w-100">
                                    <i class="fas fa-cart-plus me-1"></i>Adicionar
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
        <?php if (isset($totalPages) && $totalPages > 1): ?>
        <nav aria-label="Navegação de páginas">
            <ul class="pagination justify-content-center">
                <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page - 1 ?><?= !empty($_GET['q']) ? '&q=' . urlencode($_GET['q']) : '' ?>">Anterior</a>
                </li>
                <?php endif; ?>
                
                <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?><?= !empty($_GET['q']) ? '&q=' . urlencode($_GET['q']) : '' ?>"><?= $i ?></a>
                </li>
                <?php endfor; ?>
                
                <?php if ($page < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page + 1 ?><?= !empty($_GET['q']) ? '&q=' . urlencode($_GET['q']) : '' ?>">Próxima</a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
        <?php endif; ?>
        
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?> 