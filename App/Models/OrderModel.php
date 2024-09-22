<?php

namespace App\Models;

use App\Core\Model;
use App\Helpers\Helpers;
use PDO;

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
    /**
     * @var PDO Conexão com o banco de dados.
     */
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
     * @return array Array de objetos representando encomendas disponíveis.
     */
    public function getOrders(): array
    {
        $query = ("SELECT * FROM orders WHERE is_completed = false ORDER BY completion_date");

        return $this->fetchOrders($query);
    }

    /**
     * Retorna todas as encomendas, ordenadas pela data de conclusão.
     *
     * @return array Array de objetos representando todas as encomendas.
     */
    public function getAllOrders(): array
    {
        $query = ("SELECT * FROM orders ORDER BY completion_date DESC");

        return $this->fetchOrders($query);
    }

    /**
     * Registra uma nova encomenda no banco de dados.
     *
     * @param array $data Dados da encomenda a ser registrada.
     * @return void
     */
    public function createOrder(array $data): void
    {
        // Prepara os dados antes de armazenar.
        $data = $this->prepareDataToSaveDb($data);

        $stmt = $this->pdo->prepare(
            "INSERT INTO orders (
                order_title,
                client_name,
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
            ':order_title'          => $data['order_title'],
            ':client_name'          => $data['client_name'],
            ':completion_date'      => $data['completion_date'],
            ':completion_time'      => $data['completion_time'],
            ':order_price'          => $data['order_price'],
            ':payment_method'       => $data['payment_method'],
            ':payment_installments' => $data['payment_installments'],
            ':order_description'    => $data['order_description'],
        ]);
    }

    /**
     * Atualiza os dados de uma encomenda existente.
     *
     * @param array $data Dados da encomenda a ser atualizada.
     * @return void
     */
    public function updateOrder(array $data): void
    {
        // Prepara os dados antes de armazenar.
        $data = $this->prepareDataToSaveDb($data);

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
            ':order_id'             => $data['order_id'],
            ':order_title'          => $data['order_title'],
            ':client_name'          => $data['client_name'],
            ':completion_date'      => $data['completion_date'],
            ':completion_time'      => $data['completion_time'],
            ':order_price'          => $data['order_price'],
            ':payment_method'       => $data['payment_method'],
            ':payment_installments' => $data['payment_installments'],
            ':order_description'    => $data['order_description'],
            ':is_completed'         => $data['is_completed']
        ]);
    }

    /**
     * Busca uma encomenda pelo ID informado.
     *
     * @param integer $orderId ID da encomenda a ser buscada.
     * @return object|null Objeto representando a encomenda ou null se não encontrar.
     */
    public function fetchOrderById(int $orderId): ?object
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE order_id = :order_id");
        $stmt->execute([':order_id' => $orderId]);
        $data = $stmt->fetch() ?: null;

        // Se a encomenda não for encontrada retorna null.
        if (is_null($data)) {
            return $data;
        }

        // Formata os dados para impressão.
        $data->completion_date = Helpers::dateFormat($data->completion_date, false);
        $data->created_at = Helpers::dateFormat($data->created_at, false);

        return $data;
    }

    /**
     * Deleta uma encomenda pelo ID informado.
     *
     * @param integer $orderId ID da encomenda a ser deletada.
     * @return bool Retorna true em caso de sucesso ou false em caso de falha.
     */
    public function deleteOrder(int $orderId): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM orders WHERE order_id = :order_id");

        return $stmt->execute([':order_id' => $orderId]);
    }

    /**
     * Executa uma consulta e retorna as encomendas formatas.
     *
     * @param string $query Query SQL a ser executada.
     * @return array Array de objetos representando as encomendas.
     */
    private function fetchOrders(string $query): array
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $orders = $stmt->fetchAll();

        // Aplica formatação aos dados das encomendas.
        foreach ($orders as $order) {
            $order = $this->formatOrderDataToPrint($order);
        }

        return $orders;
    }

    /**
     * Prepara os dados da encomenda para armazenamento no banco de dados.
     *
     * @param array $data Dados da encomenda.
     * @return array Dados formatados prontos para inserção.
     */
    private function prepareDataToSaveDb(array $data): array
    {
        $data['order_price']          = Helpers::orderPriceSaveDb($data['order_price']);
        $data['payment_installments'] = Helpers::paymentInstallmentsSaveDb($data['payment_method'], $data['payment_installments']);
        $data['completion_date']      = Helpers::dateSaveDb($data['completion_date']);

        return $data;
    }

    /**
     * Formata os dados da encomenda para exibição.
     *
     * @param object $data Dados da encomenda.
     * @return object Dados formatados para impressão.
     */
    private function formatOrderDataToPrint(object $data): object
    {
        $data->order_status    = Helpers::orderStatus($data->is_completed, $data->completion_date);
        $data->order_title     = Helpers::cutTitle($data->order_title);
        $data->client_name     = Helpers::formatClient($data->client_name);
        $data->days_count      = Helpers::daysCount($data->completion_date);
        $data->completion_date = Helpers::dateFormat($data->completion_date, $data->completion_time);
        $data->order_price     = Helpers::priceFormat($data->order_price);
        $data->payment_method  = Helpers::formatPaymentMethod($data->payment_method);

        return $data;
    }
}
