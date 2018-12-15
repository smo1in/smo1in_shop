<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section>
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Admin panel</a></li>
                    <li><a href="/admin/product">Product Management</a></li>
                    <li class="active">Edit product</li>
                </ol>
            </div>


            <h4>Add new product</h4>

            <br/>

            <?php if (isset($errors) && is_array($errors)): ?>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li> - <?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <div class="col-lg-4">
                <div class="login-form">
                    <form action="#" method="post" enctype="multipart/form-data">

                        <p>Product name</p>
                        <input type="text" name="name" placeholder="" value="">

                        <p>Code</p>
                        <input type="text" name="code" placeholder="" value="">

                        <p>Price, $</p>
                        <input type="text" name="price" placeholder="" value="">

                        <p>Category</p>
                        <select name="category_id">
                            <?php if (is_array($categoriesList)): ?>
                                <?php foreach ($categoriesList as $category): ?>
                                    <option value="<?php echo $category['id']; ?>">
                                        <?php echo $category['name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>

                        <br/><br/>

                        <p>Brand</p>
                        <input type="text" name="brand" placeholder="" value="">

                        <p>Product image</p>
                        <input type="file" name="image" placeholder="" value="">

                        <p>Description</p>
                        <textarea name="description"></textarea>

                        <br/><br/>

                        <p>Availability</p>
                        <select name="availability">
                            <option value="1" selected="selected">Yes</option>
                            <option value="0">No</option>
                        </select>

                        <br/><br/>

                        <p>Is New</p>
                        <select name="is_new">
                            <option value="1" selected="selected">Yes</option>
                            <option value="0">No</option>
                        </select>

                        <br/><br/>

                        <p>Is recommended</p>
                        <select name="is_recommended">
                            <option value="1" selected="selected">Yes</option>
                            <option value="0">No</option>
                        </select>

                        <br/><br/>

                        <p>Status</p>
                        <select name="status">
                            <option value="1" selected="selected">Shows</option>
                            <option value="0">Hide</option>
                        </select>

                        <br/><br/>

                        <input type="submit" name="submit" class="btn btn-default" value="Save">

                        <br/><br/>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>

