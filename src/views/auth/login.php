<?php $pageTitle = 'Entrar'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="min-h-screen bg-sophisticated-gray flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <div class="flex justify-center mb-6">
                <div class="w-16 h-16 bg-gradient-to-br from-sophisticated-primary to-sophisticated-accent rounded-2xl flex items-center justify-center">
                    <i class="fas fa-cube text-white text-2xl"></i>
                </div>
            </div>
            <h2 class="text-3xl font-bold text-sophisticated-dark mb-2">Bem-vindo de volta</h2>
            <p class="text-sophisticated-muted">Entre na sua conta para continuar</p>
        </div>
        
        <!-- Login Form -->
        <div class="bg-white rounded-2xl shadow-sm border border-sophisticated-border p-8">
            <form action="/login" method="POST" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-sophisticated-text mb-2">E-mail</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-sophisticated-muted"></i>
                        </div>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               required 
                               autofocus
                               class="w-full pl-10 pr-4 py-3 border border-sophisticated-border rounded-xl focus:outline-none focus:ring-2 focus:ring-sophisticated-primary focus:border-transparent transition-all duration-200"
                               placeholder="seu@email.com">
                    </div>
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-sophisticated-text mb-2">Senha</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-sophisticated-muted"></i>
                        </div>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               required
                               class="w-full pl-10 pr-4 py-3 border border-sophisticated-border rounded-xl focus:outline-none focus:ring-2 focus:ring-sophisticated-primary focus:border-transparent transition-all duration-200"
                               placeholder="Sua senha">
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="rounded border-sophisticated-border text-sophisticated-primary focus:ring-sophisticated-primary">
                        <span class="ml-2 text-sm text-sophisticated-text">Lembrar de mim</span>
                    </label>
                    <a href="/forgot-password" class="text-sm text-sophisticated-primary hover:text-sophisticated-hover transition-colors duration-200">
                        Esqueceu a senha?
                    </a>
                </div>
                
                <button type="submit" class="w-full btn-primary py-3 px-4 rounded-xl font-semibold text-white">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Entrar
                </button>
            </form>
            
            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-sophisticated-border"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-sophisticated-muted">ou continue com</span>
                </div>
            </div>
            
            <!-- Social Login -->
            <div class="space-y-3">
                <button type="button" class="w-full py-3 px-4 border border-sophisticated-border text-sophisticated-text rounded-xl font-semibold hover:bg-sophisticated-gray transition-colors duration-200 flex items-center justify-center">
                    <i class="fab fa-google mr-3 text-red-500"></i>
                    Continuar com Google
                </button>
                <button type="button" class="w-full py-3 px-4 border border-sophisticated-border text-sophisticated-text rounded-xl font-semibold hover:bg-sophisticated-gray transition-colors duration-200 flex items-center justify-center">
                    <i class="fab fa-facebook mr-3 text-blue-600"></i>
                    Continuar com Facebook
                </button>
            </div>
        </div>
        
        <!-- Sign Up Link -->
        <div class="text-center">
            <p class="text-sophisticated-muted">
                Não tem uma conta? 
                <a href="/register" class="text-sophisticated-primary hover:text-sophisticated-hover font-semibold transition-colors duration-200">
                    Cadastre-se
                </a>
            </p>
        </div>
        
        <!-- Back to Home -->
        <div class="text-center">
            <a href="/" class="text-sophisticated-muted hover:text-sophisticated-primary transition-colors duration-200 inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Voltar ao início
            </a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?> 