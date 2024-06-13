<?php
require_once 'Order.php';
require_once 'Utility.php';

/**
 * This class represents a list of orders with various display options.
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
     * Path to the base HTML template.
     */
    private const BASE_TEMPLATE_PATH = '/interfaces/list.html';

    /**
     * Path to the all orders HTML template.
     */
    private const ALL_TEMPLATE_PATH = '/interfaces/listAll.html';

    /**
     * Constructs a new OrderList object.
     *
     * If the 'method' parameter is not set in the request, it loads a basic order list HTML template.
     * Otherwise, it loads an HTML template for displaying all orders.
     */
    public function __construct()
    {
        $filePath = dirname(__DIR__) . (isset($_REQUEST['method']) ? self::ALL_TEMPLATE_PATH : self::BASE_TEMPLATE_PATH);
        $this->html = file_get_contents($filePath);
    }

    /**
     * Loads the orders and populates the HTML content with order details.
     *
     * This method retrieves all orders and populates the HTML template with details of each order,
     * including ID, title, client, end date, price, and payment method.
     */
    public function load(): void
    {
        try {
            $orders = Order::all();

            $elements = '';
            foreach ($orders as $order) {
                $element = dirname(__DIR__) . '/interfaces/cardItem.html';
                $element = file_get_contents($element);

                $element = str_replace('{id}', $order['order_id'], $element);

                $cuttedTitle = Utility::cutTitle($order['order_title']);
                $element = str_replace('{title}', $cuttedTitle, $element);

                $formatedClient = Utility::formatClient($order['client_name']);
                $element = str_replace('{client}', $formatedClient, $element);

                $formattedDate = Utility::dateFormat($order['completion_date'], $order['completion_time'], true);
                $element = str_replace('{endDate}', $formattedDate, $element);

                $formattedPrice = Utility::priceFormat($order['order_price']);
                $element = str_replace('{price}', $formattedPrice, $element);

                $element = str_replace('{paymentMethod}', $order['payment_method'], $element);

                $daysCounted = Utility::daysCount($order['completion_date']);
                $element = str_replace('{daysCount}', $daysCounted, $element);

                $elements .= $element;
            }
            $this->html = str_replace('{elements}', $elements, $this->html);

        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

     /**
     * Loads all orders and populates the HTML content with detailed order information.
     *
     * This method retrieves all orders and populates the HTML template with detailed information of each order,
     * including ID, title, client, end date, price, payment method, status, and creation date.
     */
    public function listAll(): void
    {
        try {
            $orders = Order::listAll();
         

            $elements = '';
            foreach ($orders as $order) {
                $element = dirname(__DIR__) . '/interfaces/itemListAll.html';
                $element = file_get_contents($element);

                $element = str_replace('{id}', $order['order_id'], $element);

                $cuttedTitle = Utility::cutTitle($order['order_title']);
                $element = str_replace('{title}', $cuttedTitle, $element);

                $formatedClient = Utility::formatClient($order['client_name']);
                $element = str_replace('{client}', $formatedClient, $element);
  
                $formattedDate = Utility::dateFormat($order['completion_date'], $order['completion_time']);
                $element = str_replace('{endDate}', $formattedDate, $element);

                $formattedPrice = Utility::priceFormat($order['order_price']);
                $element = str_replace('{price}', $formattedPrice, $element);

                $formatedPaymentMethod = Utility::formatPaymentMethod($order['payment_method']);
                $element = str_replace('{paymentMethod}', $formatedPaymentMethod, $element);

                $formattedFinishStatus = Utility::orderStatus($order['is_completed'], $order['completion_date']);
                $element = str_replace('{status}', $formattedFinishStatus, $element);

                $elements .= $element;
            }
            $this->html = str_replace('{elements}', $elements, $this->html);

        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    /**
     * Displays the HTML content of the order list.
     */
    public function show(): void
    {
        $this->load();
        print $this->html;
    }
}