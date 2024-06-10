<?php
require_once 'Order.php';
require_once 'Utility.php';

/**
 * Class OrderForm
 * 
 * This class represents a form for creating orders with the ability to save and display the form.
 * 
 * The OrderForm class provides methods to save and display an order creation form.
 * 
 * @author gustavoarantes 
 */
class OrderForm
{
    /**
     * @var string The HTML content of the order creation form.
     */
    private $html;

    /**
     * Path to the HTML template.
     */
    private const TEMPLATE_PATH = '/interfaces/form.html';

    /**
     * Constructs a new OrderForm object.
     * 
     * It loads the HTML template for the order creation form.
     */
    public function __construct()
    {
        $filePath = dirname(__DIR__) . self::TEMPLATE_PATH;
        $this->html = file_get_contents($filePath);
    }

    /**
     * Saves the data submitted from the order creation form.
     * 
     * @param array $order The parameters containing the data submitted from the form.
     */
    public function save(array $order): void
    {
        try {
            $order = $this->prepareOrderData($order);
            Order::save($order);
            header('Location: index.php');
            exit;
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    /**
     * Prepares the order data for saving.
     * 
     * @param array $order The raw order data.
     * @return array The prepared order data.
     */
    private function prepareOrderData(array $order): array
    {
        $order['order_price'] = Utility::orderPriceSaveDb($order['order_price']);
        $order['payment_installments'] = Utility::paymentInstallmentsSaveDb($order['payment_method'], $order['payment_installments']);
        $order['completion_date'] = Utility::dateSaveDb($order['completion_date']);
        return $order;
    }

    /**
     * Displays the HTML content of the order creation form.
     */
    public function show(): void
    {
        print $this->html;
    }
}