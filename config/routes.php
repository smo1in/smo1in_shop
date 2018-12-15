<?php

return array(
    // Product:
    'product/([0-9]+)' => 'product/view/$1', // actionView in ProductController
    // Catalog:
    'catalog' => 'catalog/index', // actionIndex in CatalogController
    // Product Categoru:
    'category/([0-9]+)/page-([0-9]+)' => 'catalog/category/$1/$2', // actionCategory in CatalogController   
    'category/([0-9]+)' => 'catalog/category/$1', // actionCategory in CatalogController
    // Cart:
    'cart/checkout' => 'cart/checkout', // actionAdd in CartController    
    'cart/delete/([0-9]+)' => 'cart/delete/$1', // actionDelete in CartController    
    'cart/add/([0-9]+)' => 'cart/add/$1', // actionAdd in CartController    
    'cart/addAjax/([0-9]+)' => 'cart/addAjax/$1', // actionAddAjax in CartController
    'cart' => 'cart/index', // actionIndex in CartController
    // User:
    'user/register' => 'user/register',
    'user/login' => 'user/login',
    'user/logout' => 'user/logout',
    'cabinet/edit' => 'cabinet/edit',
    'cabinet' => 'cabinet/index',
    // Administrating of products:    
    'admin/product/create' => 'adminProduct/create',
    'admin/product/update/([0-9]+)' => 'adminProduct/update/$1',
    'admin/product/delete/([0-9]+)' => 'adminProduct/delete/$1',
    'admin/product' => 'adminProduct/index',
    // Administrating of categories:    
    'admin/category/create' => 'adminCategory/create',
    'admin/category/update/([0-9]+)' => 'adminCategory/update/$1',
    'admin/category/delete/([0-9]+)' => 'adminCategory/delete/$1',
    'admin/category' => 'adminCategory/index',
    // УAdministrating of orders:    
    'admin/order/update/([0-9]+)' => 'adminOrder/update/$1',
    'admin/order/delete/([0-9]+)' => 'adminOrder/delete/$1',
    'admin/order/view/([0-9]+)' => 'adminOrder/view/$1',
    'admin/order' => 'adminOrder/index',
    // Admin page:
    'admin' => 'admin/index',
    // about Shop
    'about' => 'site/about',
    'contacts' => 'site/contact',
    // Main page
    'index.php' => 'site/index', // actionIndex in SiteController
    '' => 'site/index', // actionIndex in SiteController
);
