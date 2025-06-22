<?php $pageTitle = 'Início'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<!-- Hero Section -->
<section class="hero-gradient text-sophisticated-dark py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h1 class="text-5xl lg:text-6xl font-bold leading-tight mb-6">
                    Tecnologia
                    <span class="block gradient-text">
                        Reimaginada
                    </span>
                </h1>
                <p class="text-xl text-sophisticated-muted leading-relaxed mb-8 max-w-lg">
                    Descubra produtos que combinam design elegante com funcionalidade excepcional. 
                    Qualidade e sofisticação em cada detalhe.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="/products" class="btn-primary px-8 py-4 rounded-full text-white font-semibold text-lg inline-flex items-center justify-center">
                        Explorar Produtos
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                    <a href="#featured" class="px-8 py-4 rounded-full border-2 border-sophisticated-primary/30 text-sophisticated-primary font-semibold text-lg hover:bg-sophisticated-primary/10 transition-all duration-200 inline-flex items-center justify-center">
                        Ver Destaques
                    </a>
                </div>
            </div>
            <div class="relative">
                <div class="glass-effect rounded-3xl p-8 backdrop-blur-sm">
                    <div class="text-center">
                        <i class="fas fa-cube text-8xl text-sophisticated-primary/20 mb-4"></i>
                        <h3 class="text-2xl font-semibold mb-2 text-sophisticated-dark">TechStore</h3>
                        <p class="text-sophisticated-muted">Inovação em cada produto</p>
                    </div>
                </div>
                <!-- Floating elements -->
                <div class="absolute -top-4 -right-4 w-20 h-20 bg-sophisticated-primary/10 rounded-full backdrop-blur-sm"></div>
                <div class="absolute -bottom-4 -left-4 w-16 h-16 bg-sophisticated-primary/5 rounded-full backdrop-blur-sm"></div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section id="featured" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-sophisticated-dark mb-4">Produtos em Destaque</h2>
            <p class="text-xl text-sophisticated-muted max-w-2xl mx-auto">
                Produtos selecionados que representam o melhor em tecnologia e design
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php foreach ($featuredProducts as $product): ?>
            <div class="product-card bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col">
                <div class="relative">
                    <?php if ($product['image_url']): ?>
                        <img src="<?= e($product['image_url']) ?>" class="w-full h-64 object-cover" alt="<?= e($product['name']) ?>">
                    <?php else: ?>
                        <div class="w-full h-64 bg-gradient-to-br from-sophisticated-light to-sophisticated-border flex items-center justify-center">
                            <i class="fas fa-image text-sophisticated-muted text-4xl"></i>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Stock Badge -->
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $product['stock'] > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                            <?= $product['stock'] > 0 ? 'Em estoque' : 'Indisponível' ?>
                        </span>
                    </div>
                    
                    <!-- Category Badge -->
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold <?= getCategoryColorClass($product['category_id']) ?>">
                            <?= e($product['category_name']) ?>
                        </span>
                    </div>
                </div>
                
                <div class="p-6 flex flex-col flex-grow">
                    <!-- Title & Description -->
                    <div class="flex-grow">
                        <h3 class="text-lg font-semibold text-sophisticated-dark mb-2 line-clamp-2 h-14"><?= e($product['name']) ?></h3>
                        <p class="text-sophisticated-muted text-sm mb-4 line-clamp-3 h-20"><?= e(substr($product['description'], 0, 120)) ?>...</p>
                    </div>
                    
                    <!-- Price, Rating & Buttons (Aligned to bottom) -->
                    <div class="mt-auto">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xl font-bold text-sophisticated-dark"><?= formatPrice($product['price']) ?></span>
                            <div class="flex items-center text-yellow-400">
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <span class="text-sophisticated-muted text-sm ml-1">(4.8)</span>
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            <a href="/product/<?= $product['id'] ?>" class="w-full py-3 px-4 border border-sophisticated-primary text-sophisticated-primary rounded-xl font-semibold hover:bg-sophisticated-primary hover:text-white transition-all duration-200 text-center block">
                                Ver Detalhes
                            </a>
                            <?php if ($product['stock'] > 0): ?>
                            <form action="/cart/add" method="POST">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="w-full btn-primary py-3 px-4 rounded-xl font-semibold text-white">
                                    <i class="fas fa-cart-plus mr-2"></i>Adicionar ao Carrinho
                                </button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-12">
            <a href="/products" class="btn-primary px-8 py-4 rounded-full text-white font-semibold text-lg inline-flex items-center">
                Ver Todos os Produtos
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Categories -->
<section class="py-20 bg-sophisticated-gray">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-sophisticated-dark mb-4">Explore por Categoria</h2>
            <p class="text-xl text-sophisticated-muted max-w-2xl mx-auto">
                Encontre exatamente o que você procura em nossas categorias especializadas
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            $category_colors = [
                'bg-gradient-to-br from-accent-blue to-sky-400',
                'bg-gradient-to-br from-accent-green to-emerald-400',
                'bg-gradient-to-br from-accent-yellow to-amber-400',
                'bg-gradient-to-br from-accent-purple to-violet-400',
                'bg-gradient-to-br from-accent-pink to-rose-400',
                'bg-gradient-to-br from-accent-red to-orange-400',
            ];
            foreach ($categories as $index => $category): 
            $color_class = $category_colors[$index % count($category_colors)];
            ?>
            <div class="bg-white rounded-2xl p-8 text-center hover:shadow-lg transition-all duration-300 group">
                <div class="w-16 h-16 <?= $color_class ?> rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-mobile-alt text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-sophisticated-dark mb-2"><?= e($category['name']) ?></h3>
                <p class="text-sophisticated-muted mb-6"><?= isset($category['product_count']) ? $category['product_count'] : 0 ?> produtos disponíveis</p>
                <a href="/category/<?= $category['id'] ?>" class="inline-flex items-center text-sophisticated-primary font-semibold hover:text-sophisticated-hover transition-colors duration-200">
                    Ver Produtos
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-200"></i>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Admin Alert for Low Stock -->
<?php if (!empty($lowStockProducts)): ?>
<section class="py-8 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-amber-500 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-semibold text-amber-800 mb-2">Alerta de Estoque Baixo</h3>
                    <p class="text-amber-700 mb-3">Os seguintes produtos estão com estoque baixo:</p>
                    <ul class="space-y-1">
                        <?php foreach ($lowStockProducts as $product): ?>
                        <li class="text-amber-700">
                            <span class="font-medium"><?= e($product['name']) ?></span> - 
                            <span class="text-amber-600"><?= $product['stock'] ?> unidades restantes</span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Features -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-sophisticated-dark mb-4">Por que escolher a TechStore?</h2>
            <p class="text-xl text-sophisticated-muted max-w-2xl mx-auto">
                Oferecemos uma experiência de compra excepcional com foco na qualidade e satisfação do cliente
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <div class="text-center group">
                <div class="w-20 h-20 bg-gradient-to-br from-accent-blue to-sky-400 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-shipping-fast text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-sophisticated-dark mb-4">Entrega Rápida</h3>
                <p class="text-sophisticated-muted leading-relaxed">
                    Receba seus produtos em até 48 horas em todo o Brasil com rastreamento em tempo real.
                </p>
            </div>
            
            <div class="text-center group">
                <div class="w-20 h-20 bg-gradient-to-br from-accent-green to-emerald-400 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-shield-alt text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-sophisticated-dark mb-4">Compra Segura</h3>
                <p class="text-sophisticated-muted leading-relaxed">
                    Seus dados estão protegidos com a mais alta segurança e criptografia SSL.
                </p>
            </div>
            
            <div class="text-center group">
                <div class="w-20 h-20 bg-gradient-to-br from-accent-purple to-violet-400 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-headset text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-sophisticated-dark mb-4">Suporte 24/7</h3>
                <p class="text-sophisticated-muted leading-relaxed">
                    Nossa equipe especializada está sempre pronta para ajudar você com qualquer dúvida.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter -->
<section class="py-20 bg-gradient-to-r from-accent-blue via-accent-purple to-accent-pink">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-white mb-4">Fique por dentro das novidades</h2>
        <p class="text-xl text-white/90 mb-8">
            Receba ofertas exclusivas e seja o primeiro a conhecer nossos novos produtos
        </p>
        <form id="newsletterForm" class="flex flex-col gap-3 max-w-md mx-auto" method="POST" action="/newsletter/subscribe">
            <input type="email" name="email" required placeholder="Seu melhor e-mail" 
                   class="w-full px-4 py-3 text-base rounded-full border-0 focus:outline-none focus:ring-2 focus:ring-white/50 text-sophisticated-dark">
            <input type="text" name="phone" id="phone" required placeholder="Seu melhor número de WhatsApp" 
                   class="w-full px-4 py-3 text-base rounded-full border-0 focus:outline-none focus:ring-2 focus:ring-white/50 text-sophisticated-dark">
            <button type="submit" class="w-full px-6 py-3 text-base bg-gradient-to-r from-yellow-400 via-orange-500 to-red-500 text-white rounded-full font-bold hover:from-yellow-300 hover:via-orange-400 hover:to-red-400 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl animate-pulse">
                <i class="fas fa-gift mr-2"></i>Inscrever-se e Ganhar Ofertas!
            </button>
        </form>
        
        <!-- Mensagem de resultado da newsletter -->
        <div id="newsletterMessage" class="max-w-md mx-auto mt-4 hidden">
            <div id="newsletterMessageContent" class="p-4 rounded-xl"></div>
        </div>

        <script>
        // Máscara para telefone
        document.getElementById('phone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            // Limitar a 11 dígitos (DDD + 9 dígitos)
            if (value.length > 11) {
                value = value.substring(0, 11);
            }
            
            // Aplicar máscara
            if (value.length > 0) {
                if (value.length <= 2) {
                    value = `(${value}`;
                } else if (value.length <= 7) {
                    value = `(${value.substring(0, 2)}) ${value.substring(2)}`;
                } else if (value.length <= 11) {
                    value = `(${value.substring(0, 2)}) ${value.substring(2, 3)} ${value.substring(3, 7)}-${value.substring(7)}`;
                }
            }
            
            e.target.value = value;
        });

        // AJAX para formulário da newsletter
        document.getElementById('newsletterForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const messageDiv = document.getElementById('newsletterMessage');
            const messageContent = document.getElementById('newsletterMessageContent');
            const submitButton = this.querySelector('button[type="submit"]');
            
            // Desabilitar botão e mostrar loading
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processando...';
            
            fetch('/newsletter/subscribe', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Mostrar mensagem
                messageContent.className = `p-4 rounded-xl ${data.success ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`;
                messageContent.textContent = data.message;
                messageDiv.classList.remove('hidden');
                
                // Se sucesso, limpar formulário
                if (data.success) {
                    this.reset();
                }
                
                // Scroll suave para a mensagem
                messageDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            })
            .catch(error => {
                messageContent.className = 'p-4 rounded-xl bg-red-100 text-red-800';
                messageContent.textContent = 'Erro ao processar inscrição. Tente novamente.';
                messageDiv.classList.remove('hidden');
            })
            .finally(() => {
                // Reabilitar botão
                submitButton.disabled = false;
                submitButton.innerHTML = '<i class="fas fa-gift mr-2"></i>Inscrever-se e Ganhar Ofertas!';
            });
        });
        </script>
    </div>
</section>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?> 