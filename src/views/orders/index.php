<?php $pageTitle = 'Meus Pedidos'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-sophisticated-dark mb-2">Meus Pedidos</h1>
        <p class="text-sophisticated-muted">Acompanhe todos os seus pedidos e histórico de compras</p>
    </div>

    <?php if (empty($orders)): ?>
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-sophisticated-light rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-shopping-bag text-sophisticated-muted text-3xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-sophisticated-dark mb-2">Nenhum pedido encontrado</h3>
            <p class="text-sophisticated-muted mb-8">Você ainda não fez nenhum pedido. Que tal começar a explorar nossos produtos?</p>
            <a href="/products" class="btn-primary px-8 py-4 rounded-full text-white font-semibold text-lg inline-flex items-center">
                <i class="fas fa-shopping-bag mr-2"></i>
                Explorar Produtos
            </a>
        </div>
    <?php else: ?>
        <!-- Orders List -->
        <div class="space-y-6">
            <?php foreach ($orders as $order): ?>
            <div class="bg-white rounded-2xl shadow-sm border border-sophisticated-border overflow-hidden hover:shadow-lg transition-all duration-300">
                <div class="p-6">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <!-- Order Info -->
                        <div class="flex-1">
                            <div class="flex items-center space-x-4 mb-4 lg:mb-0">
                                <div class="w-12 h-12 bg-gradient-to-br from-sophisticated-primary to-sophisticated-accent rounded-xl flex items-center justify-center">
                                    <i class="fas fa-shopping-bag text-white"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-sophisticated-dark">
                                        Pedido #<?= $order['id'] ?>
                                    </h3>
                                    <p class="text-sophisticated-muted text-sm">
                                        <?= date('d/m/Y \à\s H:i', strtotime($order['created_at'])) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Order Details -->
                        <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-3 sm:space-y-0 sm:space-x-6">
                            <div class="text-center sm:text-right">
                                <p class="text-sophisticated-muted text-sm">Total</p>
                                <p class="text-xl font-bold text-sophisticated-dark"><?= formatPrice($order['total_amount']) ?></p>
                            </div>
                            
                            <div class="text-center sm:text-right">
                                <p class="text-sophisticated-muted text-sm">Status</p>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                    <?php
                                    switch($order['status']) {
                                        case 'pending':
                                            echo 'bg-yellow-100 text-yellow-800';
                                            break;
                                        case 'processing':
                                            echo 'bg-blue-100 text-blue-800';
                                            break;
                                        case 'shipped':
                                            echo 'bg-purple-100 text-purple-800';
                                            break;
                                        case 'completed':
                                            echo 'bg-green-100 text-green-800';
                                            break;
                                        case 'cancelled':
                                            echo 'bg-red-100 text-red-800';
                                            break;
                                        default:
                                            echo 'bg-sophisticated-light text-sophisticated-muted';
                                    }
                                    ?>">
                                    <i class="fas fa-circle text-xs mr-1"></i>
                                    <?= ucfirst($order['status']) ?>
                                </span>
                            </div>
                            
                            <div class="text-center sm:text-right">
                                <a href="/order/<?= $order['id'] ?>" class="btn-primary px-6 py-2 rounded-xl text-white font-semibold hover:shadow-lg transition-all duration-200">
                                    <i class="fas fa-eye mr-2"></i>
                                    Ver Detalhes
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Order Progress (if processing) -->
                <?php if ($order['status'] === 'processing' || $order['status'] === 'shipped'): ?>
                <div class="px-6 py-4 bg-sophisticated-gray border-t border-sophisticated-border">
                    <div class="flex items-center space-x-4">
                        <div class="flex-1">
                            <div class="flex items-center justify-between text-xs text-sophisticated-muted mb-2">
                                <span>Progresso do Pedido</span>
                                <span>
                                    <?php
                                    switch($order['status']) {
                                        case 'processing':
                                            echo '25%';
                                            break;
                                        case 'shipped':
                                            echo '75%';
                                            break;
                                        default:
                                            echo '0%';
                                    }
                                    ?>
                                </span>
                            </div>
                            <div class="w-full bg-sophisticated-border rounded-full h-2">
                                <div class="bg-sophisticated-primary h-2 rounded-full transition-all duration-500"
                                     style="width: <?= $order['status'] === 'processing' ? '25%' : ($order['status'] === 'shipped' ? '75%' : '0%') ?>"></div>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-sophisticated-muted">
                                <?= $order['status'] === 'processing' ? 'Em preparação' : 'Em transporte' ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Summary -->
        <div class="mt-8 bg-white rounded-2xl shadow-sm border border-sophisticated-border p-6">
            <h3 class="text-lg font-semibold text-sophisticated-dark mb-4">Resumo dos Pedidos</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-sophisticated-dark"><?= count($orders) ?></div>
                    <div class="text-sophisticated-muted text-sm">Total de Pedidos</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">
                        <?= count(array_filter($orders, function($order) { return $order['status'] === 'completed'; })) ?>
                    </div>
                    <div class="text-sophisticated-muted text-sm">Concluídos</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-yellow-600">
                        <?= count(array_filter($orders, function($order) { return $order['status'] === 'pending'; })) ?>
                    </div>
                    <div class="text-sophisticated-muted text-sm">Pendentes</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-sophisticated-primary">
                        <?= formatPrice(array_sum(array_column($orders, 'total_amount'))) ?>
                    </div>
                    <div class="text-sophisticated-muted text-sm">Total Gasto</div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?> 