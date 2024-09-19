<?php

namespace App\Models;

use App\Core\Model;
use App\Helpers\Helpers;

class OrderModel extends Model
{
    private $pdo;

    public function __construct() 
    {
        $conn = $this->getConnection();
        $this->pdo = $conn;
    }

    public function getOrders(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE is_completed = false ORDER BY completion_date");

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function createOrder(array $data)
    {
        $data['order_price'] = Helpers::orderPriceSaveDb($data['order_price']);
        $data['payment_installments'] = Helpers::paymentInstallmentsSaveDb($data['payment_method'], $data['payment_installments']);
        $data['completion_date'] = Helpers::dateSaveDb($data['completion_date']);

        $stmt = $this->pdo->prepare(
            "INSERT INTO orders (
            order_title, client_name, completion_date, completion_time, 
            order_price, payment_method, payment_installments, order_description
            ) VALUES (
            :order_title, :client_name, :completion_date, :completion_time, 
            :order_price, :payment_method, :payment_installments, :order_description
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
}
