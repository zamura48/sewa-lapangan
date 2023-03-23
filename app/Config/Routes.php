<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

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
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->group('', ['filter' => 'guestFilter'], function ($routes) {
    $routes->get('/', 'LandingPageController::index');
    $routes->get('/login', 'Auth\AuthController::login');
    $routes->post('/login', 'Auth\AuthController::postLogin');
    $routes->get('logout', 'Auth\AuthController::logout');
    $routes->get('/register', 'Auth\AuthController::register');
    $routes->post('/register', 'Auth\AuthController::postRegister');
});

$routes->group('', ['filter' => 'authFilter'], function ($routes) {
    $routes->group(
        'admin',
        ['filter' => 'adminFilter'],
        function ($routes) {
            $routes->group(
                'dashboard',
                function ($routes) {
                        $routes->get('', 'DashboardController::adminIndex');
                    }
            );

            $routes->group(
                'pelanggan',
                function ($routes) {
                        $routes->get('/', 'PelangganController::index');
                        $routes->post('', 'PelangganController::store');
                        $routes->get('edit/(:any)', 'PelangganController::edit/$1');
                        $routes->post('update/(:any)', 'PelangganController::update/$1');
                        $routes->get('delete/(:any)', 'PelangganController::destroy/$1');
                    }
            );

            $routes->group(
                'lapangan',
                function ($routes) {
                        $routes->get('/', 'LapanganController::index');
                        $routes->post('/', 'LapanganController::store');
                        $routes->post('update/(:any)', 'LapanganController::update/$1');
                        $routes->get('delete/(:any)', 'LapanganController::destroy/$1');
                    }
            );

            $routes->group(
                'jadwal',
                function ($routes) {
                        $routes->get('/', 'JadwalController::index');
                        $routes->post('/', 'JadwalController::store');
                        $routes->post('update/(:any)', 'JadwalController::update/$1');
                        $routes->get('delete/(:any)', 'JadwalController::destroy/$1');
                    }
            );

            $routes->group(
                'jam',
                function ($routes) {
                        $routes->get('/', 'JamController::index');
                        $routes->post('/', 'JamController::store');
                        $routes->post('update/(:any)', 'JamController::update/$1');
                        $routes->get('delete/(:any)', 'JamController::destroy/$1');
                    }
            );

            $routes->group(
                'pesanan',
                function ($routes) {
                        $routes->get('/', 'PesananController::index');
                    }
            );
        }
    );

    $routes->group(
        'pelanggan',
        ['filter' => 'pelangganFilter'],
        function ($routes) {
            $routes->addRedirect('/', 'pelanggan/pesan-lapangan');

            $routes->group(
                'pesan-lapangan',
                function ($routes) {
                        $routes->get('', 'DashboardController::pelangganIndex');
                    }
            );

            // $routes->group(
            //     'jadwal',
            //     function ($routes) {
            //             $routes->get('/', 'JadwalController::indexJadwal');
            //         }
            // );

            $routes->group('keranjang', function ($routes) {
                $routes->get('/', 'BookingController::getKeranjangUser');
                $routes->get('(:any)', 'BookingController::deleteKeranjangUser/$1');
                $routes->post('checkout', 'BookingController::postCheckOut');
            });

            // $routes->group(
            //     'booking',
            //     function ($routes) {
            //             $routes->get('/', 'BookingController::index');
            //             $routes->post('/', 'BookingController::store');
            //             $routes->get('(:any)', 'BookingController::getCheckout/$1');
            //         }
            // );
    
            $routes->group(
                'pesan-lapangan',
                function ($routes) {
                        $routes->post('/', 'JadwalController::getLapanganExist');
                    }
            );

            $routes->group('profil', function ($routes) {
                $routes->get('(:any)', 'UserController::profil');
                $routes->post('/', 'UserController::updateProfil');
            });
        }
    );
});

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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}