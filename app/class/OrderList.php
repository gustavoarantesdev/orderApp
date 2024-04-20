<?php
require_once 'Order.php';

class OrderList
{
    private $html;

    public function __construct()
    {
        $file = dirname(__DIR__) . '/interfaces/list.html';
        $this->html = file_get_contents($file);
    }

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

                $element = str_replace('{id}', $order['id'], $element);
                $element = str_replace('{title}', $order['title'], $element);
                $element = str_replace('{client}', $order['client'], $element);
                $element = str_replace('{endDate}', $order['enddate'], $element);
                $element = str_replace('{description}', $order['description'], $element);
                $element = str_replace('{price}', $order['price'], $element);

                $elements .= $element;
            }
            $this->html = str_replace('{elements}', $elements, $this->html);
        }
        catch (Exception $e)
        {
            print $e->getMessage();
        }
    }

    public function show()
    {
        $this->load();
        print $this->html;
    }

    public function delete($param)
    {
        try
        {
            $id = (int) $param['id'];
            Order::delete($id);
        }
        catch (Exception $e)
        {
            print $e->getMessage();
        }
    }
}
