<?php $pageTitle = 'Detalhes do Pedido #' . $order['id']; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="row">
    <div class="col-md-8">
        <h2 class="mb-4">Pedido #<?= $order['id'] ?></h2>
        
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Informações do Pedido</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Data:</strong> <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></p>
                        <p><strong>Status:</strong> 
                            <span class="badge bg-<?= $order['status'] === 'pending' ? 'warning' : ($order['status'] === 'completed' ? 'success' : 'secondary') ?>">
                                <?= ucfirst($order['status']) ?>
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Total:</strong> <?= formatPrice($order['total_amount']) ?></p>
                        <p><strong>Endereço de Entrega:</strong></p>
                        <p class="text-muted"><?= nl2br(e($order['shipping_address'])) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Itens do Pedido</h5>
            </div>
            <div class="card-body">
                <?php if (empty($order['items'])): ?>
                    <p class="text-muted">Nenhum item encontrado.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Quantidade</th>
                                    <th>Preço Unit.</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order['items'] as $item): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if ($item['image_url']): ?>
                                                <img src="<?= e($item['image_url']) ?>" alt="<?= e($item['product_name']) ?>" style="width: 50px; height: 50px; object-fit: cover;" class="me-3 rounded">
                                            <?php endif; ?>
                                            <span><?= e($item['product_name']) ?></span>
                                        </div>
                                    </td>
                                    <td><?= $item['quantity'] ?></td>
                                    <td><?= formatPrice($item['price']) ?></td>
                                    <td><?= formatPrice($item['price'] * $item['quantity']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Resumo</h5>
            </div>
            <div class="card-body">
                <p><strong>Total do Pedido:</strong></p>
                <h3 class="text-primary"><?= formatPrice($order['total_amount']) ?></h3>
                
                <hr>
                
                <a href="/orders" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Voltar aos Pedidos
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?> 