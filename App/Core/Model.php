<?php

namespace App\Core;

use PDO;
use PDOException;

/**
 * Classe responsável por centralizar a conexão com o banco de dados.
 */
abstract class Model
{
    /**
     * @var string Credênciais para conexão com o banco de dados.
     */
    private string $db_host = DB_HOST;
    private string $db_user = DB_USER;
    private string $db_pass = DB_PASS;
    private string $db_name = DB_NAME;

    /**
     * @var PDO|null Conexão com o banco de dados (instância única).
     */
    private static ?PDO $conn = null;

    /**
     * Construtor privado para evitar instanciamento.
     */
    private function __construct()
    {

    }

    /**
     * Recupera a conexão com o banco de dados.
     *
     * Se a conexão ainda não foi estabelecida, ela é criada.
     *
     * @return PDO A conexão com o banco de dados.
     */
    protected function getConnection(): PDO
    {
        // Se a conexão já foi estabelecida, retorna ela mesma.
        if (!is_null(self::$conn)) {
            return self::$conn;
        }

        // Tenta criar uma conexão se ainda não existir.
        try {
            // Define o Data Source Name (DSN) para conexão.
            $dsn = "pgsql:host=$this->db_host;dbname=$this->db_name";

            // Cria a nova conexão PDO.
            self::$conn = new PDO($dsn, $this->db_user, $this->db_pass);

            // Define os atributos da conexão.
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (PDOException) {
            http_response_code(500);
            View::render('errors/internalServerError');
            exit;
        }

        // Retorna a conexão recém-estabelecida.
        return self::$conn;
    }
}
