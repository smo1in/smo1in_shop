<?php

/**
 * Class Category - model for working with product categories
 */
class Category
{

    /**
     * Returns an array of categories for the category list on the site.
     * @return array <p>Array with categories</p>
     */
    public static function getCategoriesList()
    {
        // Connect DB
        $db = Db::getConnection();

        // Query DB
        $result = $db->query('SELECT id, name FROM category WHERE status = "1" ORDER BY sort_order, name ASC');

        // Get and return results
        $i = 0;
        $categoryList = array();
        while ($row = $result->fetch()) {
            $categoryList[$i]['id'] = $row['id'];
            $categoryList[$i]['name'] = $row['name'];
            $i++;
        }
        return $categoryList;
    }

    /**
     * Returns an array of categories for the list in the admin panel<br/>
     * (at the same time both included and disabled categories fall into the result)
     * @return array <p>Category Array</p>
     */
    public static function getCategoriesListAdmin()
    {
        // DB connection
        $db = Db::getConnection();

        // Query the database
        $result = $db->query('SELECT id, name, sort_order, status FROM category ORDER BY sort_order ASC');

        // Receipt and return results
        $categoryList = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $categoryList[$i]['id'] = $row['id'];
            $categoryList[$i]['name'] = $row['name'];
            $categoryList[$i]['sort_order'] = $row['sort_order'];
            $categoryList[$i]['status'] = $row['status'];
            $i++;
        }
        return $categoryList;
    }

    /**
     * Delete a category with the given id.
     * @param integer $id
     * @return boolean <p>The result of executing the method</p>
     */
    public static function deleteCategoryById($id)
    {
        // database connection
        $db = Db::getConnection();

        // Database query text
        $sql = 'DELETE FROM category WHERE id = :id';

        // Receive and return results. Use the prepared query
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }

    /**
     * Editing a category with a given id
     * @param integer $id <p>id category</p>
     * @param string $name <p>Name</p>
     * @param integer $sortOrder <p>sort order </p>
     * @param integer $status <p>Status <i>(on "1", off "0")</i></p>
     * @return boolean <p>The result of executing the method</p>
     */
    public static function updateCategoryById($id, $name, $sortOrder, $status)
    {
        // DB connection
        $db = Db::getConnection();

        // Database query text
        $sql = "UPDATE category
            SET 
                name = :name, 
                sort_order = :sort_order, 
                status = :status
            WHERE id = :id";

        // Receive and return results. Use the prepared query
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':sort_order', $sortOrder, PDO::PARAM_INT);
        $result->bindParam(':status', $status, PDO::PARAM_INT);
        return $result->execute();
    }

    /**
     * Returns the category with the specified id
     * @param integer $id <p>id category</p>
     * @return array <p>Array with category information</p>
     */
    public static function getCategoryById($id)
    {
        // DB connection
        $db = Db::getConnection();

        // Database query text
        $sql = 'SELECT * FROM category WHERE id = :id';

        // Used prepared request
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        // Specify to receive data as an array
        $result->setFetchMode(PDO::FETCH_ASSOC);

        // execute query
        $result->execute();

        // Returns data
        return $result->fetch();
    }

    /**
     * Returns text status explanation for a category. :<br/>
     * <i>0 - Hide, 1 - Shows</i>
     * @param integer $status <p>Status</p>
     * @return string <p>Text explanation</p>
     */
    public static function getStatusText($status)
    {
        switch ($status) {
            case '1':
                return 'Shows';
                break;
            case '0':
                return 'Hide';
                break;
        }
    }

    /**
     * Adds a new category
     * @param string $name <p>Name</p>
     * @param integer $sortOrder <p>Sort Order</p>
     * @param integer $status <p>Status <i>(on "1", off "0")</i></p>
     * @return boolean <p>The result of adding an entry to the table</p>
     */
    public static function createCategory($name, $sortOrder, $status)
    {
        // DB connection
        $db = Db::getConnection();

        // Database query text
        $sql = 'INSERT INTO category (name, sort_order, status) '
                . 'VALUES (:name, :sort_order, :status)';

        // Receive and return results. Use the prepared query
        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':sort_order', $sortOrder, PDO::PARAM_INT);
        $result->bindParam(':status', $status, PDO::PARAM_INT);
        return $result->execute();
    }

}
