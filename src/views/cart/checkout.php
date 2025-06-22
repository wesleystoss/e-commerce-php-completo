<?php $pageTitle = 'Checkout'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>
<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>

<h2 class="mb-4">Finalizar Compra</h2>

<form action="/cart/processCheckout" method="POST" class="row g-3" id="checkout-form">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Endereço de Entrega</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="shipping_address" class="form-label">Endereço Completo</label>
                    <textarea name="shipping_address" id="shipping_address" class="form-control" rows="3" required><?= e($_POST['shipping_address'] ?? '') ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Forma de Pagamento</label>
                    <select name="payment_method" id="payment_method" class="form-select" required>
                        <option value="">Selecione...</option>
                        <option value="boleto" <?= (($_POST['payment_method'] ?? '') === 'boleto') ? 'selected' : '' ?>>Boleto</option>
                        <option value="pix" <?= (($_POST['payment_method'] ?? '') === 'pix') ? 'selected' : '' ?>>Pix</option>
                        <option value="cartao" <?= (($_POST['payment_method'] ?? '') === 'cartao') ? 'selected' : '' ?>>Cartão de Crédito</option>
                    </select>
                </div>
                <div id="credit-card-fields" style="display: none;">
                    <div class="mb-3">
                        <label for="card_name" class="form-label">Nome no Cartão</label>
                        <input type="text" name="card_name" id="card_name" class="form-control" value="<?= e($_POST['card_name'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="card_number" class="form-label">Número do Cartão</label>
                        <input type="text" name="card_number" id="card_number" class="form-control" maxlength="19" value="<?= e($_POST['card_number'] ?? '') ?>">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="card_expiry" class="form-label">Validade (MM/AA)</label>
                            <input type="text" name="card_expiry" id="card_expiry" class="form-control" maxlength="5" value="<?= e($_POST['card_expiry'] ?? '') ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="card_cvv" class="form-label">CVV</label>
                            <input type="text" name="card_cvv" id="card_cvv" class="form-control" maxlength="4" value="<?= e($_POST['card_cvv'] ?? '') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Resumo do Pedido</h5>
            </div>
            <div class="card-body">
                <ul class="list-group mb-3">
                    <?php foreach ($cartItems as $item): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><?= e($item['name']) ?> <small class="text-muted">x<?= $item['quantity'] ?></small></span>
                        <span><?= formatPrice($item['price'] * $item['quantity']) ?></span>
                    </li>
                    <?php endforeach; ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong>Total</strong>
                        <strong><?= formatPrice($total) ?></strong>
                    </li>
                </ul>
                <button type="submit" class="btn btn-success w-100 btn-lg">Confirmar Pedido</button>
            </div>
        </div>
    </div>
</form>
<script>
    function toggleCardFields() {
        var payment = document.getElementById('payment_method').value;
        var cardFields = document.getElementById('credit-card-fields');
        cardFields.style.display = (payment === 'cartao') ? 'block' : 'none';
    }
    document.getElementById('payment_method').addEventListener('change', toggleCardFields);
    window.addEventListener('DOMContentLoaded', function() {
        toggleCardFields();
    });
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?> 