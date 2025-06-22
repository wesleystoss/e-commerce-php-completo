    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-sophisticated-border mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Brand -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 bg-gradient-to-br from-sophisticated-primary to-sophisticated-accent rounded-lg flex items-center justify-center">
                            <i class="fas fa-cube text-white text-sm"></i>
                        </div>
                        <span class="text-xl font-semibold text-sophisticated-dark">TechStore</span>
                    </div>
                    <p class="text-sophisticated-muted leading-relaxed max-w-md">
                        Descubra produtos de tecnologia inovadores com design elegante e funcionalidade excepcional. 
                        Qualidade e sofisticação em cada detalhe.
                    </p>
                    <div class="flex space-x-4 mt-6">
                        <a href="#" class="w-10 h-10 bg-sophisticated-light rounded-full flex items-center justify-center text-sophisticated-muted hover:bg-sophisticated-primary hover:text-white transition-colors duration-200">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-sophisticated-light rounded-full flex items-center justify-center text-sophisticated-muted hover:bg-sophisticated-primary hover:text-white transition-colors duration-200">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-sophisticated-light rounded-full flex items-center justify-center text-sophisticated-muted hover:bg-sophisticated-primary hover:text-white transition-colors duration-200">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-sophisticated-light rounded-full flex items-center justify-center text-sophisticated-muted hover:bg-sophisticated-primary hover:text-white transition-colors duration-200">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h5 class="font-semibold text-sophisticated-dark mb-4">Navegação</h5>
                    <ul class="space-y-3">
                        <li><a href="/" class="text-sophisticated-muted hover:text-sophisticated-primary transition-colors duration-200">Início</a></li>
                        <li><a href="/products" class="text-sophisticated-muted hover:text-sophisticated-primary transition-colors duration-200">Produtos</a></li>
                        <li><a href="/cart" class="text-sophisticated-muted hover:text-sophisticated-primary transition-colors duration-200">Carrinho</a></li>
                        <li><a href="/login" class="text-sophisticated-muted hover:text-sophisticated-primary transition-colors duration-200">Entrar</a></li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div>
                    <h5 class="font-semibold text-sophisticated-dark mb-4">Contato</h5>
                    <ul class="space-y-3">
                        <li class="flex items-center text-sophisticated-muted">
                            <i class="fas fa-envelope w-5 text-sophisticated-primary"></i>
                            <span>contato@techstore.com</span>
                        </li>
                        <li class="flex items-center text-sophisticated-muted">
                            <i class="fas fa-phone w-5 text-sophisticated-primary"></i>
                            <span>(11) 99999-9999</span>
                        </li>
                        <li class="flex items-center text-sophisticated-muted">
                            <i class="fas fa-map-marker-alt w-5 text-sophisticated-primary"></i>
                            <span>São Paulo, SP</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Bottom Bar -->
            <div class="border-t border-sophisticated-border mt-12 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-sophisticated-muted text-sm">
                        &copy; <?= date('Y') ?> TechStore. Todos os direitos reservados.
                    </p>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a href="#" class="text-sophisticated-muted hover:text-sophisticated-primary text-sm transition-colors duration-200">Política de Privacidade</a>
                        <a href="#" class="text-sophisticated-muted hover:text-sophisticated-primary text-sm transition-colors duration-200">Termos de Uso</a>
                        <a href="#" class="text-sophisticated-muted hover:text-sophisticated-primary text-sm transition-colors duration-200">Suporte</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Menu JavaScript -->
    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }
        
        // Auto-hide flash messages after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.bg-green-50, .bg-red-50');
            alerts.forEach(function(alert) {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            });
        }, 5000);
    </script>
</body>
</html> 