    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>E-commerce Básico</h5>
                    <p class="text-muted">
                        Sistema de e-commerce desenvolvido em PHP com funcionalidades completas 
                        de gerenciamento de produtos, carrinho de compras e pedidos.
                    </p>
                </div>
                <div class="col-md-4">
                    <h5>Links Úteis</h5>
                    <ul class="list-unstyled">
                        <li><a href="/" class="text-decoration-none">Início</a></li>
                        <li><a href="/products" class="text-decoration-none">Produtos</a></li>
                        <li><a href="/cart" class="text-decoration-none">Carrinho</a></li>
                        <li><a href="/login" class="text-decoration-none">Entrar</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contato</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-envelope me-2"></i>contato@ecommerce.com</li>
                        <li><i class="fas fa-phone me-2"></i>(11) 99999-9999</li>
                        <li><i class="fas fa-map-marker-alt me-2"></i>São Paulo, SP</li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12 text-center">
                    <p class="text-muted mb-0">
                        &copy; <?= date('Y') ?> E-commerce Básico. Todos os direitos reservados.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>
</html> 