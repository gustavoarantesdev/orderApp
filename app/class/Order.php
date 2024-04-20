<?php

class Order
{
    private static $conn;

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

    public static function all()
    {
        $conn = self::getConnection();
        $result = $conn->query("SELECT * FROM \"order\" ORDER BY endDate");
        return $result->fetchAll();
    }

    public static function save($order)
    {
        $conn = self::getConnection();
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

    public static function delete($id)
    {
        $conn = self::getConnection();
        $result = $conn->prepare("DELETE FROM \"order\" WHERE id=:id");   
        $result->execute([':id' => $id]);
        return $result->fetch();
    }
}
