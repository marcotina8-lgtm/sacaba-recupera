<?php
class Reporte {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    // Lista todos los reportes aplicando filtros opcionales de categoría y texto de búsqueda
    public function listar($categoria = '', $buscar = '') {
        // Hacemos JOIN con usuarios para obtener el nombre y teléfono del autor del aviso
        $sql = "SELECT r.*, u.nombre AS autor, u.telefono 
                FROM reportes r 
                INNER JOIN usuarios u ON r.usuario_id = u.id 
                WHERE 1=1";
        $params = [];

        if (!empty($categoria)) {
            $sql .= " AND r.categoria = ?";
            $params[] = $categoria;
        }
        if (!empty($buscar)) {
            $sql .= " AND (r.titulo LIKE ? OR r.lugar_ruta LIKE ? OR r.descripcion LIKE ?)";
            $termino = "%$buscar%";
            $params[] = $termino;
            $params[] = $termino;
            $params[] = $termino;
        }

        $sql .= " ORDER BY r.creado_en DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // Inserta un nuevo reporte de pérdida o hallazgo en MySQL
    public function guardar($usuario_id, $tipo, $titulo, $categoria, $descripcion, $lugar_ruta, $fecha_evento, $imagen) {
        $estado = ($tipo === 'perdida') ? 'perdido' : 'encontrado';
        $sql = "INSERT INTO reportes (usuario_id, tipo, titulo, categoria, descripcion, lugar_ruta, fecha_evento, imagen, estado) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $usuario_id, $tipo, $titulo, $categoria, $descripcion, $lugar_ruta, $fecha_evento, $imagen, $estado
        ]);
    }

    // Actualiza el estado de recuperación del objeto (solo Administrador)
    public function cambiarEstado($id, $nuevoEstado) {
        $estadosValidos = ['perdido', 'encontrado', 'en_verificacion', 'devuelto'];
        if (!in_array($nuevoEstado, $estadosValidos)) {
            return false;
        }
        $sql = "UPDATE reportes SET estado = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nuevoEstado, $id]);
    }

    // Elimina un reporte de la base de datos
    public function eliminar($id) {
        $sql = "DELETE FROM reportes WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
}