<?php 
$pageTitle = 'Contato';

// Garantir que a função e() está disponível
if (!function_exists('e')) {
    function e($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}
?>
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
    </style>
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
                            <a href="/products" class="block px-4 py-3 text-sophisticated-text hover:bg-sophisticated-gray first:rounded-t-xl last:rounded-b-xl transition-colors duration-150">
                                Todos os Produtos
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Search, Cart, and User -->
                <div class="flex items-center space-x-4">
                    <!-- Search -->
                    <form action="/search" method="GET" class="hidden sm:block">
                        <div class="relative">
                            <input type="search" name="q" placeholder="Buscar produtos..." 
                                   class="w-64 pl-10 pr-4 py-2 bg-sophisticated-light border-0 rounded-full focus:outline-none focus:ring-2 focus:ring-sophisticated-primary focus:bg-white transition-all duration-200">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-sophisticated-muted"></i>
                        </div>
                    </form>
                    
                    <!-- Cart -->
                    <div class="relative">
                        <a href="/cart" class="p-2 text-sophisticated-text hover:text-sophisticated-primary transition-colors duration-200">
                            <i class="fas fa-shopping-bag text-lg"></i>
                        </a>
                    </div>
                    
                    <!-- User Menu -->
                    <a href="/login" class="text-sophisticated-text hover:text-sophisticated-primary transition-colors duration-200 font-medium">Entrar</a>
                    <a href="/register" class="btn-primary px-6 py-2 rounded-full text-white font-medium">Cadastrar</a>
                    
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
                <form action="/search" method="GET" class="pt-2">
                    <input type="search" name="q" placeholder="Buscar produtos..." 
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

        <!-- Hero Section -->
        <div class="bg-gradient-to-br from-sophisticated-gray to-sophisticated-light py-16">
            <div class="max-w-4xl mx-auto px-4 text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-sophisticated-dark mb-6">
                    Entre em Contato
                </h1>
                <p class="text-xl text-sophisticated-muted leading-relaxed max-w-2xl mx-auto">
                    Estamos aqui para ajudar! Entre em contato conosco para dúvidas, suporte ou parcerias.
                </p>
            </div>
        </div>

        <!-- Conteúdo Principal -->
        <div class="py-16">
            <div class="max-w-7xl mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    
                    <!-- Formulário de Contato -->
                    <div class="bg-white rounded-2xl shadow-sm border border-sophisticated-border p-8">
                        <h2 class="text-2xl font-bold text-sophisticated-dark mb-6">
                            Envie sua mensagem
                        </h2>
                        
                        <form method="POST" action="/contact" class="space-y-6">
                            <!-- Nome e Email -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-sophisticated-dark mb-2">
                                        Nome completo *
                                    </label>
                                    <input type="text" 
                                           id="name" 
                                           name="name" 
                                           required
                                           value="<?= e($_POST['name'] ?? '') ?>"
                                           class="w-full px-4 py-3 border border-sophisticated-border rounded-lg focus:ring-2 focus:ring-sophisticated-primary focus:border-transparent transition-all duration-200"
                                           placeholder="Seu nome completo">
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-sophisticated-dark mb-2">
                                        Email *
                                    </label>
                                    <input type="email" 
                                           id="email" 
                                           name="email" 
                                           required
                                           value="<?= e($_POST['email'] ?? '') ?>"
                                           class="w-full px-4 py-3 border border-sophisticated-border rounded-lg focus:ring-2 focus:ring-sophisticated-primary focus:border-transparent transition-all duration-200"
                                           placeholder="seu@email.com">
                                </div>
                            </div>

                            <!-- Mensagem -->
                            <div>
                                <label for="message" class="block text-sm font-medium text-sophisticated-dark mb-2">
                                    Mensagem *
                                </label>
                                <textarea id="message" 
                                          name="message" 
                                          rows="6" 
                                          required
                                          class="w-full px-4 py-3 border border-sophisticated-border rounded-lg focus:ring-2 focus:ring-sophisticated-primary focus:border-transparent transition-all duration-200 resize-none"
                                          placeholder="Descreva sua dúvida ou solicitação..."><?= e($_POST['message'] ?? '') ?></textarea>
                            </div>

                            <!-- Botão de Envio -->
                            <button type="submit" 
                                    class="w-full bg-gradient-to-r from-sophisticated-primary to-sophisticated-accent text-white font-semibold py-4 px-6 rounded-lg hover:from-sophisticated-accent hover:to-sophisticated-primary transition-all duration-200 hover:shadow-lg hover:-translate-y-0.5">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Enviar mensagem
                            </button>
                        </form>
                    </div>

                    <!-- Informações de Contato -->
                    <div class="bg-white rounded-2xl shadow-sm border border-sophisticated-border p-8">
                        <h2 class="text-2xl font-bold text-sophisticated-dark mb-6">
                            Informações de contato
                        </h2>
                        
                        <div class="space-y-6">
                            <!-- Email -->
                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-accent-blue/10 to-accent-blue/20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-envelope text-xl text-accent-blue"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-sophisticated-dark mb-1">Email</h3>
                                    <p class="text-sophisticated-muted mb-2">contato@techstore.com</p>
                                    <p class="text-sophisticated-muted mb-2">suporte@techstore.com</p>
                                    <p class="text-sm text-sophisticated-muted">Resposta em até 24 horas</p>
                                </div>
                            </div>

                            <!-- Telefone -->
                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-accent-green/10 to-accent-green/20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-phone text-xl text-accent-green"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-sophisticated-dark mb-1">Telefone</h3>
                                    <p class="text-sophisticated-muted mb-2">(11) 99999-9999</p>
                                    <p class="text-sophisticated-muted mb-2">(11) 88888-8888</p>
                                    <p class="text-sm text-sophisticated-muted">Segunda a sexta, 8h às 18h</p>
                                </div>
                            </div>

                            <!-- Endereço -->
                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-accent-purple/10 to-accent-purple/20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-map-marker-alt text-xl text-accent-purple"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-sophisticated-dark mb-1">Endereço</h3>
                                    <p class="text-sophisticated-muted mb-2">
                                        Rua das Tecnologias, 123<br>
                                        Bairro da Inovação<br>
                                        São Paulo - SP, 01234-567
                                    </p>
                                    <p class="text-sm text-sophisticated-muted">Próximo ao metrô</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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