<?php

/**
 * Product class - model for working with products
 */
class Product
{

    // Number of products displayed by default
    const SHOW_BY_DEFAULT = 6;

    /**
     * Returns an array of latest products
     * @param type $count [optional] <p>Count</p>
     * @param type $page [optional] <p>Current page number</p>
     * @return array <p>Array with products</p>
     */
    public static function getLatestProducts($count = self::SHOW_BY_DEFAULT)
    {
        // Connecting DB
        $db = Db::getConnection();

        // Query Db
        $sql = 'SELECT id, name, price, is_new FROM product '
                . 'WHERE status = "1" ORDER BY id DESC '
                . 'LIMIT :count';

        // Use the prepared query
        $result = $db->prepare($sql);
        $result->bindParam(':count', $count, PDO::PARAM_INT);

        // Specify to receive data as an array
        $result->setFetchMode(PDO::FETCH_ASSOC);
        
        // Execute the command
        $result->execute();

        // Get and return results
        $i = 0;
        $productsList = array();
        while ($row = $result->fetch()) {
            $productsList[$i]['id'] = $row['id'];
            $productsList[$i]['name'] = $row['name'];
            $productsList[$i]['price'] = $row['price'];
            $productsList[$i]['is_new'] = $row['is_new'];
            $i++;
        }
        return $productsList;
    }

    /**
     * Returns a list of products in the specified category.
     * @param type $categoryId <p>id category</p>
     * @param type $page [optional] <p>page number</p>
     * @return type <p>Array with products</p>
     */
    public static function getProductsListByCategory($categoryId, $page = 1)
    {
        $limit = Product::SHOW_BY_DEFAULT;
        // offset (for query)
        $offset = ($page - 1) * self::SHOW_BY_DEFAULT;

        // Connecting DB
        $db = Db::getConnection();

        // Query DB
        $sql = 'SELECT id, name, price, is_new FROM product '
                . 'WHERE status = 1 AND category_id = :category_id '
                . 'ORDER BY id ASC LIMIT :limit OFFSET :offset';

        // Using prepared query
        $result = $db->prepare($sql);
        $result->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $result->bindParam(':limit', $limit, PDO::PARAM_INT);
        $result->bindParam(':offset', $offset, PDO::PARAM_INT);

        //  Execute the command
        $result->execute();

        // Get and return results
        $i = 0;
        $products = array();
        while ($row = $result->fetch()) {
            $products[$i]['id'] = $row['id'];
            $products[$i]['name'] = $row['name'];
            $products[$i]['price'] = $row['price'];
            $products[$i]['is_new'] = $row['is_new'];
            $i++;
        }
        return $products;
    }

    /**
     * Returns the product with the specified id
     * @param integer $id <p>id product</p>
     * @return array <p>Array with product information</p>
     */
    public static function getProductById($id)
    {
        // Connecting DB
        $db = Db::getConnection();

        // Query DB
        $sql = 'SELECT * FROM product WHERE id = :id';

        // Using prepared query
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        // Get data as an array
        $result->setFetchMode(PDO::FETCH_ASSOC);

        // Execute the command
        $result->execute();

        // Get and return results
        return $result->fetch();
    }

    /**
     * Return the number of products in this category
     * @param integer $categoryId
     * @return integer
     */
    public static function getTotalProductsInCategory($categoryId)
    {
        // Connecting DB
        $db = Db::getConnection();

        // Query Db
        $sql = 'SELECT count(id) AS count FROM product WHERE status="1" AND category_id = :category_id';

        // Using prepared query
        $result = $db->prepare($sql);
        $result->bindParam(':category_id', $categoryId, PDO::PARAM_INT);

        // Execute the command
        $result->execute();

        // Return count value - count
        $row = $result->fetch();
        return $row['count'];
    }

    /**
     * Returns a list of products with the specified identifiers.
     * @param array $idsArray <p>Array with ids</p>
     * @return array <p>Array with a list of products</p>
     */
    public static function getProdustsByIds($idsArray)
    {
        // Connecting DB
        $db = Db::getConnection();

        // Turn an array into a string to form a condition in the query
        $idsString = implode(',', $idsArray);

        // Query Db
        $sql = "SELECT * FROM product WHERE status='1' AND id IN ($idsString)";

        $result = $db->query($sql);

        // Specify to receive data as an array
        $result->setFetchMode(PDO::FETCH_ASSOC);

        // Get and return results
        $i = 0;
        $products = array();
        while ($row = $result->fetch()) {
            $products[$i]['id'] = $row['id'];
            $products[$i]['code'] = $row['code'];
            $products[$i]['name'] = $row['name'];
            $products[$i]['price'] = $row['price'];
            $i++;
        }
        return $products;
    }

    /**
     * Returns the list of recommended products
     * @return array <p>Array of products</p>
     */
    public static function getRecommendedProducts()
    {
        // Connecting DB
        $db = Db::getConnection();

        // Get and return results
        $result = $db->query('SELECT id, name, price, is_new FROM product '
                . 'WHERE status = "1" AND is_recommended = "1" '
                . 'ORDER BY id DESC');
        $i = 0;
        $productsList = array();
        while ($row = $result->fetch()) {
            $productsList[$i]['id'] = $row['id'];
            $productsList[$i]['name'] = $row['name'];
            $productsList[$i]['price'] = $row['price'];
            $productsList[$i]['is_new'] = $row['is_new'];
            $i++;
        }
        return $productsList;
    }

    /**
     * Returns a list of products
     * @return array <p>Array of products</p>
     */
    public static function getProductsList()
    {
        // Connecting DB
        $db = Db::getConnection();

        // Get and return results
        $result = $db->query('SELECT id, name, price, code FROM product ORDER BY id ASC');
        $productsList = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $productsList[$i]['id'] = $row['id'];
            $productsList[$i]['name'] = $row['name'];
            $productsList[$i]['code'] = $row['code'];
            $productsList[$i]['price'] = $row['price'];
            $i++;
        }
        return $productsList;
    }

    /**
     * Deletes a product with the specified id
     * @param integer $id <p>id product</p>
     * @return boolean <p>The result of executing the method</p>
     */
    public static function deleteProductById($id)
    {
        // Connecting DB
        $db = Db::getConnection();

        // Query Db
        $sql = 'DELETE FROM product WHERE id = :id';

        // Get and return results. Use the prepared query
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }

    /**
     * Edits the item with the specified id
     * @param integer $id <p>id product</p>
     * @param array $options <p>Array with product information</p>
     * @return boolean <p>The result of executing the method</p>
     */
    public static function updateProductById($id, $options)
    {
        // Connecting DB
        $db = Db::getConnection();

        // Query Db
        $sql = "UPDATE product
            SET 
                name = :name, 
                code = :code, 
                price = :price, 
                category_id = :category_id, 
                brand = :brand, 
                availability = :availability, 
                description = :description, 
                is_new = :is_new, 
                is_recommended = :is_recommended, 
                status = :status
            WHERE id = :id";

        // Get and return results. Use the prepared query
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $options['name'], PDO::PARAM_STR);
        $result->bindParam(':code', $options['code'], PDO::PARAM_STR);
        $result->bindParam(':price', $options['price'], PDO::PARAM_STR);
        $result->bindParam(':category_id', $options['category_id'], PDO::PARAM_INT);
        $result->bindParam(':brand', $options['brand'], PDO::PARAM_STR);
        $result->bindParam(':availability', $options['availability'], PDO::PARAM_INT);
        $result->bindParam(':description', $options['description'], PDO::PARAM_STR);
        $result->bindParam(':is_new', $options['is_new'], PDO::PARAM_INT);
        $result->bindParam(':is_recommended', $options['is_recommended'], PDO::PARAM_INT);
        $result->bindParam(':status', $options['status'], PDO::PARAM_INT);
        return $result->execute();
    }

    /**
     * Adds a new product
     * @param array $options <p>Array with product information</p>
     * @return integer <p>id the record added to the table</p>
     */
    public static function createProduct($options)
    {
        // Connecting DB
        $db = Db::getConnection();

        // Query Db
        $sql = 'INSERT INTO product '
                . '(name, code, price, category_id, brand, availability,'
                . 'description, is_new, is_recommended, status)'
                . 'VALUES '
                . '(:name, :code, :price, :category_id, :brand, :availability,'
                . ':description, :is_new, :is_recommended, :status)';

        // Get and return results. Use the prepared query
        $result = $db->prepare($sql);
        $result->bindParam(':name', $options['name'], PDO::PARAM_STR);
        $result->bindParam(':code', $options['code'], PDO::PARAM_STR);
        $result->bindParam(':price', $options['price'], PDO::PARAM_STR);
        $result->bindParam(':category_id', $options['category_id'], PDO::PARAM_INT);
        $result->bindParam(':brand', $options['brand'], PDO::PARAM_STR);
        $result->bindParam(':availability', $options['availability'], PDO::PARAM_INT);
        $result->bindParam(':description', $options['description'], PDO::PARAM_STR);
        $result->bindParam(':is_new', $options['is_new'], PDO::PARAM_INT);
        $result->bindParam(':is_recommended', $options['is_recommended'], PDO::PARAM_INT);
        $result->bindParam(':status', $options['status'], PDO::PARAM_INT);
        if ($result->execute()) {
            // If the request is successful, return the id of the added record
            return $db->lastInsertId();
        }
        // Otherwise, return 0
        return 0;
    }

    /**
     * Returns a text explanation of product availability.:<br/>
     * <i>0 - Under the order, 1 - In stock</i>
     * @param integer $availability <p>Status</p>
     * @return string <p>Text explanation</p>
     */
    public static function getAvailabilityText($availability)
    {
        switch ($availability) {
            case '1':
                return 'In stock';
                break;
            case '0':
                return 'Under the order';
                break;
        }
    }

    /**
     * Returns the path to the image.
     * @param integer $id
     * @return string <p>Image path</p>
     */
    public static function getImage($id)
    {
        // Name Dummy Image
        $noImage = 'no-image.jpg';

        // Folder path with product
        $path = '/upload/images/products/';

        // Product Image Path
        $pathToProductImage = $path . $id . '.jpg';

        if (file_exists($_SERVER['DOCUMENT_ROOT'].$pathToProductImage)) {
            // If image for product exists
            // Return the product image path
            return $pathToProductImage;
        }

        // Return the path of the dummy image
        return $path . $noImage;
    }

}
