<?php

class Order
{
    private static $conn;

    public static function getConnection()
    {
        if (empty(self::$conn))
        {
            $file = parse_ini_file('database/config.ini');
            $host = $file['host'];
            $name = $file['name'];
            $user = $file['user'];

            self::$conn = new PDO("pgsql:dbname={$name};user={$user};host={$host}");
            self::$conn->setAttribute(PDO::ATTR-ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$conn;
    }
}
