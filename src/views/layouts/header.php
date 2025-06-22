<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? e($pageTitle) . ' - ' : '' ?>TechStore</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts - Inter (Apple-like font) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sf': ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        'sophisticated-gray': '#f8fafc',
                        'sophisticated-dark': '#1e293b',
                        'sophisticated-accent': '#64748b',
                        'sophisticated-primary': '#475569',
                        'sophisticated-hover': '#334155',
                        'sophisticated-light': '#e2e8f0',
                        'sophisticated-border': '#cbd5e1',
                        'sophisticated-text': '#475569',
                        'sophisticated-muted': '#94a3b8',
                        'accent-red': '#ef4444',
                        'accent-green': '#22c55e',
                        'accent-blue': '#3b82f6',
                        'accent-yellow': '#eab308',
                        'accent-purple': '#8b5cf6',
                        'accent-pink': '#ec4899',
                    }
                }
            }
        }
    </script>
    
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Inter', system-ui, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        .navbar {
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            background-color: rgba(255, 255, 255, 0.9);
        }
        
        .product-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .product-card:hover {
            transform: scale(1.02);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.08), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: linear-gradient(135deg, #ef4444, #f87171);
            color: white;
            border-radius: 50%;
            padding: 4px 8px;
            font-size: 11px;
            font-weight: 600;
            min-width: 20px;
            text-align: center;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #475569, #64748b);
            border: none;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #64748b, #475569);
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(71, 85, 105, 0.2);
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        /* Utility classes */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        /* Focus styles */
        .focus-ring {
            outline: none;
            box-shadow: 0 0 0 3px rgba(71, 85, 105, 0.1);
        }
        
        /* Loading animation */
        .loading {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: .5;
            }
        }
        
        /* Hover effects */
        .hover-lift {
            transition: transform 0.2s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-2px);
        }
        
        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #475569, #64748b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
    
    <?php
    if (!function_exists('getCategoryColorClass')) {
        function getCategoryColorClass($categoryId) {
            $colors = [
                ['bg' => 'bg-accent-blue/10', 'text' => 'text-accent-blue'],
                ['bg' => 'bg-accent-green/10', 'text' => 'text-accent-green'],
                ['bg' => 'bg-accent-yellow/10', 'text' => 'text-accent-yellow'],
                ['bg' => 'bg-accent-purple/10', 'text' => 'text-accent-purple'],
                ['bg' => 'bg-accent-pink/10', 'text' => 'text-accent-pink'],
                ['bg' => 'bg-accent-red/10', 'text' => 'text-accent-red'],
            ];
            $color = $colors[($categoryId - 1) % count($colors)];
            return "{$color['bg']} {$color['text']}";
        }
    }
    ?>
</head>
<body class="bg-sophisticated-gray text-sophisticated-dark">
    <!-- Navbar -->
    <nav class="navbar fixed top-0 left-0 right-0 z-50 border-b border-sophisticated-border/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="/" class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-gradient-to-br from-sophisticated-primary to-sophisticated-accent rounded-lg flex items-center justify-center">
                        <i class="fas fa-cube text-white text-sm"></i>
                    </div>
                    <span class="text-xl font-semibold text-sophisticated-dark">TechStore</span>
                </a>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-sophisticated-text hover:text-sophisticated-primary transition-colors duration-200 font-medium">Início</a>
                    <a href="/products" class="text-sophisticated-text hover:text-sophisticated-primary transition-colors duration-200 font-medium">Produtos</a>
                    <a href="/contact" class="text-sophisticated-text hover:text-sophisticated-primary transition-colors duration-200 font-medium">Contato</a>
                    
                    <!-- Categories Dropdown -->
                    <div class="relative group">
                        <button class="text-sophisticated-text hover:text-sophisticated-primary transition-colors duration-200 font-medium flex items-center space-x-1">
                            <span>Categorias</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="absolute top-full left-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-sophisticated-border opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top">
                            <?php
                            $categoryModel = new \App\Models\Category();
                            $menuCategories = $categoryModel->getAll();
                            foreach ($menuCategories as $category):
                            ?>
                            <a href="/category/<?= $category['id'] ?>" class="block px-4 py-3 text-sophisticated-text hover:bg-sophisticated-gray first:rounded-t-xl last:rounded-b-xl transition-colors duration-150">
                                <?= e($category['name']) ?>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Search, Cart, and User -->
                <div class="flex items-center space-x-4">
                    <!-- Search -->
                    <form action="/search" method="GET" class="hidden sm:block">
                        <div class="relative">
                            <input type="search" name="q" placeholder="Buscar produtos..." 
                                   value="<?= e($_GET['q'] ?? '') ?>"
                                   class="w-64 pl-10 pr-4 py-2 bg-sophisticated-light border-0 rounded-full focus:outline-none focus:ring-2 focus:ring-sophisticated-primary focus:bg-white transition-all duration-200">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-sophisticated-muted"></i>
                        </div>
                    </form>
                    
                    <!-- Cart -->
                    <div class="relative">
                        <a href="/cart" class="p-2 text-sophisticated-text hover:text-sophisticated-primary transition-colors duration-200">
                            <i class="fas fa-shopping-bag text-lg"></i>
                            <?php
                            $cartService = new \App\Services\CartService();
                            $cartCount = $cartService->getCount();
                            if ($cartCount > 0):
                            ?>
                            <span class="cart-badge"><?= $cartCount ?></span>
                            <?php endif; ?>
                        </a>
                    </div>
                    
                    <!-- User Menu -->
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="relative group">
                            <button class="flex items-center space-x-2 p-2 text-sophisticated-text hover:text-sophisticated-primary transition-colors duration-200">
                                <div class="w-8 h-8 bg-gradient-to-br from-sophisticated-primary to-sophisticated-accent rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-medium"><?= strtoupper(substr($_SESSION['user_name'], 0, 1)) ?></span>
                                </div>
                                <span class="hidden sm:block font-medium"><?= e($_SESSION['user_name']) ?></span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            <div class="absolute top-full right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-sophisticated-border opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                <a href="/profile" class="block px-4 py-3 text-sophisticated-text hover:bg-sophisticated-gray first:rounded-t-xl transition-colors duration-150">
                                    <i class="fas fa-user mr-2"></i>Meu Perfil
                                </a>
                                <a href="/orders" class="block px-4 py-3 text-sophisticated-text hover:bg-sophisticated-gray transition-colors duration-150">
                                    <i class="fas fa-box mr-2"></i>Meus Pedidos
                                </a>
                                <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                                <div class="border-t border-sophisticated-border my-1"></div>
                                <a href="/admin" class="block px-4 py-3 text-sophisticated-text hover:bg-sophisticated-gray transition-colors duration-150">
                                    <i class="fas fa-cog mr-2"></i>Administração
                                </a>
                                <?php endif; ?>
                                <div class="border-t border-sophisticated-border my-1"></div>
                                <a href="/logout" class="block px-4 py-3 text-red-600 hover:bg-red-50 last:rounded-b-xl transition-colors duration-150">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Sair
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="/login" class="text-sophisticated-text hover:text-sophisticated-primary transition-colors duration-200 font-medium">Entrar</a>
                        <a href="/register" class="btn-primary px-6 py-2 rounded-full text-white font-medium">Cadastrar</a>
                    <?php endif; ?>
                    
                    <!-- Mobile Menu Button -->
                    <button class="md:hidden p-2 text-sophisticated-text hover:text-sophisticated-primary transition-colors duration-200" id="mobile-menu-button">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-4 py-3 space-y-3 border-t border-sophisticated-border bg-white">
                <a href="/" class="block py-2 text-sophisticated-text hover:text-sophisticated-primary transition-colors duration-200">Início</a>
                <a href="/products" class="block py-2 text-sophisticated-text hover:text-sophisticated-primary transition-colors duration-200">Produtos</a>
                <a href="/contact" class="block py-2 text-sophisticated-text hover:text-sophisticated-primary transition-colors duration-200">Contato</a>
                <div class="py-2">
                    <span class="block text-sophisticated-text font-medium mb-2">Categorias</span>
                    <?php foreach ($menuCategories as $category): ?>
                    <a href="/category/<?= $category['id'] ?>" class="block py-1 pl-4 text-sophisticated-muted hover:text-sophisticated-primary transition-colors duration-200">
                        <?= e($category['name']) ?>
                    </a>
                    <?php endforeach; ?>
                </div>
                <form action="/search" method="GET" class="pt-2">
                    <input type="search" name="q" placeholder="Buscar produtos..." 
                           value="<?= e($_GET['q'] ?? '') ?>"
                           class="w-full px-4 py-2 bg-sophisticated-light border-0 rounded-full focus:outline-none focus:ring-2 focus:ring-sophisticated-primary">
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-16">
        <!-- Flash Messages -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <span class="text-green-800"><?= $_SESSION['success'] ?></span>
                    </div>
                    <button type="button" class="text-green-500 hover:text-green-700" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                        <span class="text-red-800"><?= $_SESSION['error'] ?></span>
                    </div>
                    <button type="button" class="text-red-500 hover:text-red-700" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?> 