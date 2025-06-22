<?php $pageTitle = 'Detalhes do Pedido #' . $order['id']; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center space-x-4 mb-4">
            <a href="/orders" class="text-sophisticated-muted hover:text-sophisticated-primary transition-colors duration-200">
                <i class="fas fa-arrow-left text-lg"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-sophisticated-dark">Pedido #<?= $order['id'] ?></h1>
                <p class="text-sophisticated-muted">Detalhes completos do seu pedido</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Information -->
            <div class="bg-white rounded-2xl shadow-sm border border-sophisticated-border overflow-hidden">
                <div class="p-6 border-b border-sophisticated-border">
                    <h2 class="text-xl font-semibold text-sophisticated-dark">Informações do Pedido</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="text-sm font-medium text-sophisticated-muted">Data do Pedido</label>
                                <p class="text-sophisticated-dark font-medium"><?= date('d/m/Y \à\s H:i', strtotime($order['created_at'])) ?></p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-sophisticated-muted">Status</label>
                                <div class="mt-1">
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
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="text-sm font-medium text-sophisticated-muted">Total</label>
                                <p class="text-2xl font-bold text-sophisticated-dark"><?= formatPrice($order['total_amount']) ?></p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-sophisticated-muted">Endereço de Entrega</label>
                                <p class="text-sophisticated-dark text-sm"><?= nl2br(e($order['shipping_address'])) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-2xl shadow-sm border border-sophisticated-border overflow-hidden">
                <div class="p-6 border-b border-sophisticated-border">
                    <h2 class="text-xl font-semibold text-sophisticated-dark">Itens do Pedido</h2>
                </div>
                <div class="p-6">
                    <?php if (empty($order['items'])): ?>
                        <div class="text-center py-8">
                            <i class="fas fa-box text-sophisticated-muted text-3xl mb-3"></i>
                            <p class="text-sophisticated-muted">Nenhum item encontrado.</p>
                        </div>
                    <?php else: ?>
                        <div class="space-y-4">
                            <?php foreach ($order['items'] as $item): ?>
                            <div class="flex items-center space-x-4 p-4 bg-sophisticated-gray rounded-xl">
                                <div class="flex-shrink-0">
                                    <?php if ($item['image_url']): ?>
                                        <img src="<?= e($item['image_url']) ?>" 
                                             alt="<?= e($item['product_name']) ?>" 
                                             class="w-16 h-16 object-cover rounded-lg">
                                    <?php else: ?>
                                        <div class="w-16 h-16 bg-sophisticated-light rounded-lg flex items-center justify-center">
                                            <i class="fas fa-image text-sophisticated-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-semibold text-sophisticated-dark"><?= e($item['product_name']) ?></h3>
                                    <p class="text-sophisticated-muted text-sm">Quantidade: <?= $item['quantity'] ?></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-semibold text-sophisticated-dark"><?= formatPrice($item['price']) ?></p>
                                    <p class="text-sophisticated-muted text-sm"><?= formatPrice($item['price'] * $item['quantity']) ?></p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="sticky top-24 space-y-6">
                <!-- Order Summary -->
                <div class="bg-white rounded-2xl shadow-sm border border-sophisticated-border">
                    <div class="p-6 border-b border-sophisticated-border">
                        <h3 class="text-lg font-semibold text-sophisticated-dark">Resumo do Pedido</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sophisticated-muted">Subtotal</span>
                                <span class="text-sophisticated-dark font-medium"><?= formatPrice($order['total_amount']) ?></span>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sophisticated-muted">Frete</span>
                                <span class="text-green-600 font-medium">Grátis</span>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sophisticated-muted">Taxas</span>
                                <span class="text-sophisticated-dark font-medium">R$ 0,00</span>
                            </div>
                            <div class="border-t border-sophisticated-border pt-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-semibold text-sophisticated-dark">Total</span>
                                    <span class="text-2xl font-bold text-sophisticated-dark"><?= formatPrice($order['total_amount']) ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-sophisticated-muted">Forma de Pagamento</label>
                            <p class="text-sophisticated-dark font-medium mt-1">
                                <?php
                                switch($order['payment_method']) {
                                    case 'boleto':
                                        echo 'Boleto Bancário';
                                        break;
                                    case 'pix':
                                        echo 'Pix';
                                        break;
                                    case 'cartao':
                                        echo 'Cartão de Crédito';
                                        break;
                                    default:
                                        echo 'Não informado';
                                }
                                ?>
                            </p>
                        </div>
                        
                        <?php if ($order['payment_method'] === 'boleto'): ?>
                            <button type="button" class="w-full py-3 px-4 border border-sophisticated-primary text-sophisticated-primary rounded-xl font-semibold hover:bg-sophisticated-primary hover:text-white transition-all duration-200" onclick="showBoletoModal()">
                                <i class="fas fa-barcode mr-2"></i>Gerar Boleto
                            </button>
                        <?php elseif ($order['payment_method'] === 'pix'): ?>
                            <button type="button" class="w-full py-3 px-4 border border-green-500 text-green-600 rounded-xl font-semibold hover:bg-green-500 hover:text-white transition-all duration-200" onclick="showPixModal()">
                                <i class="fas fa-qrcode mr-2"></i>Ver QR Code Pix
                            </button>
                        <?php elseif ($order['payment_method'] === 'cartao'): ?>
                            <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                    <div>
                                        <h4 class="font-semibold text-green-800">Pagamento Aprovado!</h4>
                                        <p class="text-sm text-green-700">Seu pagamento foi processado com sucesso.</p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <div class="pt-4">
                            <a href="/orders" class="w-full py-3 px-4 border border-sophisticated-border text-sophisticated-text rounded-xl font-semibold hover:bg-sophisticated-gray transition-colors duration-200 text-center block">
                                <i class="fas fa-arrow-left mr-2"></i>Voltar aos Pedidos
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Order Status Timeline -->
                <div class="bg-white rounded-2xl shadow-sm border border-sophisticated-border">
                    <div class="p-6 border-b border-sophisticated-border">
                        <h3 class="text-lg font-semibold text-sophisticated-dark">Status do Pedido</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-check text-white text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sophisticated-dark font-medium">Pedido Realizado</p>
                                    <p class="text-sophisticated-muted text-sm"><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></p>
                                </div>
                            </div>
                            
                            <?php if ($order['status'] !== 'pending'): ?>
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-check text-white text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sophisticated-dark font-medium">Pagamento Confirmado</p>
                                    <p class="text-sophisticated-muted text-sm"><?= date('d/m/Y H:i', strtotime($order['created_at'] . ' +1 hour')) ?></p>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($order['status'] === 'processing' || $order['status'] === 'shipped' || $order['status'] === 'completed'): ?>
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-check text-white text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sophisticated-dark font-medium">Em Preparação</p>
                                    <p class="text-sophisticated-muted text-sm"><?= date('d/m/Y H:i', strtotime($order['created_at'] . ' +2 hours')) ?></p>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($order['status'] === 'shipped' || $order['status'] === 'completed'): ?>
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-check text-white text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sophisticated-dark font-medium">Enviado</p>
                                    <p class="text-sophisticated-muted text-sm"><?= date('d/m/Y H:i', strtotime($order['created_at'] . ' +1 day')) ?></p>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($order['status'] === 'completed'): ?>
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-check text-white text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sophisticated-dark font-medium">Entregue</p>
                                    <p class="text-sophisticated-muted text-sm"><?= date('d/m/Y H:i', strtotime($order['created_at'] . ' +3 days')) ?></p>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($order['status'] === 'pending'): ?>
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-sophisticated-light rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-clock text-sophisticated-muted text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sophisticated-muted font-medium">Aguardando Pagamento</p>
                                    <p class="text-sophisticated-muted text-sm">Pendente</p>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Boleto Modal -->
<?php if ($order['payment_method'] === 'boleto'): ?>
<div id="boletoModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-sophisticated-border">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-sophisticated-dark">Boleto Bancário - Pedido #<?= $order['id'] ?></h3>
                <button onclick="hideBoletoModal()" class="text-sophisticated-muted hover:text-sophisticated-dark">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        <div class="p-6">
            <div class="border-2 border-sophisticated-dark p-6 bg-white font-mono">
                <div class="text-center mb-6">
                    <h4 class="text-lg font-bold">BOLETO BANCÁRIO</h4>
                    <p class="text-sm text-sophisticated-muted">Banco Fictício S.A.</p>
                </div>
                
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between">
                        <span class="font-semibold">Beneficiário:</span>
                        <span>E-COMMERCE FICTÍCIO LTDA</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-semibold">CNPJ:</span>
                        <span>12.345.678/0001-90</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-semibold">Vencimento:</span>
                        <span><?= date('d/m/Y', strtotime('+3 days')) ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-semibold">Valor:</span>
                        <span class="font-bold text-lg"><?= formatPrice($order['total_amount']) ?></span>
                    </div>
                </div>
                
                <div class="border border-sophisticated-dark p-4 mb-6 bg-sophisticated-gray">
                    <div class="text-center mb-3">
                        <strong>CÓDIGO DE BARRAS</strong>
                    </div>
                    <div class="text-center text-lg font-bold tracking-wider mb-3">
                        12345.67890 12345.678901 12345.678901 1 12345678901234
                    </div>
                    <div class="w-full h-8 bg-black rounded"></div>
                </div>
                
                <div class="text-sm text-sophisticated-muted">
                    <p class="font-semibold mb-2">Instruções:</p>
                    <ul class="space-y-1">
                        <li>• Pague até a data de vencimento</li>
                        <li>• Após o vencimento, pagar apenas no banco</li>
                        <li>• Este é um boleto fictício para demonstração</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="p-6 border-t border-sophisticated-border flex space-x-3">
            <button onclick="hideBoletoModal()" class="flex-1 py-3 px-4 border border-sophisticated-border text-sophisticated-text rounded-xl font-semibold hover:bg-sophisticated-gray transition-colors duration-200">
                Fechar
            </button>
            <button onclick="window.print()" class="flex-1 btn-primary py-3 px-4 rounded-xl font-semibold text-white">
                <i class="fas fa-print mr-2"></i>Imprimir
            </button>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Pix Modal -->
<?php if ($order['payment_method'] === 'pix'): ?>
<div id="pixModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl max-w-md w-full mx-4">
        <div class="p-6 border-b border-sophisticated-border">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-sophisticated-dark">Pix - Pedido #<?= $order['id'] ?></h3>
                <button onclick="hidePixModal()" class="text-sophisticated-muted hover:text-sophisticated-dark">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        <div class="p-6 text-center">
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-sophisticated-dark mb-2">Valor: <?= formatPrice($order['total_amount']) ?></h4>
                <p class="text-sophisticated-muted">Escaneie o QR Code com seu app bancário</p>
            </div>
            
            <div class="w-48 h-48 bg-sophisticated-light rounded-xl flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-qrcode text-sophisticated-muted text-6xl"></i>
            </div>
            
            <div class="bg-sophisticated-gray rounded-xl p-4 mb-6">
                <p class="text-sm text-sophisticated-muted mb-2">Código Pix:</p>
                <p class="font-mono text-sm break-all">00020126580014br.gov.bcb.pix0136123e4567-e12b-12d1-a456-426614174000520400005303986540599.905802BR5913E-COMMERCE6008BRASILIA62070503***6304E2CA</p>
            </div>
            
            <button onclick="navigator.clipboard.writeText('00020126580014br.gov.bcb.pix0136123e4567-e12b-12d1-a456-426614174000520400005303986540599.905802BR5913E-COMMERCE6008BRASILIA62070503***6304E2CA')" class="w-full py-3 px-4 border border-sophisticated-primary text-sophisticated-primary rounded-xl font-semibold hover:bg-sophisticated-primary hover:text-white transition-all duration-200">
                <i class="fas fa-copy mr-2"></i>Copiar Código
            </button>
        </div>
        <div class="p-6 border-t border-sophisticated-border">
            <button onclick="hidePixModal()" class="w-full py-3 px-4 border border-sophisticated-border text-sophisticated-text rounded-xl font-semibold hover:bg-sophisticated-gray transition-colors duration-200">
                Fechar
            </button>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
function showBoletoModal() {
    document.getElementById('boletoModal').classList.remove('hidden');
    document.getElementById('boletoModal').classList.add('flex');
}

function hideBoletoModal() {
    document.getElementById('boletoModal').classList.add('hidden');
    document.getElementById('boletoModal').classList.remove('flex');
}

function showPixModal() {
    document.getElementById('pixModal').classList.remove('hidden');
    document.getElementById('pixModal').classList.add('flex');
}

function hidePixModal() {
    document.getElementById('pixModal').classList.add('hidden');
    document.getElementById('pixModal').classList.remove('flex');
}

// Close modals when clicking outside
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('fixed')) {
        event.target.classList.add('hidden');
        event.target.classList.remove('flex');
    }
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?> 