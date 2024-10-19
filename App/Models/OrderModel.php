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
        return $this->fetchOrders("SELECT * FROM orders WHERE user_id = :user_id AND order_completed = false ORDER BY order_completion_date, order_completion_time");
    }

    /**
     * Retorna todas as encomendas, ordenadas pela data de conclusão.
     *
     * @return object
     */
    public function getAllOrders(): object
    {
        return $this->fetchOrders("SELECT * FROM orders WHERE user_id = :user_id ORDER BY order_completion_date");
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
                user_id,
                order_title,
                order_quantity,
                order_client_name,
                order_withdraw,
                order_completion_date,
                order_completion_time,
                order_delivery_address,
                order_price,
                order_payment_method,
                order_payment_installments,
                order_description
            ) VALUES (
                :user_id,
                :order_title,
                :order_quantity,
                :order_client_name,
                :order_withdraw,
                :order_completion_date,
                :order_completion_time,
                :order_delivery_address,
                :order_price,
                :order_payment_method,
                :order_payment_installments,
                :order_description
        )");

        $stmt->execute([
            ':user_id'                    => $_SESSION['user_id'],
            ':order_title'                => $orderData->order_title,
            ':order_quantity'             => $orderData->order_quantity,
            ':order_client_name'          => $orderData->order_client_name,
            ':order_withdraw'             => $orderData->order_withdraw,
            ':order_completion_date'      => $orderData->order_completion_date,
            ':order_completion_time'      => $orderData->order_completion_time,
            ':order_delivery_address'     => $orderData->order_delivery_address,
            ':order_price'                => $orderData->order_price,
            ':order_payment_method'       => $orderData->order_payment_method,
            ':order_payment_installments' => $orderData->order_payment_installments,
            ':order_description'          => $orderData->order_description
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
                order_title                = :order_title,
                order_quantity             = :order_quantity,
                order_client_name          = :order_client_name,
                order_withdraw             = :order_withdraw,
                order_completion_date      = :order_completion_date,
                order_completion_time      = :order_completion_time,
                order_delivery_address     = :order_delivery_address,
                order_price                = :order_price,
                order_payment_method       = :order_payment_method,
                order_payment_installments = :order_payment_installments,
                order_description          = :order_description,
                order_completed            = :order_completed
            WHERE order_id = :order_id"
        );

        $stmt->execute([
            ':order_id'                   => $orderData->order_id,
            ':order_title'                => $orderData->order_title,
            ':order_quantity'             => $orderData->order_quantity,
            ':order_client_name'          => $orderData->order_client_name,
            ':order_withdraw'             => $orderData->order_withdraw,
            ':order_completion_date'      => $orderData->order_completion_date,
            ':order_completion_time'      => $orderData->order_completion_time,
            ':order_delivery_address'     => $orderData->order_delivery_address,
            ':order_price'                => $orderData->order_price,
            ':order_payment_method'       => $orderData->order_payment_method,
            ':order_payment_installments' => $orderData->order_payment_installments,
            ':order_description'          => $orderData->order_description,
            ':order_completed'            => $orderData->order_completed
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
        $stmt->execute([':user_id' => $_SESSION['user_id']]);
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
     * @return mixed
     */
    public function fetchOrderById(int $orderId): mixed
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE user_id = :user_id AND order_id = :order_id");
        $stmt->execute([
            ':order_id' => $orderId,
            'user_id' => $_SESSION['user_id']
        ],);
        $orderData = $stmt->fetch();

        return $orderData;
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
