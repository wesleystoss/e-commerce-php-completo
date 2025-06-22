<?php $pageTitle = 'Meu Perfil'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="mb-4 text-center">Meu Perfil</h2>
                <form action="/profile" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= e($user['name']) ?>" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= e($user['email']) ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Atualizar Perfil</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?> 