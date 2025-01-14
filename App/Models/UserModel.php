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
    /**
     * O objeto do PDO
     * @var PDO
     */
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
     * @param string $email E-mail do usuário.
     * @return mixed
     */
    public function getUserByEmail(string $email): mixed
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    /**
     * Registra um novo usuário no banco de dados.
     *
     * @param object $userData Todos os dados do usuário.
     * @return bool
     */
    public function createUser(object $userData): bool
    {
        $userData->password = password_hash($userData->password, PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare(
            "INSERT INTO users (
                name,
                email,
                password_hash
            ) VALUES (
                :name,
                :email,
                :password
            )");

        return $stmt->execute([
            ':name'     => $userData->name,
            ':email'    => $userData->email,
            ':password' => $userData->password
        ]);
    }
}
