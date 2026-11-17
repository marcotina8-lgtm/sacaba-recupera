<?php
class Database {
    // Parámetros de conexión (En XAMPP local funcionan tal cual;
    // al subir a InfinityFree/ByetHost solo cambias estos 4 valores por los del hosting)
    private static $host = 'localhost';
    private static $db_name = 'sacaba_recupera_db';
    private static $username = 'root';
    private static $password = '';
    private static $conn = null;

    public static function connect() {
        if (self::$conn === null) {
            try {
                $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$db_name . ";charset=utf8mb4";
                self::$conn = new PDO($dsn, self::$username, self::$password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Muestra errores SQL claros
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Devuelve resultados como arreglos asociativos
                    PDO::ATTR_EMULATE_PREPARES => false // Protección real contra inyección SQL
                ]);
            } catch (PDOException $e) {
                die("Error de conexión a la base de datos: " . $e->getMessage());
            }
        }
        return self::$conn;
    }
}