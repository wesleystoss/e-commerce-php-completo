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
                <p><strong>Forma de Pagamento:</strong> 
                    <?php
                    if ($order['payment_method'] === 'boleto') {
                        echo 'Boleto Bancário';
                    } elseif ($order['payment_method'] === 'pix') {
                        echo 'Pix';
                    } elseif ($order['payment_method'] === 'cartao') {
                        echo 'Cartão de Crédito';
                    } else {
                        echo 'Não informado';
                    }
                    ?>
                </p>
                
                <?php if ($order['payment_method'] === 'boleto'): ?>
                    <button type="button" class="btn btn-outline-primary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#boletoModal">
                        <i class="fas fa-barcode me-2"></i>Gerar Boleto
                    </button>
                <?php elseif ($order['payment_method'] === 'pix'): ?>
                    <button type="button" class="btn btn-outline-success w-100 mb-2" data-bs-toggle="modal" data-bs-target="#pixModal">
                        <i class="fas fa-qrcode me-2"></i>Ver QR Code Pix
                    </button>
                <?php elseif ($order['payment_method'] === 'cartao'): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>Pagamento aprovado!
                    </div>
                <?php endif; ?>
                
                <hr>
                <a href="/orders" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Voltar aos Pedidos
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Boleto -->
<?php if ($order['payment_method'] === 'boleto'): ?>
<div class="modal fade" id="boletoModal" tabindex="-1" aria-labelledby="boletoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="boletoModalLabel">Boleto Bancário - Pedido #<?= $order['id'] ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="boleto-container" style="border: 2px solid #000; padding: 20px; font-family: monospace; background: #fff;">
                    <div style="text-align: center; margin-bottom: 20px;">
                        <h4>BOLETO BANCÁRIO</h4>
                        <p style="font-size: 12px;">Banco Fictício S.A.</p>
                    </div>
                    
                    <div style="margin-bottom: 15px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                            <span><strong>Beneficiário:</strong></span>
                            <span>E-COMMERCE FICTÍCIO LTDA</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                            <span><strong>CNPJ:</strong></span>
                            <span>12.345.678/0001-90</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                            <span><strong>Vencimento:</strong></span>
                            <span><?= date('d/m/Y', strtotime('+3 days')) ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                            <span><strong>Valor:</strong></span>
                            <span><strong><?= formatPrice($order['total_amount']) ?></strong></span>
                        </div>
                    </div>
                    
                    <div style="border: 1px solid #000; padding: 10px; margin-bottom: 15px; background: #f8f9fa;">
                        <div style="text-align: center; margin-bottom: 10px;">
                            <strong>CÓDIGO DE BARRAS</strong>
                        </div>
                        <div style="text-align: center; font-size: 18px; letter-spacing: 2px; font-weight: bold;">
                            12345.67890 12345.678901 12345.678901 1 12345678901234
                        </div>
                        <!-- Código de barras visual simples -->
                        <div style="margin: 10px auto; width: 90%; height: 40px; background: repeating-linear-gradient(90deg, #000, #000 4px, #fff 4px, #fff 8px); border-radius: 2px;"></div>
                    </div>
                    
                    <div style="font-size: 12px; color: #666;">
                        <p><strong>Instruções:</strong></p>
                        <ul>
                            <li>Pague até a data de vencimento</li>
                            <li>Após o vencimento, pagar apenas no banco</li>
                            <li>Este é um boleto fictício para demonstração</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" onclick="window.print()">
                    <i class="fas fa-print me-2"></i>Imprimir
                </button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Modal Pix -->
<?php if ($order['payment_method'] === 'pix'): ?>
<div class="modal fade" id="pixModal" tabindex="-1" aria-labelledby="pixModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pixModalLabel">Pix - Pedido #<?= $order['id'] ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div style="margin-bottom: 20px;">
                    <h6>Valor: <strong><?= formatPrice($order['total_amount']) ?></strong></h6>
                    <p class="text-muted">Escaneie o QR Code com seu app bancário</p>
                </div>
                
                <!-- QR Code real -->
                <div style="border: 2px solid #000; padding: 20px; display: inline-block; background: #fff; margin-bottom: 20px;">
                    <div id="qrcode" style="width: 200px; height: 200px;"></div>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <p><strong>Chave Pix:</strong></p>
                    <div style="background: #f8f9fa; padding: 10px; border-radius: 5px; font-family: monospace; font-size: 14px;">
                        ecommerce@ficticio.com.br
                    </div>
                </div>
                
                <div style="font-size: 12px; color: #666;">
                    <p><strong>Instruções:</strong></p>
                    <ul style="text-align: left;">
                        <li>Abra o app do seu banco</li>
                        <li>Escolha a opção Pix</li>
                        <li>Escaneie o QR Code ou cole a chave</li>
                        <li>Confirme o pagamento</li>
                        <li>Este é um QR Code fictício para demonstração</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-success" onclick="copyPixKey()">
                    <i class="fas fa-copy me-2"></i>Copiar Chave
                </button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- QRCode.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>

<script>
function copyPixKey() {
    navigator.clipboard.writeText('ecommerce@ficticio.com.br').then(function() {
        alert('Chave Pix copiada para a área de transferência!');
    });
}

// Gerar QR Code quando o modal for aberto
document.addEventListener('DOMContentLoaded', function() {
    const pixModal = document.getElementById('pixModal');
    if (pixModal) {
        pixModal.addEventListener('shown.bs.modal', function() {
            const qrcodeDiv = document.getElementById('qrcode');
            if (qrcodeDiv) {
                qrcodeDiv.innerHTML = '';
                QRCode.toCanvas(qrcodeDiv, 'PIX: ecommerce@ficticio.com.br', {
                    width: 200,
                    height: 200,
                    margin: 2,
                    color: {
                        dark: '#000000',
                        light: '#FFFFFF'
                    }
                }, function(error) {
                    if (error) {
                        console.error('Erro ao gerar QR Code:', error);
                        // Fallback para QR Code simples
                        qrcodeDiv.innerHTML = '<div style="width: 200px; height: 200px; background: linear-gradient(45deg, #000 25%, transparent 25%), linear-gradient(-45deg, #000 25%, transparent 25%), linear-gradient(45deg, transparent 75%, #000 75%), linear-gradient(-45deg, transparent 75%, #000 75%); background-size: 20px 20px; background-position: 0 0, 0 10px, 10px -10px, -10px 0px;"></div>';
                    }
                });
            }
        });
    }
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?> 