<?php

namespace App\Core;

use PDO;

abstract class Model
{
    /**
     * @var PDO|null The database connection object.
     */
    private string $db_host = DB_HOST;
    private string $db_user = DB_USER;
    private string $db_pass = DB_PASS;
    private string $db_name = DB_NAME;

    private static ?PDO $conn = null;

    /**
     * Retrieves the database connection.
     *
     * If the connection hasn't been established yet, it reads the database configuration from a file
     * and creates a new PDO connection.
     *
     * @return PDO The database connection object.
     */
    protected function getConnection(): PDO
    {
        if (is_null(self::$conn)) {
            $dsn = "pgsql:host=$this->db_host;dbname=$this->db_name";
            self::$conn = new PDO($dsn, $this->db_user, $this->db_pass);

            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        }
        return self::$conn;
    }
}
