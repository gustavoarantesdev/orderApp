<?php

namespace App\Models;

use App\Core\Model;
use PDO;

/**
 * Modelo responsável por gerenciar operações relacionadas aos produtos no banco de dados.
 *
 * Este modelo encapsula a lógica de acesso a dados para os produtos,
 * incluindo a criação, leitura, atualização e exclusão (CRUD) de registros.
 */
class ProductModel extends Model
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
     * Retorna todos os produtos.
     *
     * @return object
     */
    public function getAll(): object
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM products WHERE user_id = :user_id"
        );

        $stmt->execute([
            ':user_id' => $_SESSION['user_id']
        ]);

        return (object) $stmt->fetchAll();
    }

    /**
     * Retorna um produto pelo ID informado.
     *
     * Se não for encontrada retorna null.
     *
     * @param integer $id ID do produto.
     * @return mixed
     */
    public function getById(int $id): mixed
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM products WHERE user_id = :user_id AND id = :id"
        );

        $stmt->execute([
            ':user_id' => $_SESSION['user_id'],
            ':id' => $id
        ]);

        return $stmt->fetch();
    }

    /**
     * Registra uma novo produto no banco de dados.
     *
     * @param object $data Dados do produto.
     * @return void
     */
    public function create(object $data): void
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO products (
                user_id, name, sell_price, cost_price, status, description
            ) VALUES (
                :user_id, :name, :sell_price, :cost_price, :status, :description
        )");

        $stmt->execute([
            ':user_id'     => $_SESSION['user_id'],
            ':name'        => $data->name,
            ':sell_price'  => $data->sell_price,
            ':cost_price'  => $data->cost_price,
            ':status'      => $data->status,
            ':description' => $data->description
        ]);
    }

    /**
     * Atualiza os dados de um produto existente.
     *
     * @param object $data Dados do produto.
     * @return void
     */
    public function update(object $data): void
    {
        $stmt = $this->pdo->prepare(
            "UPDATE products SET
                name        = :name,
                sell_price  = :sell_price,
                cost_price  = :cost_price,
                status      = :status,
                description = :description
            WHERE user_id = :user_id AND id = :id"
        );

        $stmt->execute([
            ':user_id'     => $_SESSION['user_id'],
            ':id'          => $data->id,
            ':name'        => $data->name,
            ':sell_price'  => $data->sell_price,
            ':cost_price'  => $data->cost_price,
            ':status'      => $data->status,
            ':description' => $data->description
        ]);
    }

    /**
     * Deleta um produto pelo ID informado.
     *
     * @param integer $id ID do produto.
     * @return bool
     */
    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE user_id = :user_id AND id = :id");
        $stmt->execute([
            ':user_id' => $_SESSION['user_id'],
            ':id' => $id
        ],);

        return $stmt->rowCount() > 0;
    }

    /**
     * Verifica se o produto já está cadastrado.
     *
     * Retorna true se for encontrado.
     *
     * @param string $name nome do produto.
     * @return bool
     */
    public function productExists(string $name): bool
    {
        $stmt = $this->pdo->prepare(
            "SELECT COUNT(*) FROM products WHERE user_id = :user_id AND name = :name"
        );

        $stmt->execute([
            ':user_id' => $_SESSION['user_id'],
            ':name' => $name
        ],);

        return $stmt->fetchColumn() > 0;
    }
}
