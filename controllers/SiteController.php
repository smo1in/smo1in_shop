<?php

/**
 *  Site Controller
 */
class SiteController
{

    /**
     * Action for main page
     */
    public function actionIndex()
    {
        // List of categories for the left menu
        $categories = Category::getCategoriesList();

        //List of latest products
        $latestProducts = Product::getLatestProducts(6);

        // List of products for the slider
        $sliderProducts = Product::getRecommendedProducts();

        // Connect the view
        require_once(ROOT . '/views/site/index.php');
        return true;
    }

    /**
     * Action for the page "Contacts"
     */
    public function actionContact()
    {

        // Form variables
        $userEmail = false;
        $userText = false;
        $result = false;

        // Form processing
        if (isset($_POST['submit'])) {
            // If the form is submitted
            // Get the data from the form
            $userEmail = $_POST['userEmail'];
            $userText = $_POST['userText'];

            // Error flag
            $errors = false;

            // Validation of fields
            if (!User::checkEmail($userEmail)) {
                $errors[] = 'Wrong email';
            }

            if ($errors == false) {
                // If there are no errors
                // Send the letter to the administrator
                $adminEmail = 'smo1in@ukr.net';
                $message = "Text: {$userText}. from {$userEmail}";
                $subject = 'Subject';
                $result = mail($adminEmail, $subject, $message);
                $result = true;
            }
        }

        // Connect the view
        require_once(ROOT . '/views/site/contact.php');
        return true;
    }
    
    /**
     * Action for the page "About"
     */
    public function actionAbout()
    {
        // Connect the view
        require_once(ROOT . '/views/site/about.php');
        return true;
    }

}
