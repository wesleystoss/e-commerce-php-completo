<?php $pageTitle = 'Início'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<!-- Hero Section -->
<div class="bg-primary text-white py-5 mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="display-4 fw-bold">Bem-vindo ao E-commerce Básico</h1>
                <p class="lead">Descubra produtos incríveis com preços competitivos e entrega rápida.</p>
                <a href="/products" class="btn btn-light btn-lg">Ver Produtos</a>
            </div>
            <div class="col-md-6 text-center">
                <i class="fas fa-shopping-bag" style="font-size: 8rem; opacity: 0.3;"></i>
            </div>
        </div>
    </div>
</div>

<!-- Featured Products -->
<section class="mb-5">
    <div class="container">
        <h2 class="text-center mb-4">Produtos em Destaque</h2>
        <div class="row">
            <?php foreach ($featuredProducts as $product): ?>
            <div class="col-md-3 mb-4">
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
        <div class="text-center mt-4">
            <a href="/products" class="btn btn-outline-primary">Ver Todos os Produtos</a>
        </div>
    </div>
</section>

<!-- Categories -->
<section class="mb-5">
    <div class="container">
        <h2 class="text-center mb-4">Categorias</h2>
        <div class="row">
            <?php foreach ($categories as $category): ?>
            <div class="col-md-4 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title"><?= e($category['name']) ?></h5>
                        <p class="card-text text-muted"><?= isset($category['product_count']) ? $category['product_count'] : 0 ?> produtos</p>
                        <a href="/category/<?= $category['id'] ?>" class="btn btn-outline-primary">Ver Produtos</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Admin Alert for Low Stock -->
<?php if (!empty($lowStockProducts)): ?>
<section class="mb-5">
    <div class="container">
        <div class="alert alert-warning">
            <h5><i class="fas fa-exclamation-triangle me-2"></i>Alerta de Estoque Baixo</h5>
            <p class="mb-2">Os seguintes produtos estão com estoque baixo:</p>
            <ul class="mb-0">
                <?php foreach ($lowStockProducts as $product): ?>
                <li><?= e($product['name']) ?> - <?= $product['stock'] ?> unidades restantes</li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Features -->
<section class="mb-5">
    <div class="container">
        <h2 class="text-center mb-4">Por que escolher nossa loja?</h2>
        <div class="row">
            <div class="col-md-4 text-center mb-4">
                <i class="fas fa-shipping-fast text-primary mb-3" style="font-size: 3rem;"></i>
                <h5>Entrega Rápida</h5>
                <p class="text-muted">Receba seus produtos em até 48 horas em todo o Brasil.</p>
            </div>
            <div class="col-md-4 text-center mb-4">
                <i class="fas fa-shield-alt text-primary mb-3" style="font-size: 3rem;"></i>
                <h5>Compra Segura</h5>
                <p class="text-muted">Seus dados estão protegidos com a mais alta segurança.</p>
            </div>
            <div class="col-md-4 text-center mb-4">
                <i class="fas fa-headset text-primary mb-3" style="font-size: 3rem;"></i>
                <h5>Suporte 24/7</h5>
                <p class="text-muted">Nossa equipe está sempre pronta para ajudar você.</p>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?> 