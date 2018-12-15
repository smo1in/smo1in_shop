<?php

/**
 * CartController Controller
  * Shopping Cart
 */
class CartController
{

    /**
     * Action to add product to cart by synchronous request<br/>
     * (for example, not used)
     * @param integer $id <p>id product</p>
     */
    public function actionAdd($id)
    {
        // Add product to cart
        Cart::addProduct($id);

        // Return the user to the page from which it came
        $referrer = $_SERVER['HTTP_REFERER'];
        header("Location: $referrer");
    }

    /**
     * Action to add products to the cart using an asynchronous request (ajax)
     * @param integer $id <p>id product</p>
     */
    public function actionAddAjax($id)
    {
        // Add the product to the cart and print the result: the number of products in the cart
        echo Cart::addProduct($id);
        return true;
    }
    
    /**
     * Action to add product to cart by synchronous request
     * @param integer $id <p>id product</p>
     */
    public function actionDelete($id)
    {
        // Remove the specified product from the cart
        Cart::deleteProduct($id);

        // Return the user to the cart
        header("Location: /cart");
    }

    /**
     * Action for the page "Shopping Cart"
     */
    public function actionIndex()
    {
        // List of categories for the left menu
        $categories = Category::getCategoriesList();

        // Get the identifiers and the number of items in the cart
        $productsInCart = Cart::getProducts();

        if ($productsInCart) {
            // If there are products in the cart, we get full information about the product for the list
            // Get an array with product IDs only
            $productsIds = array_keys($productsInCart);

            // Get an array with complete information about the necessary products
            $products = Product::getProdustsByIds($productsIds);

            // Get the total value of the products
            $totalPrice = Cart::getTotalPrice($products);
        }

        // Connect the view
        require_once(ROOT . '/views/cart/index.php');
        return true;
    }

    /**
     * Action for the "Purchase" page
     */
    public function actionCheckout()
    {
        // Retrieving data from the cart   
        $productsInCart = Cart::getProducts();

        // If there are no products,  send user to search for products on the main page
        if ($productsInCart == false) {
            header("Location: /");
        }

        // List of categories for the left menu
        $categories = Category::getCategoriesList();

        // Get the total cost
        $productsIds = array_keys($productsInCart);
        $products = Product::getProdustsByIds($productsIds);
        $totalPrice = Cart::getTotalPrice($products);

        // Quantity of  products
        $totalQuantity = Cart::countItems();

        // Form fields
        $userName = false;
        $userPhone = false;
        $userComment = false;

        // Successful checkout status
        $result = false;

        // Check if the user is a guest
        if (!User::isGuest()) {
            // If the user is not a guest
            // Receive information about the user from the database
            $userId = User::checkLogged();
            $user = User::getUserById($userId);
            $userName = $user['name'];
        } else {
            // If the guest, the form fields will be empty
            $userId = false;
        }

        // Form processing
        if (isset($_POST['submit'])) {
            // If the form is submitted
            // Get the data from the form
            $userName = $_POST['userName'];
            $userPhone = $_POST['userPhone'];
            $userComment = $_POST['userComment'];

            // Error flag
            $errors = false;

            // Validation of fields
            if (!User::checkName($userName)) {
                $errors[] = 'Wrong name';
            }
            if (!User::checkPhone($userPhone)) {
                $errors[] = 'Wrong number';
            }


            if ($errors == false) {
                // If there are no errors
                // Save the order in a database
                $result = Order::save($userName, $userPhone, $userComment, $userId, $productsInCart);

                if ($result) {
                    // If the order is successfully saved
                    // Notify the administrator of a new order by mail               
                    $adminEmail = 'smolingm@gmail.com';
                    $message = '<a href="https://smo1in.000webhostapp.com/admin/orders">Order List</a>';
                    $subject = 'New order!';
                    mail($adminEmail, $subject, $message);

                    // Clearing the cart
                    Cart::clear();
                }
            }
        }

        // Connect the view
        require_once(ROOT . '/views/cart/checkout.php');
        return true;
    }

}
