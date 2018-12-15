<?php

/**
 * AdminOrderController Controller
 * Manage orders in admin panel
 */
class AdminOrderController extends AdminBase
{

    /**
     * Action for the Order Management page
     */
    public function actionIndex()
    {
        // Access check
        self::checkAdmin();

        // We receive a list of orders
        $ordersList = Order::getOrdersList();

        // Connect the view
        require_once(ROOT . '/views/admin_order/index.php');
        return true;
    }

    /**
     * Action for the "Edit Order" page
     */
    public function actionUpdate($id)
    {
        // Access check
        self::checkAdmin();

        // We receive data on a specific order
        $order = Order::getOrderById($id);

        // Form processing
        if (isset($_POST['submit'])) {
            // If the form is submitted
            // Get the data from the form
            $userName = $_POST['userName'];
            $userPhone = $_POST['userPhone'];
            $userComment = $_POST['userComment'];
            $date = $_POST['date'];
            $status = $_POST['status'];

            // Save changes
            Order::updateOrderById($id, $userName, $userPhone, $userComment, $date, $status);

            // Redirecting the user to the order management page
            header("Location: /admin/order/view/$id");
        }

        // We connect the view
        require_once(ROOT . '/views/admin_order/update.php');
        return true;
    }

    /**
     * Action for the "View Order" page
     */
    public function actionView($id)
    {
        // Access check
        self::checkAdmin();

        // We receive data on a specific order
        $order = Order::getOrderById($id);

        //We receive an array with identifiers and quantity of goods
        $productsQuantity = json_decode($order['products'], true);

        //We receive an array with the identifiers of goods
        $productsIds = array_keys($productsQuantity);

        // We get a list of goods in the order
        $products = Product::getProdustsByIds($productsIds);

        // Connect the view
        require_once(ROOT . '/views/admin_order/view.php');
        return true;
    }

    /**
     * Action for page "Delete order"
     */
    public function actionDelete($id)
    {
        // Access check
        self::checkAdmin();

        // Form processing
        if (isset($_POST['submit'])) {
            // If the form is submitted
            // Remove the order
            Order::deleteOrderById($id);

            // Redirecting the user to the product management page
            header("Location: /admin/order");
        }

        // Connect the view
        require_once(ROOT . '/views/admin_order/delete.php');
        return true;
    }

}
