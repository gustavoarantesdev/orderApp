<?php

namespace App\Models;

use App\Core\Model;
use App\Helpers\product\FormatDataToView;
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
     * Retorna todos os produtos, com a quantidade e total vendidos.
     *
     * @return object
     */
    public function getAll(): object
    {
        $stmt = $this->pdo->prepare("
            SELECT
                products.id,
                products.name,
                products.cost_price,
                products.status,
                COALESCE(SUM(order_items.quantity), 0) AS total_orders,
                COALESCE(SUM(order_items.sell_price * order_items.quantity), 0.00) AS total_sales
            FROM products
            LEFT JOIN order_items ON order_items.product_id = products.id
            WHERE products.user_id = :user_id
            GROUP BY products.id
        ");

        $stmt->execute([
            ':user_id' => $_SESSION['user_id']
        ]);

        $productsData = (object) $stmt->fetchAll();

        // Aplica as formatações nos dados.
        FormatDataToView::handle($productsData);

        return $productsData;
    }

    /**
     * Retorna todos os produtos disponíveis, somente para o AJAX.
     *
     * @return array
     */
    public function getByAjax(): array
    {
        $stmt = $this->pdo->prepare("
            SELECT
                id,
                name,
                sell_price
            FROM products
            WHERE status <> false AND user_id = :user_id
            ORDER BY name ASC
        ");

        $stmt->execute([
            ':user_id' => $_SESSION['user_id']
        ]);

        $productsData = $stmt->fetchAll();

        return $productsData;
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
        $stmt = $this->pdo->prepare("
            SELECT *
            FROM products
            WHERE id = :id AND user_id = :user_id
        ");

        $stmt->execute([
            ':id'      => $id,
            ':user_id' => $_SESSION['user_id']
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
        $stmt = $this->pdo->prepare("
            INSERT INTO products (
                user_id,
                name,
                sell_price,
                cost_price,
                status,
                description
            ) VALUES (
                :user_id,
                :name,
                :sell_price,
                :cost_price,
                :status,
                :description
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
        $stmt = $this->pdo->prepare("
            UPDATE products SET
                name        = :name,
                sell_price  = :sell_price,
                cost_price  = :cost_price,
                status      = :status,
                description = :description
            WHERE id = :id AND user_id = :user_id
        ");

        $stmt->execute([
            ':id'          => $data->id,
            ':user_id'     => $_SESSION['user_id'],
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
        $stmt = $this->pdo->prepare("
            DELETE FROM products
            WHERE id = :id AND user_id = :user_id
        ");

        $stmt->execute([
            ':id'      => $id,
            ':user_id' => $_SESSION['user_id']
        ]);

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
        $stmt = $this->pdo->prepare( "
            SELECT COUNT(*)
            FROM products
            WHERE name = :name AND user_id = :user_id
        ");

        $stmt->execute([
            ':name'    => $name,
            ':user_id' => $_SESSION['user_id']
        ]);

        return $stmt->fetchColumn() > 0;
    }
}
