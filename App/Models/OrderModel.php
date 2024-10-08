<?php

namespace App\Models;

use PDO;
use App\Core\Model;
use App\Services\OrderValidator;

/**
 * Classe OrderModel
 *
 * Modelo responsável por gerenciar operações relacionadas às encomendas no banco de dados.
 *
 * Este modelo encapsula a lógica de acesso a dados para as encomendas,
 * incluindo a criação, leitura, atualização e exclusão (CRUD) de registros.
 * Também fornece métodos para filtrar e formatar os dados das encomendas
 * antes de apresentá-los na aplicação.
 */
class OrderModel extends Model
{
    private PDO $pdo;

    /**
     * OrderModel construtor.
     * Inicializa a conexão com o banco de dados.
     */
    public function __construct()
    {
        $this->pdo = $this->getConnection();
    }

    /**
     * Retorna as encomendas disponíveis (não concluídas).
     *
     * @return object
     */
    public function getOrders(): object
    {
        return $this->fetchOrders("SELECT * FROM orders WHERE is_completed = false ORDER BY completion_date");
    }

    /**
     * Retorna todas as encomendas, ordenadas pela data de conclusão.
     *
     * @return object
     */
    public function getAllOrders(): object
    {
        return $this->fetchOrders("SELECT * FROM orders ORDER BY completion_date DESC");
    }

    /**
     * Registra uma nova encomenda no banco de dados.
     *
     * @param object $orderData
     * @return void
     */
    public function createOrder(object $orderData): void
    {
        // Prepara os dados antes de armazenar.
        $orderData = OrderValidator::prepareOrderDataToSaveDb($orderData);

        $stmt = $this->pdo->prepare(
            "INSERT INTO orders (
                order_title, client_name,
                completion_date,
                completion_time,
                order_price,
                payment_method,
                payment_installments,
                order_description
            ) VALUES (
                :order_title,
                :client_name,
                :completion_date,
                :completion_time,
                :order_price,
                :payment_method,
                :payment_installments,
                :order_description
        )");

        $stmt->execute([
            ':order_title'          => $orderData->order_title,
            ':client_name'          => $orderData->client_name,
            ':completion_date'      => $orderData->completion_date,
            ':completion_time'      => $orderData->completion_time,
            ':order_price'          => $orderData->order_price,
            ':payment_method'       => $orderData->payment_method,
            ':payment_installments' => $orderData->payment_installments,
            ':order_description'    => $orderData->order_description
        ]);
    }

    /**
     * Atualiza os dados de uma encomenda existente.
     *
     * @param array $data Dados da encomenda a ser atualizada.
     * @return void
     */
    public function updateOrder(object $orderData): void
    {
        // Prepara os dados antes de armazenar.
        $orderData = OrderValidator::prepareOrderDataToSaveDb($orderData);

        $stmt = $this->pdo->prepare(
            "UPDATE orders SET
                order_title          = :order_title,
                client_name          = :client_name,
                completion_date      = :completion_date,
                completion_time      = :completion_time,
                order_price          = :order_price,
                payment_method       = :payment_method,
                payment_installments = :payment_installments,
                order_description    = :order_description,
                is_completed         = :is_completed
            WHERE order_id = :order_id"
        );

        $stmt->execute([
            ':order_id'             => $orderData->order_id,
            ':order_title'          => $orderData->order_title,
            ':client_name'          => $orderData->client_name,
            ':completion_date'      => $orderData->completion_date,
            ':completion_time'      => $orderData->completion_time,
            ':order_price'          => $orderData->order_price,
            ':payment_method'       => $orderData->payment_method,
            ':payment_installments' => $orderData->payment_installments,
            ':order_description'    => $orderData->order_description,
            ':is_completed'         => $orderData->is_completed
        ]);
    }

    /**
     * Executa uma consulta com base na query informada, e retorna
     * ás encomendas formatas.
     *
     * @param string $query Query SQL a ser executada.
     * @return object
     */
    private function fetchOrders(string $query): object
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $ordersData = $stmt->fetchAll();

        // Aplica formatação aos dados das encomendas.
        foreach ($ordersData as $orderData) {
            $orderData = OrderValidator::formatOrderDataToPrint($orderData);
        }

        return (object) $ordersData;
    }

    /**
     * Busca uma encomenda pelo ID informado.
     * Se não for encontrada retorna null.
     *
     * @param integer $orderId
     * @return object|null
     */
    public function fetchOrderById(int $orderId): ?object
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE order_id = :order_id");
        $stmt->execute([':order_id' => $orderId]);
        $orderData = $stmt->fetch();

        return $orderData ? OrderValidator::formatOrderDataToPrint($orderData) : null;
    }

    /**
     * Deleta uma encomenda pelo ID informado.
     *
     * @param integer $orderId
     * @return bool
     */
    public function deleteOrder(int $orderId): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM orders WHERE order_id = :order_id");
        $stmt->execute([':order_id' => $orderId]);

        return $stmt->rowCount() > 0;
    }
}
