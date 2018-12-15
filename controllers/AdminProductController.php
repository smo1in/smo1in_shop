<?php

/**
 * AdminProductController Controller
 * Management of products in the admin panel
 */
class AdminProductController extends AdminBase
{

    /**
     * Action for the page "Management of products"
     */
    public function actionIndex()
    {
        // Access check
        self::checkAdmin();

        // Receive the list of products
        $productsList = Product::getProductsList();

        // Connect the view
        require_once(ROOT . '/views/admin_product/index.php');
        return true;
    }

    /**
     * Action for the "Add product" page
     */
    public function actionCreate()
    {
        // Access check
        self::checkAdmin();

        // Get the list of categories for the drop-down list
        $categoriesList = Category::getCategoriesListAdmin();

        // Form processing
        if (isset($_POST['submit'])) {
            // If the form is submitted
            // Get the data from the form
            $options['name'] = $_POST['name'];
            $options['code'] = $_POST['code'];
            $options['price'] = $_POST['price'];
            $options['category_id'] = $_POST['category_id'];
            $options['brand'] = $_POST['brand'];
            $options['availability'] = $_POST['availability'];
            $options['description'] = $_POST['description'];
            $options['is_new'] = $_POST['is_new'];
            $options['is_recommended'] = $_POST['is_recommended'];
            $options['status'] = $_POST['status'];

            // Error flag in the form
            $errors = false;

            // Validate values as needed
            if (!isset($options['name']) || empty($options['name'])) {
                $errors[] = 'Fill in the fields';
            }

            if ($errors == false) {
                // If there are no errors
                // Add a new product
                $id = Product::createProduct($options);

                // If the record is added
                if ($id) {
                    // Check if the image is loaded through the form
                    //print_r($_FILES["image"]);die();
                    
                    if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                        // If downloaded, move it to the desired folder, give a new name.
                        move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/upload/images/products/{$id}.jpg");
                    }
                }

                // Redirecting the user to the product management page
                header("Location: /admin/product");
            }
        }

        // We connect the view
        require_once(ROOT . '/views/admin_product/create.php');
        return true;
    }

    /**
     * Action for the Edit Product page
     */
    public function actionUpdate($id)
    {
        // Access check
        self::checkAdmin();

        // Get the list of categories for the drop-down list
        $categoriesList = Category::getCategoriesListAdmin();

        // We receive data on a specific order
        $product = Product::getProductById($id);

        // Form processing
        if (isset($_POST['submit'])) {
            // If the form is submitted
            // Get data from the edit form. Validate values if necessary.
            $options['name'] = $_POST['name'];
            $options['code'] = $_POST['code'];
            $options['price'] = $_POST['price'];
            $options['category_id'] = $_POST['category_id'];
            $options['brand'] = $_POST['brand'];
            $options['availability'] = $_POST['availability'];
            $options['description'] = $_POST['description'];
            $options['is_new'] = $_POST['is_new'];
            $options['is_recommended'] = $_POST['is_recommended'];
            $options['status'] = $_POST['status'];

            // Save changes
            if (Product::updateProductById($id, $options)) {


                // If the record is saved
                // Check if the image is loaded through the form
                if (is_uploaded_file($_FILES["image"]["tmp_name"])) {

                    // If downloaded, move it to the desired folder, give a new name
                   move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/upload/images/products/{$id}.jpg");
                }
            }

            // Redirecting the user to the product management page
            header("Location: /admin/product");
        }

        //Connect the view
        require_once(ROOT . '/views/admin_product/update.php');
        return true;
    }

    /**
     * Action for the "Remove product" page
     */
    public function actionDelete($id)
    {
        // Access check
        self::checkAdmin();

        // Form processing
        if (isset($_POST['submit'])) {
            // If the form is submitted
            // Remove the products
            Product::deleteProductById($id);

            // Redirecting the user to the product management page
            header("Location: /admin/product");
        }

        // We connect the view
        require_once(ROOT . '/views/admin_product/delete.php');
        return true;
    }

}
