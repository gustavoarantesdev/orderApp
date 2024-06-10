<?php

/**
 * This class represents an order and provides methods for interacting with orders in the database.
 * 
 * @author gustavoarantes
 */
class Order
{
    /**
     * @var PDO|null The database connection object.
     */
    private static ?PDO $conn = null;

    /**
     * Retrieves the database connection.
     *
     * If the connection hasn't been established yet, it reads the database configuration from a file
     * and creates a new PDO connection.
     *
     * @return PDO The database connection object.
     */
    private static function getConnection(): PDO
    {
        if (self::$conn === null) {
            $config = parse_ini_file('database/config.ini');
            $dsn = "pgsql:dbname={$config['name']};host={$config['host']}";
            self::$conn = new PDO($dsn, $config['user']);
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
        return self::fetchOrders("SELECT * FROM orders WHERE is_completed = false ORDER BY completion_date");
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
        return self::fetchOrders("SELECT * FROM orders ORDER BY completion_date");
    }

    /**
     * Retrieves an order by its ID from the database.
     *
     * @param int $order_id The ID of the order to retrieve.
     * @return array|null The order data if found, or null if not found.
     */
    public static function find(int $order_id): ?array
    {
        $conn = self::getConnection();
        $stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = :order_id");
        $stmt->execute([':order_id' => $order_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Saves an order to the database.
     *
     * Inserts a new order into the database.
     *
     * @param array $order The order data to save.
     */
    public static function save(array $order): void
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

        self::executeQuery($conn, $sql, [
            ':order_title'          => $order['order_title'],
            ':client_name'          => $order['client_name'],
            ':completion_date'      => $order['completion_date'],
            ':completion_time'      => $order['completion_time'],
            ':order_price'          => $order['order_price'],
            ':payment_method'       => $order['payment_method'],
            ':payment_installments' => $order['payment_installments'],
            ':order_description'    => $order['order_description'],
        ]);
    }

    /**
     * Updates an existing order in the database.
     *
     * @param array $order The order data to update.
     */
    public static function update(array $order): void
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

        self::executeQuery($conn, $sql, [
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
    public static function delete(int $order_id): bool
    {
        $conn = self::getConnection();
        $stmt = $conn->prepare("DELETE FROM orders WHERE order_id = :order_id");
        return $stmt->execute([':order_id' => $order_id]);
    }

    /**
     * Fetches orders from the database based on the given SQL query.
     *
     * @param string $sql The SQL query to execute.
     * @return array An array of orders.
     */
    private static function fetchOrders(string $sql): array
    {
        $conn = self::getConnection();
        $stmt = $conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Executes a prepared SQL query with the given parameters.
     *
     * @param PDO $conn The database connection.
     * @param string $sql The SQL query to execute.
     * @param array $params The parameters to bind to the query.
     */
    private static function executeQuery(PDO $conn, string $sql, array $params): void
    {
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
    }
}