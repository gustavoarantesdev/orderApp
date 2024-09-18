<?php

namespace App\Models;

use App\Core\Model;

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
}
