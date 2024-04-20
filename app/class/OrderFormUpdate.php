<?php

require_once 'Order.php';

class OrderFormUpdate
{
    private $html;
    private $data;

    public function __construct()
    {
        $file = dirname(__DIR__) . '/interfaces/updateForm.html';
        $this->html = file_get_contents($file);
    }

    public function update($param)
    {
        try
        {
            $id = (int) $param['id'];
            $this->data = Order::find($id);
        }
        catch (Exception $e)
        {
            print $e->getMessage();
        }
    }

    public function save($param)
    {
        try
        {
            Order::save($param);
            $this->data = $param;
            print "Cadastrado com Sucesso";
        }
        catch (Exception $e)
        {
            print $e->getMessage();
        }
   }

    public function show()
    {
        $this->html = str_replace('{id}', (string) $this->data['id'], $this->html);
        $this->html = str_replace('{title}', (string) $this->data['title'], $this->html);
        $this->html = str_replace('{client}', (string) $this->data['client'], $this->html);
        $this->html = str_replace('{endDate}', (string) $this->data['enddate'], $this->html);
        $this->html = str_replace('{price}', (string) $this->data['price'], $this->html);
        $this->html = str_replace('{paymentMethod}', (string) $this->data['paymentmethod'], $this->html);
        $this->html = str_replace('{description}', (string) $this->data['description'], $this->html);
        $this->html = str_replace('{creationDate}', (string) $this->data['creationdate'], $this->html);

        print $this->html;
    }
}

