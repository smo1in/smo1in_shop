<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section>
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Admin panel</a></li>
                    <li><a href="/admin/order">Order Management</a></li>
                    <li class="active">Delete order</li>
                </ol>
            </div>


            <h4>Delete order #<?php echo $id; ?></h4>


            <p>Are you sure you want to delete this order?</p>

            <form method="post">
                <input type="submit" name="submit" value="Delete" />
            </form>

        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>

