<?php

/**
 * CabinetController Controller
 * User account
 */
class CabinetController
{

    /**
     * Action for the page "User Account"
     */
    public function actionIndex()
    {
        // Get user ID from session
        $userId = User::checkLogged();

        // Get user information from the database
        $user = User::getUserById($userId);

        // Connect view
        require_once(ROOT . '/views/cabinet/index.php');
        return true;
    }

    /**
     * Action for the "Edit User Data" page
     */
    public function actionEdit()
    {
        // Get user ID from session
        $userId = User::checkLogged();

        // Get user information from the database
        $user = User::getUserById($userId);

        // Fill in the variables for the form fields
        $name = $user['name'];
        $password = $user['password'];

        // Result flag
        $result = false;

        // Form processing
        if (isset($_POST['submit'])) {
            // If the form is submitted
            // Get data from the edit form
            $name = $_POST['name'];
            $password = $_POST['password'];

            // Error flag
            $errors = false;

            // Validating values
            if (!User::checkName($name)) {
                $errors[] = 'Name must not be shorter than 2 characters';
            }
            if (!User::checkPassword($password)) {
                $errors[] = 'Password must not be shorter than 6 characters';
            }

            if ($errors == false) {
                // If there are no errors, save the profile changes
                $result = User::edit($userId, $name, $password);
            }
        }

        // Connect the view
        require_once(ROOT . '/views/cabinet/edit.php');
        return true;
    }

}
