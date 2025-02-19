<?php

namespace App\Models;

use App\Helpers\ConvertDate;
use App\Helpers\ConvertPrice;
use App\Helpers\order\formatDataToView;
use PDO;
use App\Core\Model;

/**
 * Classe OrderModel
 *
 * Modelo responsável por gerenciar operações relacionadas às encomendas no banco de dados.
 *
 * Este modelo encapsula a lógica de acesso a dados para as encomendas,
 * incluindo a criação, leitura, atualização e exclusão (CRUD) de registros.
 * Também fornece métodos para filtrar e formatar os dados das encomendas
 * antes de apresentá-los na aplicação.
 */
class OrderModel extends Model
{
    private PDO $pdo;

    /**
     * Inicializa a conexão com o banco de dados.
     */
    public function __construct()
    {
        $this->pdo = $this->getConnection();
    }

    /**
     * Retorna as encomendas disponíveis (não concluídas).
     *
     * @return object
     */
    public function getAvailableOrders(): object
    {
        // Seleciona todos as encomendas
        $stmt = $this->pdo->prepare("
            SELECT
                orders.id,
                orders.order_number,
                orders.subtotal,
                orders.payment_value,
                orders.payment_status,
                orders.payment_method,
                orders.completion_date,
                orders.completion_time,
                orders.withdraw,
                orders.order_status,
                customers.name as customer_name
            FROM orders
            INNER JOIN customers ON orders.customer_id = customers.id
            WHERE orders.order_status != 3 AND orders.user_id = :user_id
            ORDER BY order_status = 2 DESC, completion_date, completion_time;
        ");

        $stmt->execute([
            'user_id' => $_SESSION['user_id']
        ]);

        $ordersData = $stmt->fetchAll();

        /* Seleciona todos os itens da encomenda, adicionando os items em suas
        respectivas encomendas.*/
        foreach ($ordersData as $orderDataRow) {
            // Busca os itens da encomenda
            $stmt = $this->pdo->prepare("
                SELECT
                    order_items.quantity,
                    products.name AS product_name
                FROM order_items
                INNER JOIN products ON order_items.product_id = products.id
                WHERE order_items.order_id = :order_id AND order_items.user_id = :user_id
            ");

            $stmt->execute([
                ':order_id' => $orderDataRow->id,
                'user_id' => $_SESSION['user_id']
            ]);

            $items = $stmt->fetchAll();

            // Adiciona os items da encomenda em cada encomenda.
            $orderDataRow->items = $items;
        }

        $ordersData = (object) $ordersData;

        // Aplica as formatações nos dados.
        formatDataToView::handle($ordersData);

        return $ordersData;
    }

    /**
     * Retorna todas as encomendas, ordenadas pela data de conclusão.
     *
     * @return object
     */
    public function getAllOrders(): object
    {
        $stmt = $this->pdo->prepare("
        SELECT
            orders.id,
            orders.order_number,
            orders.subtotal,
            orders.payment_value,
            orders.payment_status,
            orders.payment_method,
            orders.completion_date,
            orders.order_status,
            customers.name AS customer_name
        FROM orders
        INNER JOIN customers ON orders.customer_id = customers.id
        WHERE orders.user_id = :user_id
        ORDER BY completion_date
        ");

        $stmt->execute([
            'user_id' => $_SESSION['user_id']
        ]);

        $ordersData = $stmt->fetchAll();

        $ordersData = (object) $ordersData;

        // Aplica as formatações nos dados.
        formatDataToView::handle($ordersData);

        return $ordersData;
    }

    /**
     * Registra uma nova encomenda na tabela orders e adiciona os produdos da
     * encomenda na tabela order_items.
     *
     * @param object $orderData Dados da encomenda.
     * @return void
     */
    public function createOrderWithItems(object $orderData): void
    {
        // Registra os dados da encomenda
        $stmt = $this->pdo->prepare(
        "INSERT INTO orders (
            user_id,
            customer_id,
            order_number,
            delivery_address,
            additional,
            discount,
            subtotal,
            payment_value,
            payment_status,
            payment_method,
            payment_installments,
            payment_date,
            completion_date,
            completion_time,
            withdraw,
            order_status,
            description
        ) VALUES (
            :user_id,
            :customer_id,
            :order_number,
            :delivery_address,
            :additional,
            :discount,
            :subtotal,
            :payment_value,
            :payment_status,
            :payment_method,
            :payment_installments,
            :payment_date,
            :completion_date,
            :completion_time,
            :withdraw,
            :order_status,
            :description
        )");

        $stmt->execute([
            ':user_id'              => $_SESSION['user_id'],
            ':customer_id'          => $orderData->customer_id,
            ':order_number'         => $this->getOrderNumber(),
            ':delivery_address'     => $orderData->delivery_address,
            ':additional'           => $orderData->additional,
            ':discount'             => $orderData->discount,
            ':subtotal'             => $orderData->subtotal,
            ':payment_value'        => $orderData->payment_value,
            ':payment_status'       => $orderData->payment_status,
            ':payment_method'       => $orderData->payment_method,
            ':payment_installments' => $orderData->payment_installments,
            ':payment_date'         => $orderData->payment_date,
            ':completion_date'      => $orderData->completion_date,
            ':completion_time'      => $orderData->completion_time,
            ':withdraw'             => $orderData->withdraw,
            ':order_status'         => $orderData->order_status,
            ':description'          => $orderData->description
        ]);

        // Armazena o último ID adicionado na tabela orders
        $order_id = $this->pdo->lastInsertId();

        // Registra os produtos da encomenda
        $this->addOrderItems($orderData, $order_id);
    }

    /**
     * Atualiza uma encomenda na tabela orders e adiciona os produdos da
     * encomenda na tabela order_items.
     *
     * @param object $orderdata Dados da encomenda a ser atualizada.
     * @return void
     */
    public function updateOrderWithItems(object $orderData): void
    {
        // Edita os dados da encomenda
        $stmt = $this->pdo->prepare(
            "UPDATE orders SET
                customer_id          = :customer_id,
                delivery_address     = :delivery_address,
                additional           = :additional,
                discount             = :discount,
                subtotal             = :subtotal,
                payment_value        = :payment_value,
                payment_status       = :payment_status,
                payment_method       = :payment_method,
                payment_installments = :payment_installments,
                payment_date         = :payment_date,
                completion_date      = :completion_date,
                withdraw             = :withdraw,
                order_status         = :order_status,
                description          = :description
            WHERE id = :id AND user_id = :user_id
        ");

        $stmt->execute([
            ':id'                   => $orderData->id,
            ':user_id'              => $_SESSION['user_id'],
            ':customer_id'          => $orderData->customer_id,
            ':delivery_address'     => $orderData->delivery_address,
            ':additional'           => $orderData->additional,
            ':discount'             => $orderData->discount,
            ':subtotal'             => $orderData->subtotal,
            ':payment_value'        => $orderData->payment_value,
            ':payment_status'       => $orderData->payment_status,
            ':payment_method'       => $orderData->payment_method,
            ':payment_installments' => $orderData->payment_installments,
            ':payment_date'         => $orderData->payment_date,
            ':completion_date'      => $orderData->completion_date,
            ':withdraw'             => $orderData->withdraw,
            ':order_status'         => $orderData->order_status,
            ':description'          => $orderData->description,
        ]);

        // Deleta os produtos da encomenda
        $stmt = $this->pdo->prepare(
            "DELETE FROM order_items WHERE user_id = :user_id AND order_id = :order_id"
        );

        $stmt->execute([
            ':user_id' => $_SESSION['user_id'],
            ':order_id' => $orderData->id
        ]);

        // Registra os produtos da encomenda
        $this->addOrderItems($orderData, $orderData->id);
    }

    /**
     * Registra os produtos da encomenda.
     *
     * @param object $orderData Os dados da encomenda.
     * @return void
     */
    private function addOrderItems(object $orderData, int $order_id): void
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO order_items (
                order_id,
                user_id,
                product_id,
                sell_price,
                quantity
            ) VALUES (
                :order_id,
                :user_id,
                :product_id,
                :sell_price,
                :quantity
        )");

        // Percorre os produtos dentro do objeto $orderData
        foreach ($orderData->products as $product) {
            $stmt->execute([
                ':order_id'   => $order_id,
                ':user_id'    => $_SESSION['user_id'],
                ':product_id' => $product['product_id'],
                ':sell_price' => $product['sell_price'],
                ':quantity'   => $product['quantity']
            ]);
        }
    }

    /**
     * Calcula o número da encomenda, de acordo com o maior número de encomedas encontrado.
     *
     * @return int
     */
    private function getOrderNumber(): int
    {
        $stmt = $this->pdo->prepare(
            "SELECT MAX(order_number) AS order_number FROM orders WHERE user_id = :user_id"
        );

        $stmt->execute([
            ':user_id' => $_SESSION['user_id']
        ]);

        $result = $stmt->fetch();

        return $result->order_number ? $result->order_number + 1 : $result->order_number = 1;
    }

    /**
     * Busca uma encomenda pelo ID informado.
     * Se não for encontrada retorna null.
     *
     * @param integer $orderId
     * @return mixed
     */
    public function fetchOrderById(int $id): mixed
    {
        // Verifica se existe um registro com o ID informado
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE id = :id AND user_id = :user_id");
        $stmt->execute([
            ':id' => $id,
            'user_id' => $_SESSION['user_id']
        ]);

        if ($stmt->rowCount() == 0) {
            return null;
        }

        // Busca os detalhes da encomenda com o cliente
        $stmt = $this->pdo->prepare("
            SELECT
                orders.*,
                customers.name as customer_name,
                customers.phone AS customer_phone
            FROM orders
            INNER JOIN customers ON orders.customer_id = customers.id
            WHERE orders.id = :id AND orders.user_id = :user_id
        ");

        $stmt->execute([
            ':id' => $id,
            'user_id' => $_SESSION['user_id']
        ]);

        $orderData = (array) $stmt->fetch();

        // Converte a moeda dos campos para pt-BR
        $orderData['additional']    = ConvertPrice::handle($orderData['additional'], 'br');
        $orderData['discount']      = ConvertPrice::handle($orderData['discount'], 'br');
        $orderData['subtotal']      = ConvertPrice::handle($orderData['subtotal'], 'br');
        $orderData['payment_value'] = ConvertPrice::handle($orderData['payment_value'], 'br');

        // Formata a data para pt-BR
        $orderData['created_at']    = ConvertDate::handle($orderData['created_at']);

        // Busca os itens da encomenda
        $stmt = $this->pdo->prepare("
            SELECT
                order_items.*,
                products.name AS product_name
            FROM order_items
            INNER JOIN products ON order_items.product_id = products.id
            WHERE order_items.order_id = :order_id AND order_items.user_id = :user_id
        ");

        $stmt->execute([
            ':order_id' => $orderData['id'],
            'user_id' => $_SESSION['user_id']
        ]);

        $items = $stmt->fetchAll();

        // Converte o preço de venda de cada produto para pt-BR
        foreach ($items as $item) {
            $item->sell_price = ConvertPrice::handle($item->sell_price, 'br');
        }

        $orderData['items'] = $items;

        return (object) $orderData;
    }

    /**
     * Deleta uma encomenda pelo ID informado.
     *
     * @param integer $id ID da encomenda.
     * @return bool
     */
    public function deleteOrder(int $id): bool
    {
        $stmt = $this->pdo->prepare(
            "DELETE FROM orders WHERE id = :id AND user_id = :user_id"
        );

        $stmt->execute([
            ':id' => $id,
            ':user_id' => $_SESSION['user_id']
        ]);

        return $stmt->rowCount() > 0;
    }
}
