<?php require __DIR__ . '/../layouts/header.php'; ?>

<section class="filter-section">
    <form method="GET" action="index.php" class="filter-form">
        <input type="hidden" name="url" value="reportes/index">
        <input type="text" name="buscar" placeholder="Buscar por objeto, carnet, trufi, parada..." value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>">
        <select name="categoria">
            <option value="">Todas las categorías</option>
            <option value="documento" <?= (($_GET['categoria'] ?? '') === 'documento') ? 'selected' : '' ?>>Documentos</option>
            <option value="celular" <?= (($_GET['categoria'] ?? '') === 'celular') ? 'selected' : '' ?>>Celulares</option>
            <option value="billetera" <?= (($_GET['categoria'] ?? '') === 'billetera') ? 'selected' : '' ?>>Billeteras</option>
            <option value="objeto" <?= (($_GET['categoria'] ?? '') === 'objeto') ? 'selected' : '' ?>>Mochilas / Objetos</option>
            <option value="otro" <?= (($_GET['categoria'] ?? '') === 'otro') ? 'selected' : '' ?>>Otros</option>
        </select>
        <button type="submit" class="btn-filter">Filtrar</button>
    </form>
</section>

<section class="cards-grid">
    <?php if (empty($reportes)): ?>
        <p class="no-data">No se encontraron reportes registrados con esos criterios.</p>
    <?php else: ?>
        <?php foreach ($reportes as $item): ?>
            <article class="card">
                <?php if (!empty($item['imagen'])): ?>
                    <img src="public/uploads/<?= htmlspecialchars($item['imagen']) ?>" alt="Evidencia" class="card-img">
                <?php else: ?>
                    <div class="card-img-placeholder">Sin Imagen</div>
                <?php endif; ?>
                <div class="card-body">
                    <div class="badges-row">
                        <span class="badge badge-<?= htmlspecialchars($item['tipo']) ?>"><?= strtoupper(htmlspecialchars($item['tipo'])) ?></span>
                        <span class="badge-status status-<?= htmlspecialchars($item['estado']) ?>"><?= str_replace('_', ' ', strtoupper(htmlspecialchars($item['estado']))) ?></span>
                    </div>
                    <h3><?= htmlspecialchars($item['titulo']) ?></h3>
                    <p class="meta"><strong>Lugar/Ruta:</strong> <?= htmlspecialchars($item['lugar_ruta']) ?></p>
                    <p class="meta"><strong>Fecha:</strong> <?= htmlspecialchars($item['fecha_evento']) ?></p>
                    <p class="desc"><?= nl2br(htmlspecialchars($item['descripcion'])) ?></p>
                    <hr>
                    <p class="contact-box"><strong>Contacto:</strong> <?= htmlspecialchars($item['autor']) ?> (<?= htmlspecialchars($item['telefono']) ?>)</p>

                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <form method="POST" action="index.php?url=reportes/cambiar_estado" class="admin-control">
                            <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                            <label>Estado:</label>
                            <select name="estado" onchange="this.form.submit()">
                                <option value="perdido" <?= $item['estado'] === 'perdido' ? 'selected' : '' ?>>Perdido</option>
                                <option value="encontrado" <?= $item['estado'] === 'encontrado' ? 'selected' : '' ?>>Encontrado</option>
                                <option value="en_verificacion" <?= $item['estado'] === 'en_verificacion' ? 'selected' : '' ?>>En Verificación</option>
                                <option value="devuelto" <?= $item['estado'] === 'devuelto' ? 'selected' : '' ?>>Devuelto</option>
                            </select>
                        </form>

                        <form method="POST" action="index.php?url=reportes/eliminar" onsubmit="return confirm('¿Seguro que deseas eliminar este reporte permanentemente?');" style="margin-top: 0.5rem;">
                            <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                            <button type="submit" style="background:#dc2626; color:white; border:none; padding:0.45rem 0.8rem; border-radius:4px; cursor:pointer; width:100%; font-weight:bold;">
                                Eliminar Publicación
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
</section>

<?php require __DIR__ . '/../layouts/footer.php'; ?>