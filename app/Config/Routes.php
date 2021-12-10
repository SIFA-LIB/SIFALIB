<?php

namespace Config;



// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Home::index');
 //sehingga class library dapat menggunakan method di API
$routes->group('/', function ($routes) {
    $routes->resource("library");
});
$routes->get('/signin', 'SigninController::index');
$routes->get('/dashboard', 'AdminController::index',['filter' => 'authGuard']);
$routes->get('/post-publications', 'AdminController::post_publications_view',['filter' => 'authGuard']);
$routes->post('/post-publications', 'AdminController::post_publications',['filter' => 'authGuard']);
$routes->get('/post-subject', 'AdminController::post_subject',['filter' => 'authGuard']);
$routes->get('/detail-publication', 'AdminController::detail_publication',['filter' => 'authGuard']);
$routes->get('/edit-publications/(:any)', 'AdminController::edit_publications/$1',['filter' => 'authGuard']);
$routes->post('/update-publications/(:any)', 'AdminController::update_publications/$1',['filter' => 'authGuard']);
$routes->get('/logout', 'SigninController::logout');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}