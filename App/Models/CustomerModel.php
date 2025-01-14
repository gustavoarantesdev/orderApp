<?php

namespace App\Models;

use App\Core\Model;
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
     * Retorna todos os clientes.
     *
     * @return object
     */
    public function getAll(): object
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM customers WHERE user_id = :user_id"
        );

        $stmt->execute([
            ':user_id' => $_SESSION['user_id']
        ]);

        return (object) $stmt->fetchAll();
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
        $stmt = $this->pdo->prepare(
            "SELECT * FROM customers WHERE user_id = :user_id AND id = :id"
        );

        $stmt->execute([
            ':user_id' => $_SESSION['user_id'],
            ':id' => $id
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
        $stmt = $this->pdo->prepare(
            "INSERT INTO customers (
                user_id, name, person_type, cpf, cnpj, phone, gender,
                birth_date, address, description
            ) VALUES (
                :user_id, :name, :person_type, :cpf, :cnpj, :phone, :gender,
                :birth_date, :address, :description
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
        $stmt = $this->pdo->prepare(
            "UPDATE customers SET
                name        = :name,
                cpf         = :cpf,
                cnpj        = :cnpj,
                phone       = :phone,
                gender      = :gender,
                birth_date  = :birth_date,
                address     = :address,
                description = :description
            WHERE user_id = :user_id AND id = :id"
        );

        $stmt->execute([
            ':user_id'     => $_SESSION['user_id'],
            ':id'          => $data->id,
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
        $stmt = $this->pdo->prepare("DELETE FROM customers WHERE user_id = :user_id AND id = :id");
        $stmt->execute([
            ':user_id' => $_SESSION['user_id'],
            ':id' => $id
        ],);

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
        $stmt = $this->pdo->prepare(
            "SELECT COUNT(*) FROM customers WHERE user_id = :user_id AND cpf = :cpf"
        );

        $stmt->execute([
            ':user_id' => $_SESSION['user_id'],
            ':cpf' => $cpf
        ],);

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
        $stmt = $this->pdo->prepare(
            "SELECT COUNT(*) FROM customers WHERE user_id = :user_id AND cnpj = :cnpj"
        );

        $stmt->execute([
            ':user_id' => $_SESSION['user_id'],
            ':cnpj' => $cnpj
        ],);

        return $stmt->fetchColumn() > 0;
    }
}
