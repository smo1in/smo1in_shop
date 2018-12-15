<?php

/**
 * AdminController Controller
 * Main page in admin panel
 */
class AdminController extends AdminBase
{
    /**
     * Action for the admin panel start page
     */
    public function actionIndex()
    {
        // Access check
        self::checkAdmin();

        //We connect the view
        require_once(ROOT . '/views/admin/index.php');
        return true;
    }

}
