<?php
class AuthController {
    // Muestra el formulario de inicio de sesión y procesa el acceso
    public function login() {
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $usuarioModel = new Usuario();
            $user = $usuarioModel->buscarPorEmail($email);

            // Verificamos que el usuario exista y la contraseña coincida con el hash
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nombre'];
                $_SESSION['user_role'] = $user['rol'];
                header("Location: index.php?url=reportes/index");
                exit();
            } else {
                $error = "Correo o contraseña incorrectos.";
            }
        }
        require __DIR__ . '/../views/auth/login.php';
    }

    // Muestra el formulario de registro y crea cuentas nuevas
    public function register() {
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $telefono = trim($_POST['telefono'] ?? '');
            $password = $_POST['password'] ?? '';
            $rol = ($_POST['rol'] === 'conductor') ? 'conductor' : 'ciudadano';

            $usuarioModel = new Usuario();
            if ($usuarioModel->buscarPorEmail($email)) {
                $error = "Este correo electrónico ya está registrado.";
            } elseif (strlen($password) < 6) {
                $error = "La contraseña debe tener al menos 6 caracteres.";
            } else {
                if ($usuarioModel->registrar($nombre, $email, $telefono, $password, $rol)) {
                    header("Location: index.php?url=auth/login&registrado=1");
                    exit();
                } else {
                    $error = "Ocurrió un error al crear la cuenta.";
                }
            }
        }
        require __DIR__ . '/../views/auth/register.php';
    }

    // Cierra la sesión actual
    public function logout() {
        session_unset();
        session_destroy();
        header("Location: index.php?url=auth/login");
        exit();
    }
}