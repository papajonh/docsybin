<?php
namespace App\Models\Connections;
use Config\DB\DB;
use PDO;
use Exception;

class DataBase {
    private static $instance = null;
    public static function getConnection() {
        if (self::$instance === null) {
            // Aqui você "puxa" o array do arquivo config/db.php
            $config = DB::config();

            try {
                $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset=utf8mb4";
                self::$instance = new PDO($dsn, $config['username'], $config['password'], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            } catch (Exception $e) {
                die("Erro ao conectar ao banco: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}