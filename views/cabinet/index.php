<?php include ROOT . '/views/layouts/header.php'; ?>

<section>
    <div class="container">
        <div class="row">

            <h3>User account</h3>
            
            <h4>HI, <?php echo $user['name'];?>!</h4>
            <ul>
                <li><a href="/cabinet/edit">Edit account</a></li>
                <!--<li><a href="/cabinet/history">Shopping list</a></li>-->
            </ul>
            
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>