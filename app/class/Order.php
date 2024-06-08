<?php

/**
 * This class represents an order and provides methods for interacting with orders in the database.
 */
class Order
{
    /**
     * @var PDO|null The database connection object.
     */
    private static $conn = null;

    /**
     * Retrieves the database connection.
     *
     * If the connection hasn't been established yet, it reads the database configuration from a file
     * and creates a new PDO connection.
     *
     * @return PDO The database connection object.
     */
    public static function getConnection(): PDO
    {
        if (empty(self::$conn)) {
            $file = parse_ini_file('database/config.ini');
            $host = $file['host'];
            $name = $file['name'];
            $user = $file['user'];

            self::$conn = new PDO("pgsql:dbname={$name};user={$user};host={$host}");
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$conn;
    }

    /**
     * Retrieves all orders that are not finished from the database.
     *
     * Orders are sorted by their end date in ascending order.
     *
     * @return array An array containing all orders.
     */
    public static function all(): array
    {
        $conn = self::getConnection();
        $result = $conn->query("SELECT * FROM orders WHERE is_completed = false ORDER BY completion_date");
        return $result->fetchAll();
    }

    /**
     * Retrieves all orders from the database.
     *
     * Orders are sorted by their end date in ascending order.
     *
     * @return array An array containing all orders.
     */
    public static function listAll(): array
    {
        $conn = self::getConnection();
        $result = $conn->query("SELECT * FROM orders ORDER BY completion_date");
        return $result->fetchAll();
    }

    /**
     * Retrieves an order by its ID from the database.
     *
     * @param int $order_id The ID of the order to retrieve.
     * @return array|null The order data if found, or null if not found.
     */
    public static function find($order_id): ?array
    {
        $conn = self::getConnection();
        $result = $conn->prepare("SELECT * FROM orders WHERE order_id=:order_id");
        $result->execute([':order_id' => $order_id]);
        return $result->fetch();
    }

    /**
     * Saves an order to the database.
     *
     * If the order has an ID, it updates the existing order. Otherwise, it inserts a new order.
     *
     * @param array $order The order data to save.
     * @return void
     */
    public static function save($order): void
    {
        $conn = self::getConnection();

            $sql = "INSERT INTO orders (
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
                )";

            $result = $conn->prepare($sql);
            $result->execute([
                ':order_title'          => $order['order_title'],
                ':client_name'          => $order['client_name'],
                ':completion_date'      => $order['completion_date'],
                ':completion_time'      => $order['completion_time'],
                ':order_price'          => $order['order_price'],
                ':payment_method'       => $order['payment_method'],
                ':payment_installments' => $order['payment_installments'],
                ':order_description'    => $order['order_description']
            ]);
    }

    public static function update($order) 
    {
        $conn = self::getConnection();
        $sql = "UPDATE orders SET 
                order_title          = :order_title, 
                client_name          = :client_name, 
                completion_date      = :completion_date, 
                completion_time      = :completion_time, 
                order_price          = :order_price, 
                payment_method       = :payment_method, 
                payment_installments = :payment_installments,
                order_description    = :order_description,
                is_completed         = :is_completed
            WHERE order_id = :order_id";

            $result = $conn->prepare($sql);
            $result->execute([
                ':order_id'             => $order['order_id'],
                ':order_title'          => $order['order_title'],
                ':client_name'          => $order['client_name'],
                ':completion_date'      => $order['completion_date'],
                ':completion_time'      => $order['completion_time'],
                ':order_price'          => $order['order_price'],
                ':payment_method'       => $order['payment_method'],
                ':payment_installments' => $order['payment_installments'],
                ':order_description'    => $order['order_description'],
                ':is_completed'         => $order['is_completed']
            ]);
    }

    /**
     * Deletes an order from the database by its ID.
     *
     * @param int $order_id The ID of the order to delete.
     * @return bool True if the order was successfully deleted, false otherwise.
     */
    public static function delete($order_id): bool
    {
        $conn = self::getConnection();
        $result = $conn->prepare("DELETE FROM orders WHERE order_id=:order_id");   
        return $result->execute([':order_id' => $order_id]);
    }
}