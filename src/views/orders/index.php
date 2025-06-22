<?php $pageTitle = 'Meus Pedidos'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h2 class="mb-4">Meus Pedidos</h2>

<?php if (empty($orders)): ?>
    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i>
        Você ainda não fez nenhum pedido.
        <a href="/products" class="alert-link">Ver produtos</a>
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Pedido #</th>
                    <th>Data</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><strong>#<?= $order['id'] ?></strong></td>
                    <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                    <td><?= formatPrice($order['total_amount']) ?></td>
                    <td>
                        <span class="badge bg-<?= $order['status'] === 'pending' ? 'warning' : ($order['status'] === 'completed' ? 'success' : 'secondary') ?>">
                            <?= ucfirst($order['status']) ?>
                        </span>
                    </td>
                    <td>
                        <a href="/order/<?= $order['id'] ?>" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye me-1"></i>Ver Detalhes
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?> 