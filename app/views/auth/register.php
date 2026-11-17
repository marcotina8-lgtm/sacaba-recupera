<?php require __DIR__ . '/../layouts/header.php'; ?>
<div class="form-container">
    <h2>Crear Cuenta</h2>
    <?php if (!empty($error)): ?>
        <p class="alert-error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form action="index.php?url=auth/register" method="POST">
        <div class="form-group">
            <label>Nombre Completo:</label>
            <input type="text" name="nombre" required placeholder="Ej: Benito Gonzales">
        </div>
        <div class="form-group">
            <label>Correo Electrónico:</label>
            <input type="email" name="email" required placeholder="correo@ejemplo.com">
        </div>
        <div class="form-group">
            <label>Teléfono / Celular (WhatsApp):</label>
            <input type="text" name="telefono" required placeholder="Ej: 71234567">
        </div>
        <div class="form-group">
            <label>Rol en la Plataforma:</label>
            <select name="rol">
                <option value="ciudadano">Ciudadano / Pasajero</option>
                <option value="conductor">Conductor de Transporte Público</option>
            </select>
        </div>
        <div class="form-group">
            <label>Contraseña (mínimo 6 caracteres):</label>
            <input type="password" name="password" required minlength="6">
        </div>
        <button type="submit" class="btn-submit">Registrarme</button>
    </form>
    <p class="text-sm">¿Ya tienes cuenta? <a href="index.php?url=auth/login">Inicia sesión aquí</a></p>
</div>
<?php require __DIR__ . '/../layouts/footer.php'; ?>