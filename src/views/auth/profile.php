<?php $pageTitle = 'Meu Perfil'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-sophisticated-dark mb-2">Meu Perfil</h1>
        <p class="text-sophisticated-muted">Gerencie suas informações pessoais e preferências</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Profile Card -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-sophisticated-border overflow-hidden">
                <div class="p-6 border-b border-sophisticated-border">
                    <h2 class="text-xl font-semibold text-sophisticated-dark">Informações Pessoais</h2>
                    <p class="text-sophisticated-muted text-sm mt-1">Atualize seus dados de contato</p>
                </div>
                
                <div class="p-6">
                    <form action="/profile" method="POST" class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-sophisticated-text mb-2">Nome Completo</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-sophisticated-muted"></i>
                                </div>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="<?= e($user['name']) ?>" 
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
                                       value="<?= e($user['email']) ?>" 
                                       required
                                       class="w-full pl-10 pr-4 py-3 border border-sophisticated-border rounded-xl focus:outline-none focus:ring-2 focus:ring-sophisticated-primary focus:border-transparent transition-all duration-200"
                                       placeholder="seu@email.com">
                            </div>
                        </div>
                        
                        <div class="pt-4">
                            <button type="submit" class="w-full btn-primary py-3 px-4 rounded-xl font-semibold text-white">
                                <i class="fas fa-save mr-2"></i>
                                Atualizar Perfil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Change Password Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-sophisticated-border mt-6 overflow-hidden">
                <div class="p-6 border-b border-sophisticated-border">
                    <h2 class="text-xl font-semibold text-sophisticated-dark">Alterar Senha</h2>
                    <p class="text-sophisticated-muted text-sm mt-1">Mantenha sua conta segura</p>
                </div>
                
                <div class="p-6">
                    <form action="/profile/change-password" method="POST" class="space-y-6">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-sophisticated-text mb-2">Senha Atual</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-sophisticated-muted"></i>
                                </div>
                                <input type="password" 
                                       id="current_password" 
                                       name="current_password" 
                                       required
                                       class="w-full pl-10 pr-4 py-3 border border-sophisticated-border rounded-xl focus:outline-none focus:ring-2 focus:ring-sophisticated-primary focus:border-transparent transition-all duration-200"
                                       placeholder="Sua senha atual">
                            </div>
                        </div>
                        
                        <div>
                            <label for="new_password" class="block text-sm font-medium text-sophisticated-text mb-2">Nova Senha</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-key text-sophisticated-muted"></i>
                                </div>
                                <input type="password" 
                                       id="new_password" 
                                       name="new_password" 
                                       required
                                       class="w-full pl-10 pr-4 py-3 border border-sophisticated-border rounded-xl focus:outline-none focus:ring-2 focus:ring-sophisticated-primary focus:border-transparent transition-all duration-200"
                                       placeholder="Mínimo 6 caracteres">
                            </div>
                            <p class="text-xs text-sophisticated-muted mt-1">A nova senha deve ter pelo menos 6 caracteres</p>
                        </div>
                        
                        <div>
                            <label for="confirm_new_password" class="block text-sm font-medium text-sophisticated-text mb-2">Confirmar Nova Senha</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-key text-sophisticated-muted"></i>
                                </div>
                                <input type="password" 
                                       id="confirm_new_password" 
                                       name="confirm_new_password" 
                                       required
                                       class="w-full pl-10 pr-4 py-3 border border-sophisticated-border rounded-xl focus:outline-none focus:ring-2 focus:ring-sophisticated-primary focus:border-transparent transition-all duration-200"
                                       placeholder="Confirme a nova senha">
                            </div>
                        </div>
                        
                        <div class="pt-4">
                            <button type="submit" class="w-full py-3 px-4 border border-sophisticated-primary text-sophisticated-primary rounded-xl font-semibold hover:bg-sophisticated-primary hover:text-white transition-all duration-200">
                                <i class="fas fa-key mr-2"></i>
                                Alterar Senha
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Profile Summary -->
            <div class="bg-white rounded-2xl shadow-sm border border-sophisticated-border p-6 mb-6">
                <div class="text-center mb-6">
                    <div class="w-20 h-20 bg-gradient-to-br from-sophisticated-primary to-sophisticated-accent rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white text-2xl font-semibold"><?= strtoupper(substr($user['name'], 0, 1)) ?></span>
                    </div>
                    <h3 class="text-lg font-semibold text-sophisticated-dark"><?= e($user['name']) ?></h3>
                    <p class="text-sophisticated-muted text-sm"><?= e($user['email']) ?></p>
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between py-2 border-b border-sophisticated-border">
                        <span class="text-sophisticated-muted text-sm">Membro desde</span>
                        <span class="text-sophisticated-dark font-medium text-sm"><?= date('M Y', strtotime($user['created_at'] ?? 'now')) ?></span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-sophisticated-border">
                        <span class="text-sophisticated-muted text-sm">Último login</span>
                        <span class="text-sophisticated-dark font-medium text-sm">Hoje</span>
                    </div>
                    <div class="flex items-center justify-between py-2">
                        <span class="text-sophisticated-muted text-sm">Status</span>
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">Ativo</span>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-sm border border-sophisticated-border p-6">
                <h3 class="text-lg font-semibold text-sophisticated-dark mb-4">Ações Rápidas</h3>
                <div class="space-y-3">
                    <a href="/orders" class="flex items-center p-3 text-sophisticated-text hover:bg-sophisticated-gray rounded-xl transition-colors duration-200">
                        <i class="fas fa-box text-sophisticated-primary mr-3"></i>
                        <span>Meus Pedidos</span>
                    </a>
                    <a href="/cart" class="flex items-center p-3 text-sophisticated-text hover:bg-sophisticated-gray rounded-xl transition-colors duration-200">
                        <i class="fas fa-shopping-cart text-sophisticated-primary mr-3"></i>
                        <span>Carrinho</span>
                    </a>
                    <a href="/products" class="flex items-center p-3 text-sophisticated-text hover:bg-sophisticated-gray rounded-xl transition-colors duration-200">
                        <i class="fas fa-shopping-bag text-sophisticated-primary mr-3"></i>
                        <span>Ver Produtos</span>
                    </a>
                </div>
            </div>
            
            <!-- Security Notice -->
            <div class="mt-6 bg-green-50 border border-green-200 rounded-xl p-4">
                <div class="flex items-start">
                    <i class="fas fa-shield-alt text-green-500 mt-1 mr-3"></i>
                    <div>
                        <h4 class="font-semibold text-green-800 mb-1">Conta Segura</h4>
                        <p class="text-sm text-green-700">Suas informações estão protegidas com criptografia SSL.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?> 