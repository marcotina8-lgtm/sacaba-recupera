<?php require __DIR__ . '/../layouts/header.php'; ?>
<div class="form-container">
    <h2>Iniciar Sesión</h2>
    <?php if (isset($_GET['registrado'])): ?>
        <p class="alert-success">Cuenta creada correctamente. Ya puedes iniciar sesión.</p>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <p class="alert-error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form action="index.php?url=auth/login" method="POST">
        <div class="form-group">
            <label>Correo Electrónico:</label>
            <input type="email" name="email" required placeholder="usuario@ejemplo.com">
        </div>
        <div class="form-group">
            <label>Contraseña:</label>
            <input type="password" name="password" required placeholder="Tu contraseña">
        </div>
        <button type="submit" class="btn-submit">Ingresar al Sistema</button>
    </form>
    <p class="text-sm">¿No tienes cuenta? <a href="index.php?url=auth/register">Regístrate aquí</a></p>
</div>
<?php require __DIR__ . '/../layouts/footer.php'; ?>