<?php $pageTitle = 'Produtos da Categoria'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h2 class="mb-4">Produtos da Categoria: <?= e($category['name']) ?></h2>

<?php if (empty($products)): ?>
    <div class="alert alert-info">Nenhum produto encontrado nesta categoria.</div>
<?php else: ?>
    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <?php if ($product['image_url']): ?>
                        <img src="<?= e($product['image_url']) ?>" class="card-img-top" alt="<?= e($product['name']) ?>">
                    <?php else: ?>
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                            <i class="fas fa-image text-muted" style="font-size: 3rem;"></i>
                        </div>
                    <?php endif; ?>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= e($product['name']) ?></h5>
                        <p class="card-text text-muted small"><?= e($product['category_name']) ?></p>
                        <p class="card-text flex-grow-1"><?= e(substr($product['description'], 0, 100)) ?>...</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 text-primary mb-0"><?= formatPrice($product['price']) ?></span>
                            <span class="badge bg-<?= $product['stock'] > 0 ? 'success' : 'danger' ?>">
                                <?= $product['stock'] > 0 ? 'Em estoque' : 'Indisponível' ?>
                            </span>
                        </div>
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
<?php endif; ?>

<a href="/" class="btn btn-secondary mt-4">Voltar para o início</a>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?> 