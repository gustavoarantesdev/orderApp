<?php
require_once 'Order.php';
require_once 'Utility.php';

/**
 * This class represents a form for updating orders with various actions such as updating, saving, and deleting.
 * 
 * The OrderFormUpdate class provides methods to update, save, delete, and display an order update form.
 * 
 * @author gustavoarantes 
 */
class OrderFormUpdate
{
    /**
     * @var string $html The HTML content of the order list.
     */
    private $html;

    /**
     * Path to the HTML template.
     */
    private const BASE_TEMPLATE_PATH = '/interfaces/updateForm.html';

    /**
     * @var string $data The data of the order.
     */
    private $data;

    /**
     * Constructs a new OrderFormUpdate object.
     * 
     * It loads the HTML template for the order update form.
     */
    public function __construct()
    {
        $filePath = dirname(__DIR__) . self::BASE_TEMPLATE_PATH;
        $this->html = file_get_contents($filePath);
    }

    /**
     * Loads the data of the order to be updated based on the provided ID.
     * 
     * @param array $param The url data.
     */
    public function update(array $param): void
    {
        try {
            $orderId = (int) $param['id'];
            $this->data = Order::find($orderId);
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    /**
     * Saves the updated data of the order.
     * 
     * @param array $order The url data.
     */
    public function save(array $order): void
    {
        try {
            $order = $this->prepareOrderData($order);
            Order::update($order);
            $this->data = $order;
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
     * Deletes an order based on the provided ID.
     * 
     * @param array $param The url data.
     */
    public function delete(array $param): void
    {
        try {
            $orderId = (int) $param['id'];
            Order::delete($orderId);
            header('Location: index.php');
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    /**
     * Displays the HTML content of the order update form with the data of the order to be updated.
     */

    /**
     * Populates the HTML content with the data of the order to be updated.
     */
    public function show(): void
    {
        $this->html = str_replace('{order_id}',    (string) $this->data['order_id'],    $this->html);
        $this->html = str_replace('{order_title}', (string) $this->data['order_title'], $this->html);
        $this->html = str_replace('{client_name}', (string) $this->data['client_name'], $this->html);

        $formattedDate = Utility::dateFormat($this->data['completion_date'], false);
        $this->html = str_replace('{completion_date}', (string) $formattedDate, $this->html);

        $this->html = str_replace('{completion_time}', (string) $this->data['completion_time'], $this->html);
        $this->html = str_replace('{order_price}',     (string) $this->data['order_price'],     $this->html);

        $this->html = $this->selectOption($this->html, 'payment_method',       $this->data['payment_method']);
        $this->html = $this->selectOption($this->html, 'payment_installments', $this->data['payment_installments']);

        $this->html = str_replace('{order_description}', (string) $this->data['order_description'], $this->html);

        $this->html = $this->checkRadioButton($this->html, 'is_completed', $this->data['is_completed']);

        $formattedDate = Utility::dateFormat($this->data['created_at'], false);
        $this->html = str_replace('{created_at}', (string) $formattedDate, $this->html);

        print $this->html;
    }

    /**
     * Selects the appropriate option in a dropdown.
     * 
     * @param string $html The HTML content.
     * @param string $value The value to select.
     * @return string The modified HTML content.
     */
    private function selectOption(string $html, string $name, string $value): string
    {
        return str_replace("value=\"$value\"", "value=\"$value\" selected", $html);
    }


    /**
     * Checks the appropriate radio button.
     * 
     * @param string $html The HTML content.
     * @param string $name The name of the radio button group.
     * @param bool $isChecked Whether the radio button should be checked.
     * @return string The modified HTML content.
     */
    private function checkRadioButton(string $html, string $name, bool $isChecked): string
    {
        $checkedValue = $isChecked ? 't' : 'f';
        return str_replace(
            "<input class=\"form-check-input\" type=\"radio\" name=\"$name\" value=\"$checkedValue\">",
            "<input class=\"form-check-input\" type=\"radio\" name=\"$name\" value=\"$checkedValue\" checked>",
            $html
        );
    }
}