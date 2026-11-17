<?php
class Usuario {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    // Registra un usuario nuevo encriptando su contraseña con BCRYPT (RNF-02)
    public function registrar($nombre, $email, $telefono, $password, $rol = 'ciudadano') {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO usuarios (nombre, email, telefono, password, rol) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $email, $telefono, $hash, $rol]);
    }

    // Busca un usuario por correo electrónico para validar login o evitar duplicados
    public function buscarPorEmail($email) {
        $sql = "SELECT * FROM usuarios WHERE email = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
}