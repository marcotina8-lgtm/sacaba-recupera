<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sacaba Recupera - Objetos y Documentos Extraviados</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <header class="navbar">
        <div class="logo">
            <a href="index.php?url=reportes/index"><strong>SACABA RECUPERA</strong></a>
        </div>
        <nav class="nav-links">
            <a href="index.php?url=reportes/index">Inicio / Explorar</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="index.php?url=reportes/crear" class="btn-primary">+ Nuevo Reporte</a>
                <span class="user-tag">Hola, <?= htmlspecialchars($_SESSION['user_name']) ?> (<?= htmlspecialchars($_SESSION['user_role']) ?>)</span>
                <a href="index.php?url=auth/logout" class="btn-link">Salir</a>
            <?php else: ?>
                <a href="index.php?url=auth/login">Iniciar Sesión</a>
                <a href="index.php?url=auth/register" class="btn-primary">Registrarse</a>
            <?php endif; ?>
        </nav>
    </header>
    <main class="container">