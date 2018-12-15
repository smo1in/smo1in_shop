<?php

/**
 * controller CatalogController
 * Catalog of products
 */
class CatalogController
{

    /**
     * Action for page "Catalog"
     */
    public function actionIndex()
    {
        // Categorylist for the left menu
        $categories = Category::getCategoriesList();

        //List of latest products
        $latestProducts = Product::getLatestProducts(12);

        // Connect the view
        require_once(ROOT . '/views/catalog/index.php');
        return true;
    }

    /**
     * Action for page "category"
     */
    public function actionCategory($categoryId, $page = 1)
    {
        // Categorylist for the left menu
        $categories = Category::getCategoriesList();

        // List of products in category
        $categoryProducts = Product::getProductsListByCategory($categoryId, $page);

        // Total quantity of products (necessary for page navigation)
        $total = Product::getTotalProductsInCategory($categoryId);

        // Create a Pagination object - page navigation
        $pagination = new Pagination($total, $page, Product::SHOW_BY_DEFAULT, 'page-');

        // Connect the view
        require_once(ROOT . '/views/catalog/category.php');
        return true;
    }

}
