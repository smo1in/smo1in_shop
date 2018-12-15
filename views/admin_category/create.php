<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section>
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Admin panel</a></li>
                    <li><a href="/admin/order">Category Management</a></li>
                    <li class="active">Add a category</li>
                </ol>
            </div>


            <h4>Add new category</h4>

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
                    <form action="#" method="post">

                        <p>Title</p>
                        <input type="text" name="name" placeholder="" value="">

                        <p>Sort order</p>
                        <input type="text" name="sort_order" placeholder="" value="">

                        <p>Status</p>
                        <select name="status">
                            <option value="1" selected="selected">Shows</option>
                            <option value="0">Hide</option>
                        </select>

                        <br><br>

                        <input type="submit" name="submit" class="btn btn-default" value="Save">
                    </form>
                </div>
            </div>


        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>

