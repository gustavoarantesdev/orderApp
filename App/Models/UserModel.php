<?php

namespace App\Models;

use App\Core\Model;
use PDO;

/**
 * Classe responsável por gerenciar operações relacionadas ao usuário
 * no banco de dados.
 *
 * Este modelo encapsula a lógica de acesso a dados para os usuários,
 * incluindo a criação, leitura, atualização e exclusão (CRUD) de registros.
 * Também fornece métodos para filtrar.
 */
class UserModel extends Model
{
    private PDO $pdo;

    /**
     * Inicializa a conexão com o banco de dados.
     */
    public function __construct()
    {
        $this->pdo = $this->getConnection();
    }

    /**
     * Busca um usuário no banco de dados com base no e-mail.
     *
     * Se encontrar retorna os dados do usuário econtrado, se não econtrar
     * retorna false.
     *
     * @param string $userEmail
     * @return mixed
     */
    public function getUserByEmail(string $userEmail): mixed
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE user_email = :user_email");
        $stmt->execute([':user_email' => $userEmail]);
        return $stmt->fetch();
    }

    /**
     * Registra um novo usuário no banco de dados.
     *
     * @param object $userData
     * @return bool
     */
    public function createUser(object $userData): bool
    {
        $userData->user_password = password_hash($userData->user_password, PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare(
            "INSERT INTO users (
                user_name,
                user_email,
                user_password_hash
            ) VALUES (
                :user_name,
                :user_email,
                :user_password
            )");

        return $stmt->execute([
            ':user_name'     => $userData->user_name,
            ':user_email'    => $userData->user_email,
            ':user_password' => $userData->user_password
        ]);
    }
}
