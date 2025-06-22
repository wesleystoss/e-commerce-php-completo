<?php $pageTitle = 'Cadastrar'; ?>
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
            <h2 class="text-3xl font-bold text-sophisticated-dark mb-2">Criar conta</h2>
            <p class="text-sophisticated-muted">Junte-se à TechStore e descubra produtos incríveis</p>
        </div>
        
        <!-- Register Form -->
        <div class="bg-white rounded-2xl shadow-sm border border-sophisticated-border p-8">
            <form action="/register" method="POST" class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-sophisticated-text mb-2">Nome Completo</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-sophisticated-muted"></i>
                        </div>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="<?= e($_POST['name'] ?? '') ?>"
                               required 
                               autofocus
                               class="w-full pl-10 pr-4 py-3 border border-sophisticated-border rounded-xl focus:outline-none focus:ring-2 focus:ring-sophisticated-primary focus:border-transparent transition-all duration-200"
                               placeholder="Seu nome completo">
                    </div>
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-sophisticated-text mb-2">E-mail</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-sophisticated-muted"></i>
                        </div>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="<?= e($_POST['email'] ?? '') ?>"
                               required
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
                               placeholder="Mínimo 6 caracteres">
                    </div>
                    <p class="text-xs text-sophisticated-muted mt-1">A senha deve ter pelo menos 6 caracteres</p>
                </div>
                
                <div>
                    <label for="confirm_password" class="block text-sm font-medium text-sophisticated-text mb-2">Confirmar Senha</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-sophisticated-muted"></i>
                        </div>
                        <input type="password" 
                               id="confirm_password" 
                               name="confirm_password" 
                               required
                               class="w-full pl-10 pr-4 py-3 border border-sophisticated-border rounded-xl focus:outline-none focus:ring-2 focus:ring-sophisticated-primary focus:border-transparent transition-all duration-200"
                               placeholder="Confirme sua senha">
                    </div>
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" 
                           id="terms" 
                           name="terms" 
                           required
                           class="rounded border-sophisticated-border text-sophisticated-primary focus:ring-sophisticated-primary">
                    <label for="terms" class="ml-2 text-sm text-sophisticated-text">
                        Concordo com os 
                        <a href="/terms" class="text-sophisticated-primary hover:text-sophisticated-hover transition-colors duration-200">Termos de Uso</a> 
                        e 
                        <a href="/privacy" class="text-sophisticated-primary hover:text-sophisticated-hover transition-colors duration-200">Política de Privacidade</a>
                    </label>
                </div>
                
                <button type="submit" class="w-full btn-primary py-3 px-4 rounded-xl font-semibold text-white">
                    <i class="fas fa-user-plus mr-2"></i>
                    Criar Conta
                </button>
            </form>
            
            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-sophisticated-border"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-sophisticated-muted">ou cadastre-se com</span>
                </div>
            </div>
            
            <!-- Social Register -->
            <div class="space-y-3">
                <button type="button" class="w-full py-3 px-4 border border-sophisticated-border text-sophisticated-text rounded-xl font-semibold hover:bg-sophisticated-gray transition-colors duration-200 flex items-center justify-center">
                    <i class="fab fa-google mr-3 text-red-500"></i>
                    Cadastrar com Google
                </button>
                <button type="button" class="w-full py-3 px-4 border border-sophisticated-border text-sophisticated-text rounded-xl font-semibold hover:bg-sophisticated-gray transition-colors duration-200 flex items-center justify-center">
                    <i class="fab fa-facebook mr-3 text-blue-600"></i>
                    Cadastrar com Facebook
                </button>
            </div>
        </div>
        
        <!-- Login Link -->
        <div class="text-center">
            <p class="text-sophisticated-muted">
                Já tem uma conta? 
                <a href="/login" class="text-sophisticated-primary hover:text-sophisticated-hover font-semibold transition-colors duration-200">
                    Entrar
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