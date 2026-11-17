<?php require __DIR__ . '/../layouts/header.php'; ?>
<div class="form-container">
    <h2>Publicar Pérdida o Hallazgo</h2>
    <?php if (!empty($error)): ?>
        <p class="alert-error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form action="index.php?url=reportes/crear" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Tipo de Publicación:</label>
            <select name="tipo" required>
                <option value="perdida">He extraviado algo (Pérdida)</option>
                <option value="hallazgo">He encontrado algo (Hallazgo)</option>
            </select>
        </div>
        <div class="form-group">
            <label>Título Breve:</label>
            <input type="text" name="titulo" placeholder="Ej: Celular marca Infinix o Carnet de Identidad" required>
        </div>
        <div class="form-group">
            <label>Categoría:</label>
            <select name="categoria" required>
                <option value="documento">Documento Personal / Carnet</option>
                <option value="celular">Celular / Tablet</option>
                <option value="billetera">Billetera / Cartera</option>
                <option value="objeto">Mochila / Ropa / Equipaje</option>
                <option value="otro">Otro</option>
            </select>
        </div>
        <div class="form-group">
            <label>Lugar o Ruta de Transporte:</label>
            <input type="text" name="lugar_ruta" placeholder="Ej: Trufi 241 / Parada Plaza Principal de Sacaba" required>
        </div>
        <div class="form-group">
            <label>Fecha del Suceso:</label>
            <input type="date" name="fecha_evento" required value="<?= date('Y-m-d') ?>">
        </div>
        <div class="form-group">
            <label>Descripción detallada (evitar mostrar números sensibles completos):</label>
            <textarea name="descripcion" rows="4" placeholder="Describe color, características particulares o detalles para verificar propiedad..." required></textarea>
        </div>
        <div class="form-group">
            <label>Fotografía (Opcional - protege datos personales):</label>
            <input type="file" name="imagen" accept="image/*">
        </div>
        <button type="submit" class="btn-submit">Publicar Reporte</button>
    </form>
</div>
<?php require __DIR__ . '/../layouts/footer.php'; ?>