<?php
namespace Config\DB;
Class DB{
    private static $config = [];
    public static function config(){
        self::$config = [
            'host'     => $_ENV['DB_HOST'] ?? 'localhost',
            'database' => $_ENV['DB_DATABASE'] ?? 'docsybin_db',
            'username' => $_ENV['DB_USERNAME'] ?? 'papajond_papajon',
            'password' => $_ENV['DB_PASSWORD'] ?? 'papajon',
        ];
        return self::$config;
    }
}