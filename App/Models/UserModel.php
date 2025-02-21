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
    public function getByEmail(string $email): mixed
    {
        $stmt = $this->pdo->prepare("
            SELECT *
            FROM users
            WHERE email = :email
        ");

        $stmt->execute([
            ':email' => $email
        ]);

        return $stmt->fetch();
    }

    /**
     * Busca um usuário no banco de dados com base no ID.
     *
     * Se encontrar retorna os dados do usuário econtrado, se não econtrar
     * retorna false.
     *
     * @param string $id ID do usuário.
     * @return mixed
     */
    public function getById(string $id): mixed
    {
        $stmt = $this->pdo->prepare("
            SELECT *
            FROM users
            WHERE id = :id
            AND id = :user_id
        ");

        $stmt->execute([
            ':id'      => $id,
            ':user_id' => $_SESSION['user_id'],
        ]);

        return $stmt->fetch();
    }

    /**
     * Registra um novo usuário no banco de dados.
     *
     * @param object $userData Todos os dados do usuário.
     * @return bool
     */
    public function create(object $data): bool
    {
        $data->password = password_hash($data->password, PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare("
            INSERT INTO users (
                name,
                email,
                password_hash
            ) VALUES (
                :name,
                :email,
                :password
            )"
        );

        return $stmt->execute([
            ':name'     => $data->name,
            ':email'    => $data->email,
            ':password' => $data->password
        ]);
    }

    /**
     * Atualiza os dados de um usuário existente.
     *
     * @param object $data Dados do usuário.
     * @return void
     */
    public function update(object $data): void
    {
        // Atualiza o nome
        if ($data->name !== null) {
            $stmt = $this->pdo->prepare("
                UPDATE users
                SET name = :name
                WHERE id = :id
                AND id = :user_id
            ");

            $stmt->execute([
                ':id'      => $data->id,
                ':user_id' => $_SESSION['user_id'],
                ':name'    => $data->name
            ]);
        }

        // Atualiza o e-mail
        if ($data->email !== null) {
            $stmt = $this->pdo->prepare("
                UPDATE users
                SET email = :email
                WHERE id = :id
                AND id = :user_id
            ");

            $stmt->execute([
                ':id'      => $data->id,
                ':user_id' => $_SESSION['user_id'],
                ':email'   => $data->email
            ]);
        }

        // Atualiza a senha
        if ($data->password !== null) {
            $data->password = password_hash($data->password, PASSWORD_DEFAULT);

            $stmt = $this->pdo->prepare("
                UPDATE users
                SET password_hash = :password
                WHERE id = :id
                AND id = :user_id
            ");

            $stmt->execute([
                ':id'       => $data->id,
                ':user_id'  => $_SESSION['user_id'],
                ':password' => $data->password
            ]);
        }
    }

    /**
     * Deleta um usuário pelo ID informado.
     *
     * @param integer $id ID do usuário.
     * @return bool
     */
    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("
            DELETE FROM users
            WHERE id = :id
            AND id = :user_id
        ");

        $stmt->execute([
            ':id'      => $id,
            ':user_id' => $_SESSION['user_id']
        ]);

        return $stmt->rowCount() > 0;
    }
}
