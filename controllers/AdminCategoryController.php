<?php

/**
 * AdminCategoryController Controller
 * Manage product categories in admin panel
 */
class AdminCategoryController extends AdminBase
{

    /**
     * Action for the Manage Categories page
     */
    public function actionIndex()
    {
        // Access check
        self::checkAdmin();

        // Get a list of categories
        $categoriesList = Category::getCategoriesListAdmin();

        // Connect the view
        require_once(ROOT . '/views/admin_category/index.php');
        return true;
    }

    /**
     * Action for the "Add category" page
     */
    public function actionCreate()
    {
        // Access check
        self::checkAdmin();

        // Form processing
        if (isset($_POST['submit'])) {
            // If the form is submitted
            // Get the data from the form
            $name = $_POST['name'];
            $sortOrder = $_POST['sort_order'];
            $status = $_POST['status'];

            // Error flag in the form
            $errors = false;

            // Validate values as needed.
            if (!isset($name) || empty($name)) {
                $errors[] = 'Fill in the fields';
            }


            if ($errors == false) {
                // If there are no errors
                // Add a new category
                Category::createCategory($name, $sortOrder, $status);

                // Redirecting users to the category management page.
                header("Location: /admin/category");
            }
        }

        require_once(ROOT . '/views/admin_category/create.php');
        return true;
    }

    /**
     * Action for the Edit Category page
     */
    public function actionUpdate($id)
    {
        // Access check
        self::checkAdmin();

        // Get data about a specific category
        $category = Category::getCategoryById($id);

        // Form processing
        if (isset($_POST['submit'])) {
            // If the form is submitted 
            // Get the data from the form
            $name = $_POST['name'];
            $sortOrder = $_POST['sort_order'];
            $status = $_POST['status'];

            // Save changes
            Category::updateCategoryById($id, $name, $sortOrder, $status);

            // Redirecting user to the category management page.
            header("Location: /admin/category");
        }

        // We connect the view
        require_once(ROOT . '/views/admin_category/update.php');
        return true;
    }

    /**
     * Action for the "Delete category" page
     */
    public function actionDelete($id)
    {
        // Access check
        self::checkAdmin();

        // Form processing
        if (isset($_POST['submit'])) {
            // If the form is submitted
            // Remove category
            Category::deleteCategoryById($id);

            // Redirecting the user to the product management page
            header("Location: /admin/category");
        }

        // Connect the view
        require_once(ROOT . '/views/admin_category/delete.php');
        return true;
    }

}
