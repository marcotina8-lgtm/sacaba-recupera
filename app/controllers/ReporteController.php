<?php
class ReporteController {
    // Muestra el muro principal con filtros
    public function index() {
        $categoria = trim($_GET['categoria'] ?? '');
        $buscar = trim($_GET['buscar'] ?? '');

        $reporteModel = new Reporte();
        $reportes = $reporteModel->listar($categoria, $buscar);

        require __DIR__ . '/../views/reportes/index.php';
    }

    // Muestra el formulario de creación y guarda el reporte con imagen
    public function crear() {
        // Solo usuarios autenticados pueden publicar
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?url=auth/login");
            exit();
        }

        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tipo = ($_POST['tipo'] === 'hallazgo') ? 'hallazgo' : 'perdida';
            $titulo = trim($_POST['titulo'] ?? '');
            $categoria = $_POST['categoria'] ?? 'otro';
            $descripcion = trim($_POST['descripcion'] ?? '');
            $lugar_ruta = trim($_POST['lugar_ruta'] ?? '');
            $fecha_evento = $_POST['fecha_evento'] ?? date('Y-m-d');

            // Procesamiento seguro de la fotografía adjunta
            $imagenNombre = null;
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $ext = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
                $permitidas = ['jpg', 'jpeg', 'png', 'webp'];
                if (in_array($ext, $permitidas)) {
                    $uploadDir = __DIR__ . '/../../public/uploads/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    $imagenNombre = time() . '_' . uniqid() . '.' . $ext;
                    move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadDir . $imagenNombre);
                } else {
                    $error = "Formato de imagen no válido. Usa JPG, PNG o WEBP.";
                }
            }

            if (!$error) {
                $reporteModel = new Reporte();
                $reporteModel->guardar(
                    $_SESSION['user_id'],
                    $tipo,
                    $titulo,
                    $categoria,
                    $descripcion,
                    $lugar_ruta,
                    $fecha_evento,
                    $imagenNombre
                );
                header("Location: index.php?url=reportes/index");
                exit();
            }
        }
        require __DIR__ . '/../views/reportes/crear.php';
    }

    // Permite al administrador cambiar el estado del caso
    public function cambiar_estado() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            die("Acceso denegado: solo administradores.");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int) ($_POST['id'] ?? 0);
            $estado = $_POST['estado'] ?? '';
            if ($id > 0 && !empty($estado)) {
                $reporteModel = new Reporte();
                $reporteModel->cambiarEstado($id, $estado);
            }
        }
        header("Location: index.php?url=reportes/index");
        exit();
    }

    // Elimina un reporte-permitido solo para el Administrador
    public function eliminar() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            die("Acceso denegado: solo administradores pueden eliminar publicaciones.");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int) ($_POST['id'] ?? 0);
            if ($id > 0) {
                $reporteModel = new Reporte();
                $reporteModel->eliminar($id);
            }
        }
        header("Location: index.php?url=reportes/index");
        exit();
    }
}