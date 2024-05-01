<?php

/**
 * This class represents an order and provides methods for interacting with orders in the database.
 */
class Order
{
    /**
     * @var PDO|null The database connection object.
     */
    private static $conn;

    /**
     * Retrieves the database connection.
     *
     * If the connection hasn't been established yet, it reads the database configuration from a file
     * and creates a new PDO connection.
     *
     * @return PDO The database connection object.
     */
    public static function getConnection()
    {
        if (empty(self::$conn))
        {
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
    public static function all()
    {
        $conn = self::getConnection();
        $result = $conn->query("SELECT * FROM \"order\" WHERE finished = false ORDER BY endDate");
        return $result->fetchAll();
    }

    /**
     * Retrieves all orders from the database.
     *
     * Orders are sorted by their end date in ascending order.
     *
     * @return array An array containing all orders.
     */
    public static function listAll()
    {
        $conn = self::getConnection();
        $result = $conn->query("SELECT * FROM \"order\" ORDER BY endDate");
        return $result->fetchAll();
    }

    /**
     * Retrieves an order by its ID from the database.
     *
     * @param int $id The ID of the order to retrieve.
     * @return array|null The order data if found, or null if not found.
     */
    public static function find($id)
    {
        $conn = self::getConnection();
        $result = $conn->prepare("SELECT * FROM \"order\" WHERE id=:id");
        $result->execute([':id' => $id]);
        return $result->fetch();
    }

    /**
     * Saves an order to the database.
     *
     * If the order has an ID, it updates the existing order. Otherwise, it inserts a new order.
     *
     * @param array $order The order data to save.
     */
    public static function save($order)
    {
        $conn = self::getConnection();

        if (empty($order['id']))
        {
        $sql = "INSERT INTO \"order\" (
                    title, 
                    client, 
                    endDate, 
                    price, 
                    paymentMethod, 
                    description)

                VALUES (
                    :title, 
                    :client, 
                    :endDate, 
                    :price, 
                    :paymentMethod, 
                    :description)
               ";

        $result = $conn->prepare($sql);
        $result->execute([':title'        => $order['title'],
                         ':client'        => $order['client'],
                         ':endDate'       => $order['endDate'],
                         ':price'         => $order['price'],
                         ':paymentMethod' => $order['paymentMethod'],
                         ':description'   => $order['description']
                         ]);
        }
        else
        {
            $sql = "UPDATE \"order\" SET 
                        title         = :title, 
                        client        = :client, 
                        endDate       = :endDate, 
                        price         = :price, 
                        paymentMethod = :paymentMethod, 
                        description   = :description,
                        finished      = :finished
                    WHERE id = :id";

            $result = $conn->prepare($sql);
            $result->execute([':id'            => $order['id'],
                              ':title'         => $order['title'],
                              ':client'        => $order['client'],
                              ':endDate'       => $order['endDate'],
                              ':price'         => $order['price'],
                              ':paymentMethod' => $order['paymentMethod'],
                              ':description'   => $order['description'],
                              ':finished'      => $order['finished']
                             ]);
        }
    }

    /**
     * Deletes an order from the database by its ID.
     *
     * @param int $id The ID of the order to delete.
     * @return bool True if the order was successfully deleted, false otherwise.
     */
    public static function delete($id)
    {
        $conn = self::getConnection();
        $result = $conn->prepare("DELETE FROM \"order\" WHERE id=:id");   
        $result->execute([':id' => $id]);
        return $result->fetch();
    }
}