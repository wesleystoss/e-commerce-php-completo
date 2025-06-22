<?php 
$pageTitle = 'Página não encontrada';

// Buscar produtos recomendados para mostrar na página 404
$productModel = new \App\Models\Product();
$recommendedProducts = $productModel->getAll(4, 0); // Pegar 4 produtos mais recentes
?>

<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<main class="pt-16">
    <!-- Seção de erro 404 -->
    <div class="bg-sophisticated-gray py-16">
        <div class="max-w-4xl mx-auto px-4">
            <div class="text-center mb-12">
                <!-- Ícone de erro -->
                <div class="mb-8">
                    <div class="w-24 h-24 mx-auto bg-gradient-to-br from-accent-red/10 to-accent-red/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-4xl text-accent-red"></i>
                    </div>
                </div>
                
                <!-- Número 404 -->
                <h1 class="text-8xl font-bold text-sophisticated-muted mb-4">404</h1>
                
                <!-- Título -->
                <h2 class="text-3xl font-semibold text-sophisticated-dark mb-4">Página não encontrada</h2>
                
                <!-- Descrição -->
                <p class="text-sophisticated-muted mb-8 text-lg leading-relaxed max-w-2xl mx-auto">
                    A página que você está procurando não existe, mas não se preocupe! 
                    Enquanto isso, que tal dar uma olhada em alguns dos nossos produtos mais populares?
                </p>
                
                <!-- Botão principal -->
                <a href="/" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-sophisticated-primary to-sophisticated-accent text-white font-semibold rounded-lg hover:from-sophisticated-accent hover:to-sophisticated-primary transition-all duration-200 hover:shadow-lg hover:-translate-y-0.5 mb-6">
                    <i class="fas fa-home mr-2"></i>
                    Voltar ao Início
                </a>
            </div>
        </div>
    </div>

    <!-- Seção de produtos recomendados -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Cabeçalho da seção -->
            <div class="text-center mb-12">
                <h3 class="text-3xl font-bold text-sophisticated-dark mb-4">
                    Produtos que você pode gostar
                </h3>
                <p class="text-sophisticated-muted text-lg max-w-2xl mx-auto">
                    Descubra nossa seleção de produtos mais populares e encontre exatamente o que você procura
                </p>
            </div>

            <!-- Grid de produtos -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <?php foreach ($recommendedProducts as $product): ?>
                <div class="product-card bg-white rounded-xl shadow-sm border border-sophisticated-border overflow-hidden hover:shadow-lg transition-all duration-300">
                    <!-- Imagem do produto -->
                    <div class="aspect-square bg-sophisticated-light flex items-center justify-center overflow-hidden">
                        <?php if ($product['image_url']): ?>
                            <img src="<?= e($product['image_url']) ?>" 
                                 alt="<?= e($product['name']) ?>" 
                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                        <?php else: ?>
                            <div class="w-full h-full bg-gradient-to-br from-sophisticated-light to-sophisticated-border flex items-center justify-center">
                                <i class="fas fa-image text-4xl text-sophisticated-muted"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Informações do produto -->
                    <div class="p-4">
                        <!-- Categoria -->
                        <div class="mb-2">
                            <span class="inline-block px-2 py-1 text-xs font-medium rounded-full <?= getCategoryColorClass($product['category_id']) ?>">
                                <?= e($product['category_name']) ?>
                            </span>
                        </div>
                        
                        <!-- Nome do produto -->
                        <h4 class="font-semibold text-sophisticated-dark mb-2 line-clamp-2">
                            <?= e($product['name']) ?>
                        </h4>
                        
                        <!-- Preço -->
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xl font-bold text-sophisticated-dark">
                                <?= formatPrice($product['price']) ?>
                            </span>
                            <?php if ($product['stock'] > 0): ?>
                                <span class="text-xs text-accent-green bg-accent-green/10 px-2 py-1 rounded-full">
                                    Em estoque
                                </span>
                            <?php else: ?>
                                <span class="text-xs text-accent-red bg-accent-red/10 px-2 py-1 rounded-full">
                                    Sem estoque
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Botões de ação -->
                        <div class="flex space-x-2">
                            <a href="/product/<?= $product['id'] ?>" 
                               class="flex-1 bg-sophisticated-light text-sophisticated-dark text-center py-2 px-3 rounded-lg hover:bg-sophisticated-primary hover:text-white transition-colors duration-200 text-sm font-medium">
                                Ver detalhes
                            </a>
                            
                            <?php if ($product['stock'] > 0): ?>
                            <form action="/cart/add" method="POST" class="flex-1">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" 
                                        class="w-full bg-gradient-to-r from-sophisticated-primary to-sophisticated-accent text-white py-2 px-3 rounded-lg hover:from-sophisticated-accent hover:to-sophisticated-primary transition-all duration-200 text-sm font-medium">
                                    <i class="fas fa-shopping-cart mr-1"></i>
                                    Comprar
                                </button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Call-to-action -->
            <div class="text-center">
                <div class="bg-gradient-to-r from-sophisticated-light to-sophisticated-border rounded-2xl p-8">
                    <h4 class="text-2xl font-bold text-sophisticated-dark mb-4">
                        Não encontrou o que procurava?
                    </h4>
                    <p class="text-sophisticated-muted mb-6 max-w-2xl mx-auto">
                        Explore nossa coleção completa de produtos e descubra ofertas incríveis. 
                        Temos certeza de que você vai encontrar algo especial!
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="/products" 
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-sophisticated-primary to-sophisticated-accent text-white font-semibold rounded-lg hover:from-sophisticated-accent hover:to-sophisticated-primary transition-all duration-200 hover:shadow-lg">
                            <i class="fas fa-shopping-bag mr-2"></i>
                            Ver todos os produtos
                        </a>
                        <a href="/search" 
                           class="inline-flex items-center px-6 py-3 border-2 border-sophisticated-primary text-sophisticated-primary font-semibold rounded-lg hover:bg-sophisticated-primary hover:text-white transition-all duration-200">
                            <i class="fas fa-search mr-2"></i>
                            Buscar produtos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Seção de navegação rápida -->
    <div class="bg-sophisticated-gray py-12">
        <div class="max-w-4xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Categorias populares -->
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto bg-gradient-to-br from-accent-blue/10 to-accent-blue/20 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-tags text-2xl text-accent-blue"></i>
                    </div>
                    <h5 class="font-semibold text-sophisticated-dark mb-2">Categorias</h5>
                    <p class="text-sophisticated-muted text-sm mb-4">Explore por categoria</p>
                    <a href="/products" class="text-sophisticated-primary hover:text-sophisticated-dark transition-colors duration-200 text-sm font-medium">
                        Ver categorias →
                    </a>
                </div>
                
                <!-- Ofertas especiais -->
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto bg-gradient-to-br from-accent-red/10 to-accent-red/20 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-fire text-2xl text-accent-red"></i>
                    </div>
                    <h5 class="font-semibold text-sophisticated-dark mb-2">Ofertas</h5>
                    <p class="text-sophisticated-muted text-sm mb-4">Produtos em promoção</p>
                    <a href="/products" class="text-sophisticated-primary hover:text-sophisticated-dark transition-colors duration-200 text-sm font-medium">
                        Ver ofertas →
                    </a>
                </div>
                
                <!-- Suporte -->
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto bg-gradient-to-br from-accent-green/10 to-accent-green/20 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-headset text-2xl text-accent-green"></i>
                    </div>
                    <h5 class="font-semibold text-sophisticated-dark mb-2">Suporte</h5>
                    <p class="text-sophisticated-muted text-sm mb-4">Precisa de ajuda?</p>
                    <a href="/contact" class="text-sophisticated-primary hover:text-sophisticated-dark transition-colors duration-200 text-sm font-medium">
                        Fale conosco →
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?> 