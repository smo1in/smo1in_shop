<?php

/**
 * The abstract class AdminBase contains common logic for controllers that
 * used in admin panel
 */
abstract class AdminBase
{

    /**
     * A method that checks a user to see if he is an administrator.
     * @return boolean
     */
    public static function checkAdmin()
    {
        // Check whether the user is authorized. If not, it will be redirected
        $userId = User::checkLogged();

        // Get information about the current user
        $user = User::getUserById($userId);

        // If the role of the current user is "admin", let him go to admin panel
        if ($user['role'] == 'admin') {
            return true;
        }

        // Otherwise, complete the work with the message about closed access.
        die('Access denied');
    }

}
