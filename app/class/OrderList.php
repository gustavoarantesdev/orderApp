<?php
require_once 'Order.php';
require_once 'Utility.php';

class OrderList
{
    private $html;

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

                $formattedDate = Utility::dateFormat($order['enddate'],);
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

                $formattedDate = Utility::dateFormat($order['enddate'], 'noTime');
                $element = str_replace('{endDate}',       $formattedDate,          $element);

                $formattedPrice = Utility::priceFormat($order['price']);
                $element = str_replace('{price}',         $formattedPrice,         $element);

                $element = str_replace('{paymentMethod}', $order['paymentmethod'], $element);
                $element = str_replace('{status}',        $order['finished'],      $element);

                $formattedDate = Utility::dateFormat($order['creationdate'], 'noTime');
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


    public function show()
    {
        $this->load();
        print $this->html;
    }
}