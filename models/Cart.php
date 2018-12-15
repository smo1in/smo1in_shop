<?php

/**
 *class Cart
 * Component for cart operation
 */
class Cart
{

    /**
     * Adding goods to the cart (session)
     * @param int $id <p>id product</p>
     * @return integer <p>Number of products in the cart</p>
     */
    public static function addProduct($id)
    {
        // Cast $ id to type integer
        $id = intval($id);

        // Empty array for items in the cart
        $productsInCart = array();

        // If the cart is not empty (products stored in the session)
        if (isset($_SESSION['products'])) {
            // Then fill  array of products
            $productsInCart = $_SESSION['products'];
        }

        // Check whether there is already such a product in the cart
        if (array_key_exists($id, $productsInCart)) {
            // If such a product is in the cart, but has been added again, increase the quantity by 1
            $productsInCart[$id] ++;
        } else {
            // If not, add the id of the new product to the cart with the quantity 1
            $productsInCart[$id] = 1;
        }

        //Write the array with the products in the session.
        $_SESSION['products'] = $productsInCart;

        // Return the number of products in the cart
        return self::countItems();
    }

    /**
     * Counting the number of products in the cart (in session)
     * @return int <p>Number of products in the cart</p>
     */
    public static function countItems()
    {
        // Check for products in cart
        if (isset($_SESSION['products'])) {
            // If there is an array of products
            // Calculate and return their quantity
            $count = 0;
            foreach ($_SESSION['products'] as $id => $quantity) {
                $count = $count + $quantity;
            }
            return $count;
        } else {
            // If there is no product, will return 0
            return 0;
        }
    }

    /**
     * Returns an array with identifiers and quantity of products in the cart.<br/>
     * If there is no product, returns false;
     * @return mixed: boolean or array
     */
    public static function getProducts()
    {
        if (isset($_SESSION['products'])) {
            return $_SESSION['products'];
        }
        return false;
    }

    /**
     * Get the total value of the products transferred
     * @param array $products <p>Array with information about products</p>
     * @return integer <p>total cost</p>
     */
    public static function getTotalPrice($products)
    {
        // Receive an array with identifiers and quantity of products in the cart
        $productsInCart = self::getProducts();

        // Calculate the total cost
        $total = 0;
        if ($productsInCart) {
            // If the cart is not empty
            //  to iterate on the array of products transferred to the method
            foreach ($products as $item) {
                // Find the total cost: Price * quantity
                $total += $item['price'] * $productsInCart[$item['id']];
            }
        }

        return $total;
    }

    /**
     * Clears the cart
     */
    public static function clear()
    {
        if (isset($_SESSION['products'])) {
            unset($_SESSION['products']);
        }
    }

    /**
     * Removes the product with the specified id from the cart
     * @param integer $id <p>id product</p>
     */
    public static function deleteProduct($id)
    {
        // Receive an array with identifiers and quantity of products in the cart
        $productsInCart = self::getProducts();

        // Remove from the array the element with the specified id
        unset($productsInCart[$id]);

        // Write an array of products to the remote element in the session
        $_SESSION['products'] = $productsInCart;
    }

}
