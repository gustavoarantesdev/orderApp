<?php

namespace App\Models;

use App\Core\Model;
use App\Helpers\customer\FormatDataToView;
use PDO;

/**
 * Classe CustomerModel
 *
 * Modelo responsável por gerenciar operações relacionadas aos clientes no banco de dados.
 *
 * Este modelo encapsula a lógica de acesso a dados para os clientes,
 * incluindo a criação, leitura, atualização e exclusão (CRUD) de registros.
 */
class CustomerModel extends Model
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
     * Retorna todos os clientes, com a quantidade de encomendas, total de vendido e pago.
     *
     * @return object
     */
    public function getAll(): object
    {
        $stmt = $this->pdo->prepare("
            SELECT
                customers.id,
                customers.name,
                customers.person_type,
                customers.phone,
                customers.gender,
                customers.birth_date,
                COALESCE(COUNT(orders.id), 0) AS total_orders,
                COALESCE(SUM(orders.subtotal), 0.00) AS total_sales,
                COALESCE(SUM(orders.payment_value), 0.00) AS total_paid
            FROM customers
            LEFT JOIN orders ON orders.customer_id = customers.id
            WHERE customers.user_id = :user_id
            GROUP BY customers.id
        ");

        $stmt->execute([
            ':user_id' => $_SESSION['user_id']
        ]);

        $customersData = (object) $stmt->fetchAll();

        // Aplica as formatações nos dados.
        FormatDataToView::handle($customersData);

        return $customersData;
    }

    /**
     * Retorna um cliente pelo ID informado.
     *
     * Se não for encontrada retorna null.
     *
     * @param integer $id ID do cliente.
     * @return mixed
     */
    public function getById(int $id): mixed
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM customers
            WHERE id = :id AND user_id = :user_id
        ");

        $stmt->execute([
            ':id'      => $id,
            ':user_id' => $_SESSION['user_id']
        ]);

        return $stmt->fetch();
    }

    /**
     * Registra uma nova encomenda no banco de dados.
     *
     * @param object $data Dados do cliente.
     * @return void
     */
    public function create(object $data): void
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO customers (
                user_id,
                name,
                person_type,
                cpf,
                cnpj,
                phone,
                gender,
                birth_date,
                address,
                description
            ) VALUES (
                :user_id,
                :name,
                :person_type,
                :cpf,
                :cnpj,
                :phone,
                :gender,
                :birth_date,
                :address,
                :description
        )");

        $stmt->execute([
            ':user_id'     => $_SESSION['user_id'],
            ':name'        => $data->name,
            ':person_type' => $data->person_type,
            ':cpf'         => $data->cpf,
            ':cnpj'        => $data->cnpj,
            ':phone'       => $data->phone,
            ':gender'      => $data->gender,
            ':birth_date'  => $data->birth_date,
            ':address'     => $data->address,
            ':description' => $data->description
        ]);
    }

    /**
     * Atualiza os dados de um cliente existente.
     *
     * @param object $data Dados do cliente.
     * @return void
     */
    public function update(object $data): void
    {
        $stmt = $this->pdo->prepare("
            UPDATE customers SET
                name        = :name,
                cpf         = :cpf,
                cnpj        = :cnpj,
                phone       = :phone,
                gender      = :gender,
                birth_date  = :birth_date,
                address     = :address,
                description = :description
            WHERE id = :id AND user_id = :user_id"
        );

        $stmt->execute([
            ':id'          => $data->id,
            ':user_id'     => $_SESSION['user_id'],
            ':name'        => $data->name,
            ':cpf'         => $data->cpf,
            ':cnpj'        => $data->cnpj,
            ':phone'       => $data->phone,
            ':gender'      => $data->gender,
            ':birth_date'  => $data->birth_date,
            ':address'     => $data->address,
            ':description' => $data->description
        ]);
    }

    /**
     * Deleta um cliente pelo ID informado.
     *
     * @param integer $id ID do cliente.
     * @return bool
     */
    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("
            DELETE FROM customers
            WHERE id = :id AND user_id = :user_id
        ");

        $stmt->execute([
            ':id'      => $id,
            ':user_id' => $_SESSION['user_id']
        ]);

        return $stmt->rowCount() > 0;
    }

    /**
     * Verifica se o CPF já está cadastrado.
     *
     * Retorna true se for encontrado.
     *
     * @param string $cpf CPF do cliente.
     * @return bool
     */
    public function cpfExists(string $cpf): bool
    {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*)
            FROM customers
            WHERE cpf = :cpf AND user_id = :user_id
        ");

        $stmt->execute([
            ':cpf'     => $cpf,
            ':user_id' => $_SESSION['user_id']
        ]);

        return $stmt->fetchColumn() > 0;
    }

    /**
     * Verifica se o CNPJ já está cadastrado.
     *
     * Retorna true se for encontrado.
     *
     * @param string $cnpj CNPJ do cliente.
     * @return bool
     */
    public function cnpjExists(string $cnpj): bool
    {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*)
            FROM customers
            WHERE cnpj = :cnpj AND user_id = :user_id
        ");

        $stmt->execute([
            ':cnpj'    => $cnpj,
            ':user_id' => $_SESSION['user_id']
        ]);

        return $stmt->fetchColumn() > 0;
    }
}
