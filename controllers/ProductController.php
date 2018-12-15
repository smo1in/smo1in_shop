<?php

/**
 * controller ProductController
 * product
 */
class ProductController
{

    /**
     * Action for view of product detail
     * @param integer $productId <p>id product</p>
     */
    public function actionView($productId)
    {
        // Categorylist for the left menu
        $categories = Category::getCategoriesList();

        // Get product details 
        $product = Product::getProductById($productId);

        // Connect  product view
        require_once(ROOT . '/views/product/view.php');
        return true;
    }

}
