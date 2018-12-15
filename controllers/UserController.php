<?php

/**
 * UserController
 */
class UserController
{
    /**
     * Action for the "Registration" page
     */
    public function actionRegister()
    {
        // Form variables
        $name = false;
        $email = false;
        $password = false;
        $result = false;

        // Form processing
        if (isset($_POST['submit'])) {
            // If the form is submitted 
            // Get the data from the form
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            //Error flag
            $errors = false;

            // Validation of fields
            if (!User::checkName($name)) {
                $errors[] = 'Name must not be shorter than 2 characters';
            }
            if (!User::checkEmail($email)) {
                $errors[] = 'Invalid email';
            }
            if (!User::checkPassword($password)) {
                $errors[] = 'Password must not be shorter than 6 characters';
            }
            if (User::checkEmailExists($email)) {
                $errors[] = 'This email is already in use.';
            }
            
            if ($errors == false) {
                // If there are no errors
                // Register user
                $result = User::register($name, $email, $password);
            }
        }

        // Connect the view
        require_once(ROOT . '/views/user/register.php');
        return true;
    }
    
    /**
     * Action for the "Log in " page
     */
    public function actionLogin()
    {
        // Form variables
        $email = false;
        $password = false;
        
        // Form processing
        if (isset($_POST['submit'])) {
            // If the form is submitted 
            // Get the data from the form
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Error flag
            $errors = false;

            // Validation of fields
            if (!User::checkEmail($email)) {
                $errors[] = 'Incorrect email';
            }
            if (!User::checkPassword($password)) {
                $errors[] = 'Password must not be shorter than 6 characters';
            }

            // Check if user exists
            $userId = User::checkUserData($email, $password);

            if ($userId == false) {
                // If the data is incorrect, show an error
                $errors[] = 'Incorrect login details';
            } else {
                // If the data is correct, remember the user (session)
                User::auth($userId);

                // Redirect the user to the closed part - cabinet
                header("Location: /cabinet");
            }
        }

        // Connect the view
        require_once(ROOT . '/views/user/login.php');
        return true;
    }

    /**
     * Remove user data from session
     */
    public function actionLogout()
    {
        // Start the session
        session_start();
        
        // Remove user information from the session
        unset($_SESSION["user"]);
        
        // Redirect the user to the main page
        header("Location: /");
    }

}
