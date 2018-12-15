<?php

/**
 * Order class - model for working with orders
 */
class Order
{

    /**
     * Saving order
     * @param string $userName <p>Name</p>
     * @param string $userPhone <p>CellPhone</p>
     * @param string $userComment <p>Comment</p>
     * @param integer $userId <p>id user</p>
     * @param array $products <p>Array of products</p>
     * @return boolean <p>The result of executing the method</p>
     */
    public static function save($userName, $userPhone, $userComment, $userId, $products)
    {
        // DB connection
        $db = Db::getConnection();

        // Database query text
        $sql = 'INSERT INTO product_order (user_name, user_phone, user_comment, user_id, products) '
                . 'VALUES (:user_name, :user_phone, :user_comment, :user_id, :products)';

        $products = json_encode($products);

        $result = $db->prepare($sql);
        $result->bindParam(':user_name', $userName, PDO::PARAM_STR);
        $result->bindParam(':user_phone', $userPhone, PDO::PARAM_STR);
        $result->bindParam(':user_comment', $userComment, PDO::PARAM_STR);
        $result->bindParam(':user_id', $userId, PDO::PARAM_STR);
        $result->bindParam(':products', $products, PDO::PARAM_STR);

        return $result->execute();
    }

    /**
     * Returns a list of orders
     * @return array <p>Order list</p>
     */
    public static function getOrdersList()
    {
        // DB connection
        $db = Db::getConnection();

        // Receipt and return results
        $result = $db->query('SELECT id, user_name, user_phone, date, status FROM product_order ORDER BY id DESC');
        $ordersList = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $ordersList[$i]['id'] = $row['id'];
            $ordersList[$i]['user_name'] = $row['user_name'];
            $ordersList[$i]['user_phone'] = $row['user_phone'];
            $ordersList[$i]['date'] = $row['date'];
            $ordersList[$i]['status'] = $row['status'];
            $i++;
        }
        return $ordersList;
    }

    /**
     * Returns text status explanation for order :<br/>
     * <i>1 - New order, 2 - In processing, 3 - Delivered, 4 - Is closed</i>
     * @param integer $status <p>Status</p>
     * @return string <p>Text explanation</p>
     */
    public static function getStatusText($status)
    {
        switch ($status) {
            case '1':
                return 'New order';
                break;
            case '2':
                return 'In processing';
                break;
            case '3':
                return 'Delivered';
                break;
            case '4':
                return 'Is closed';
                break;
        }
    }

    /**
     * Returns an order with the specified id
     * @param integer $id <p>id</p>
     * @return array <p>Array with ordering information</p>
     */
    public static function getOrderById($id)
    {
        // DB connection
        $db = Db::getConnection();

        // Database query text
        $sql = 'SELECT * FROM product_order WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        // Specify to receive data as an array
        $result->setFetchMode(PDO::FETCH_ASSOC);

        // execute queries
        $result->execute();

        // Return the data
        return $result->fetch();
    }

    /**
     * Deletes an order with the given id
     * @param integer $id <p>id order</p>
     * @return boolean <p>The result of executing the method</p>
     */
    public static function deleteOrderById($id)
    {
        // DB connection
        $db = Db::getConnection();

        // Database query text
        $sql = 'DELETE FROM product_order WHERE id = :id';

        // Receive and return results. Use the prepared query
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }

    /**
     * Edits an order with a given id
     * @param integer $id <p>id product</p>
     * @param string $userName <p>User Name</p>
     * @param string $userPhone <p>phone User</p>
     * @param string $userComment <p>User comment</p>
     * @param string $date <p>Date of issue</p>
     * @param integer $status <p>Status <i> (on "1" off "0")</i></p>
     * @return boolean <p>The result of executing the method</p>
     */
    public static function updateOrderById($id, $userName, $userPhone, $userComment, $date, $status)
    {
        // DB connection
        $db = Db::getConnection();

        // Database query text
        $sql = "UPDATE product_order
            SET 
                user_name = :user_name, 
                user_phone = :user_phone, 
                user_comment = :user_comment, 
                date = :date, 
                status = :status 
            WHERE id = :id";

        // Receive and return results. Use the prepared query
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':user_name', $userName, PDO::PARAM_STR);
        $result->bindParam(':user_phone', $userPhone, PDO::PARAM_STR);
        $result->bindParam(':user_comment', $userComment, PDO::PARAM_STR);
        $result->bindParam(':date', $date, PDO::PARAM_STR);
        $result->bindParam(':status', $status, PDO::PARAM_INT);
        return $result->execute();
    }

}
