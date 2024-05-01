<?php
require_once 'Order.php';
require_once 'Utility.php';

/**
 * Represents a list of orders with various display options.
 *
 * The OrderList class provides methods to load and display a list of orders in different formats,
 * such as a simple list or a detailed list showing additional information.
 * 
 * @author gustavoarantes
 */
class OrderList
{
     /**
     * @var string $html The HTML content of the order list.
     */
    private $html;

     /**
     * Constructs a new OrderList object.
     *
     * If the 'method' parameter is not set in the request, it loads a basic order list HTML template.
     * Otherwise, it loads an HTML template for displaying all orders.
     */
    public function __construct()
    {
        if (!isset($_REQUEST['method']))
        {
            $file = dirname(__DIR__) . '/interfaces/list.html';
            $this->html = file_get_contents($file);
        }
        else
        {
            $file = dirname(__DIR__) . '/interfaces/listAll.html';
            $this->html = file_get_contents($file);
        }
    }

    /**
     * Loads the orders and populates the HTML content with order details.
     *
     * This method retrieves all orders and populates the HTML template with details of each order,
     * including ID, title, client, end date, price, and payment method.
     */
    public function load()
    {
        try
        {
            $orders = Order::all();

            $elements = '';
            foreach ($orders as $order)
            {
                $element = dirname(__DIR__) . '/interfaces/element.html';
                $element = file_get_contents($element);


                $element = str_replace('{id}',            $order['id'],            $element);
                $element = str_replace('{title}',         $order['title'],         $element);
                $element = str_replace('{client}',        $order['client'],        $element);

                $formattedDate = Utility::dateFormat($order['enddate'], false);
                $element = str_replace('{endDate}',       $formattedDate,          $element);

                $formattedPrice = Utility::priceFormat($order['price']);
                $element = str_replace('{price}',         $formattedPrice,         $element);

                $element = str_replace('{paymentMethod}', $order['paymentmethod'], $element);

                $elements .= $element;
            }
            $this->html = str_replace('{elements}', $elements, $this->html);
        }
        catch (Exception $e)
        {
            print $e->getMessage();
        }
    }

     /**
     * Loads all orders and populates the HTML content with detailed order information.
     *
     * This method retrieves all orders and populates the HTML template with detailed information of each order,
     * including ID, title, client, end date, price, payment method, status, and creation date.
     */
    public function listAll()
    {
        try
        {
            $orders = Order::listAll();
         

            $elements = '';
            foreach ($orders as $order)
            {
                $element = dirname(__DIR__) . '/interfaces/itemListAll.html';
                $element = file_get_contents($element);


                $element = str_replace('{id}',            $order['id'],            $element);
                $element = str_replace('{title}',         $order['title'],         $element);
                $element = str_replace('{client}',        $order['client'],        $element);

                $formattedDate = Utility::dateFormat($order['enddate'], true);
                $element = str_replace('{endDate}',       $formattedDate,          $element);

                $formattedPrice = Utility::priceFormat($order['price']);
                $element = str_replace('{price}',         $formattedPrice,         $element);

                $element = str_replace('{paymentMethod}', $order['paymentmethod'], $element);
                $element = str_replace('{status}',        $order['finished'],      $element);

                $formattedDate = Utility::dateFormat($order['creationdate'], true);
                $element = str_replace('{creationDate}',  $formattedDate,          $element);

                $elements .= $element;
            }
            $this->html = str_replace('{elements}', $elements, $this->html);
        }
        catch (Exception $e)
        {
            print $e->getMessage();
        }
    }

    /**
     * Displays the HTML content of the order list.
     */
    public function show()
    {
        $this->load();
        print $this->html;
    }
}