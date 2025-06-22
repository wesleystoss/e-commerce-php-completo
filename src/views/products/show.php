<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['success']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['error']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Início</a></li>
            <li class="breadcrumb-item"><a href="/products">Produtos</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($product['name']); ?></li>
        </ol>
    </nav>

    <div class="row">
        <!-- Imagem do Produto -->
        <div class="col-md-6">
            <div class="product-image-container">
                <?php if ($product['image_url']): ?>
                    <img src="<?php echo htmlspecialchars($product['image_url']); ?>" 
                         alt="<?php echo htmlspecialchars($product['name']); ?>" 
                         class="img-fluid product-image">
                <?php else: ?>
                    <div class="no-image-placeholder">
                        <i class="fas fa-image fa-3x text-muted"></i>
                        <p class="text-muted">Sem imagem</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Detalhes do Produto -->
        <div class="col-md-6">
            <h1 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h1>
            
            <div class="product-price">
                <span class="price">R$ <?php echo number_format($product['price'], 2, ',', '.'); ?></span>
            </div>

            <div class="product-description mt-3">
                <h5>Descrição</h5>
                <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
            </div>

            <div class="product-info mt-3">
                <div class="row">
                    <div class="col-6">
                        <strong>Estoque:</strong> 
                        <?php if ($product['stock'] > 0): ?>
                            <span class="text-success"><?php echo $product['stock']; ?> unidades</span>
                        <?php else: ?>
                            <span class="text-danger">Indisponível</span>
                        <?php endif; ?>
                    </div>
                    <div class="col-6">
                        <strong>Categoria:</strong> 
                        <span><?php echo htmlspecialchars($product['category_name'] ?? 'Sem categoria'); ?></span>
                    </div>
                </div>
            </div>

            <!-- Formulário para adicionar ao carrinho -->
            <?php if ($product['stock'] > 0): ?>
                <form action="/product/add-to-cart" method="POST" class="mt-4">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <label for="quantity" class="form-label">Quantidade:</label>
                            <input type="number" 
                                   class="form-control" 
                                   id="quantity" 
                                   name="quantity" 
                                   value="1" 
                                   min="1" 
                                   max="<?php echo $product['stock']; ?>">
                        </div>
                        <div class="col-md-8">
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-shopping-cart me-2"></i>
                                Adicionar ao Carrinho
                            </button>
                        </div>
                    </div>
                </form>
            <?php else: ?>
                <div class="mt-4">
                    <button class="btn btn-secondary btn-lg w-100" disabled>
                        <i class="fas fa-times me-2"></i>
                        Produto Indisponível
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Produtos Relacionados -->
    <?php if (!empty($relatedProducts)): ?>
        <div class="related-products mt-5">
            <h3>Produtos Relacionados</h3>
            <div class="row">
                <?php foreach ($relatedProducts as $relatedProduct): ?>
                    <?php if ($relatedProduct['id'] != $product['id']): ?>
                        <div class="col-md-3 col-sm-6 mb-4">
                            <div class="card h-100 product-card">
                                <?php if ($relatedProduct['image_url']): ?>
                                    <img src="<?php echo htmlspecialchars($relatedProduct['image_url']); ?>" 
                                         class="card-img-top" 
                                         alt="<?php echo htmlspecialchars($relatedProduct['name']); ?>">
                                <?php else: ?>
                                    <div class="card-img-top no-image-placeholder-small">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($relatedProduct['name']); ?></h5>
                                    <p class="card-text price">R$ <?php echo number_format($relatedProduct['price'], 2, ',', '.'); ?></p>
                                    <a href="/product/<?php echo $relatedProduct['id']; ?>" class="btn btn-outline-primary btn-sm">
                                        Ver Detalhes
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
.product-image-container {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    background: #f8f9fa;
}

.product-image {
    max-width: 100%;
    height: auto;
    border-radius: 4px;
}

.no-image-placeholder {
    padding: 60px 20px;
    color: #6c757d;
}

.no-image-placeholder-small {
    height: 150px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    color: #6c757d;
}

.product-title {
    color: #333;
    margin-bottom: 15px;
}

.product-price .price {
    font-size: 2rem;
    font-weight: bold;
    color: #28a745;
}

.product-description {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
}

.product-info {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
}

.product-card {
    transition: transform 0.2s;
    border: 1px solid #ddd;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.product-card .card-img-top {
    height: 200px;
    object-fit: cover;
}

.breadcrumb a {
    color: #007bff;
    text-decoration: none;
}

.breadcrumb a:hover {
    text-decoration: underline;
}
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?> 