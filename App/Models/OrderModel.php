<?php

namespace App\Models;

use App\Core\Model;
use App\Helpers\Helpers;

class OrderModel extends Model
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->getConnection();
    }

    public function getOrders(): array
    {
        $query = ("SELECT * FROM orders WHERE is_completed = false ORDER BY completion_date");
        return $this->fetchOrders($query);
    }

    public function getAllOrders(): array
    {
        $query = ("SELECT * FROM orders ORDER BY completion_date DESC");
        return $this->fetchOrders($query);
    }

    public function createOrder(array $data): void
    {
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

    public function updateOrder(array $data): void
    {
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

    public function fetchOrder(int $orderId): ?object
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE order_id = :order_id");

        $stmt->execute([':order_id' => $orderId]);

        $data = $stmt->fetch() ?: null;

        if (is_null($data)) {
            header('Location:' . BASE_URL);
            exit;
        }

        $data->completion_date = Helpers::dateFormat($data->completion_date, false);
        $data->created_at = Helpers::dateFormat($data->created_at, false);

        return $data;
    }

    public function deleteOrder(int $orderId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM orders WHERE order_id = :order_id");

        return $stmt->execute([':order_id' => $orderId]);
    }

    private function fetchOrders(string $query, array $params = []): array
    {
        $stmt = $this->pdo->prepare($query);

        $stmt->execute($params);
        $orders = $stmt->fetchAll();

        foreach ($orders as $order) {
            $order = $this->formatOrderDataToPrint($order);
        }

        return $orders;
    }

    private function prepareDataToSaveDb(array $data): array
    {
        $data['order_price']          = Helpers::orderPriceSaveDb($data['order_price']);
        $data['payment_installments'] = Helpers::paymentInstallmentsSaveDb($data['payment_method'], $data['payment_installments']);
        $data['completion_date']      = Helpers::dateSaveDb($data['completion_date']);

        return $data;
    }

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
