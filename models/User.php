<?php

/**
 * User class - a model for working with users
 */
class User
{

    /**
     * User registration
     * @param string $name <p>Name</p>
     * @param string $email <p>E-mail</p>
     * @param string $password <p>Password</p>
     * @return boolean <p>The result of executing the method</p>
     */
    public static function register($name, $email, $password)
    {
        // DB connection
        $db = Db::getConnection();

        // Database query text
        $sql = 'INSERT INTO user (name, email, password) '
                . 'VALUES (:name, :email, :password)';

        // Receive and return results. Use the prepared query
        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        return $result->execute();
    }

    /**
     * Editing user data
     * @param integer $id <p>id user</p>
     * @param string $name <p>Name</p>
     * @param string $password <p>Password</p>
     * @return boolean <p>The result of executing the method</p>
     */
    public static function edit($id, $name, $password)
    {
        // DB connection
        $db = Db::getConnection();

        // Database query text
        $sql = "UPDATE user 
            SET name = :name, password = :password 
            WHERE id = :id";

        // Receive and return results. Use the prepared query
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        return $result->execute();
    }

    /**
     * Check if the user exists with the given $ email and $ password
     * @param string $email <p>E-mail</p>
     * @param string $password <p>Password</p>
     * @return mixed : integer user id or false
     */
    public static function checkUserData($email, $password)
    {
        // DB connection
        $db = Db::getConnection();

        // Database query text
        $sql = 'SELECT * FROM user WHERE email = :email AND password = :password';

        // Getting results. Use the prepared query
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_INT);
        $result->bindParam(':password', $password, PDO::PARAM_INT);
        $result->execute();

        //Appeal to the record
        $user = $result->fetch();

        if ($user) {
            // If the record exists, return the user id
            return $user['id'];
        }
        return false;
    }

    /**
     * Remember user
     * @param integer $userId <p>id user</p>
     */
    public static function auth($userId)
    {
        // Write the user ID to the session.
        $_SESSION['user'] = $userId;
    }

    /**
     * Returns the user id if it is authorized.<br/>
     * Otherwise redirects to the login page.
     * @return string <p>Identifier user</p>
     */
    public static function checkLogged()
    {
        // If there is a session, return the user ID
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }

        header("Location: /user/login");
    }

    /**
     * Checks if a user is a guest.
     * @return boolean <p>The result of executing the method</p>
     */
    public static function isGuest()
    {
        if (isset($_SESSION['user'])) {
            return false;
        }
        return true;
    }

    /**
     * Checks name: not less than 2 characters
     * @param string $name <p>Name</p>
     * @return boolean <p>The result of executing the method</p>
     */
    public static function checkName($name)
    {
        if (strlen($name) >= 2) {
            return true;
        }
        return false;
    }

    /**
     *Phone checks: not less than 10 characters
     * @param string $phone <p>Phone</p>
     * @return boolean <p>The result of executing the method</p>
     */
    public static function checkPhone($phone)
    {
        if (strlen($phone) >= 10) {
            return true;
        }
        return false;
    }

    /**
     * Проверяет имя: не меньше, чем 6 символов
     * @param string $password <p>Password</p>
     * @return boolean <p>The result of executing the method</p>
     */
    public static function checkPassword($password)
    {
        if (strlen($password) >= 6) {
            return true;
        }
        return false;
    }

    /**
     * Check email
     * @param string $email <p>E-mail</p>
     * @return boolean <p>The result of executing the method</p>
     */
    public static function checkEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    /**
     * Checks if email is busy with another user
     * @param type $email <p>E-mail</p>
     * @return boolean <p>The result of executing the method</p>
     */
    public static function checkEmailExists($email)
    {
        // DB connection        
        $db = Db::getConnection();

        // Database query text
        $sql = 'SELECT COUNT(*) FROM user WHERE email = :email';

        // Getting results. Use the prepared query
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();

        if ($result->fetchColumn())
            return true;
        return false;
    }

    /**
     * Returns the user with the specified id
     * @param integer $id <p>id user</p>
     * @return array <p>Array with user information</p>
     */
    public static function getUserById($id)
    {
        // DB connection
        $db = Db::getConnection();

        // Database query text
        $sql = 'SELECT * FROM user WHERE id = :id';

        // Receive and return results. Use the prepared query
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        // Specify to receive data as an array
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        return $result->fetch();
    }

}
