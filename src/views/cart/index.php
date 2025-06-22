<?php $pageTitle = 'Carrinho de Compras'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h2 class="mb-4">Carrinho de Compras</h2>

<?php if (empty($cartItems)): ?>
    <div class="alert alert-info">Seu carrinho está vazio.</div>
    <a href="/products" class="btn btn-primary">Ver Produtos</a>
<?php else: ?>
    <form action="/cart/update" method="POST">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <?php if ($item['image_url']): ?>
                                    <img src="<?= e($item['image_url']) ?>" alt="<?= e($item['name']) ?>" style="width: 60px; height: 60px; object-fit: cover;" class="me-2 rounded">
                                <?php endif; ?>
                                <span><?= e($item['name']) ?></span>
                            </div>
                        </td>
                        <td><?= formatPrice($item['price']) ?></td>
                        <td style="max-width: 100px;">
                            <form action="/cart/update" method="POST" class="d-flex">
                                <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" class="form-control form-control-sm me-2">
                                <button type="submit" class="btn btn-outline-primary btn-sm"><i class="fas fa-sync"></i></button>
                            </form>
                        </td>
                        <td><?= formatPrice($item['price'] * $item['quantity']) ?></td>
                        <td>
                            <form action="/cart/remove" method="POST">
                                <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </form>
    <div class="d-flex justify-content-between align-items-center mt-4">
        <form action="/cart/clear" method="POST">
            <button type="submit" class="btn btn-outline-danger">Limpar Carrinho</button>
        </form>
        <div>
            <span class="h5 me-3">Total: <strong><?= formatPrice($total) ?></strong></span>
            <form action="/cart/checkout" method="GET" style="display: inline;">
                <button type="submit" class="btn btn-success btn-lg">Finalizar Compra</button>
            </form>
        </div>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?> 