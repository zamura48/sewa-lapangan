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
$routes->get('/', 'LandingPageController::index');

$routes->group('', ['filter' => 'guestFilter'], function ($routes) {
    $routes->get('/login', 'Auth\AuthController::login');
    $routes->post('/login', 'Auth\AuthController::postLogin');
    $routes->get('/register', 'Auth\AuthController::register');
    $routes->post('/register', 'Auth\AuthController::postRegister');
});

$routes->group('', ['filter' => 'authFilter'], function ($routes) {
    $routes->get('logout', 'Auth\AuthController::logout');

    // routing admin
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
                'pesanan',
                function ($routes) {
                        $routes->get('/', 'PesananController::index');
                        $routes->post('update/(:any)', 'PesananController::update/$1');
                    }
            );

            $routes->group(
                'laporan-pemesanan',
                function ($routes) {
                        $routes->get('/', 'LaporanPemesananController::index');
                        $routes->post('export-excel', 'LaporanPemesananController::exportExcel');
                    }
            );

            $routes->group(
                'laporan-keuangan',
                function ($routes) {
                        $routes->get('/', 'LaporanKeuangan::index');
                        $routes->post('export-excel', 'LaporanKeuangan::exportExcel');
                    }
            );
        }
    );
    // end routing admin

    // routing owner
    $routes->group(
        'owner',
        [
            'filter' => 'ownerFilter',
            'namespace' => '\App\Controllers\Owner'
        ],
        function ($routes) {
            $routes->group(
                'dashboard',
                function ($routes) {
                        $routes->get('/', 'DashboardController::index');
                    }
            );

            $routes->group(
                'administrator',
                function ($routes) {
                        $routes->get('/', 'AdministratorController::index');
                        $routes->post('update/(:any)', 'AdministratorController::update/$1');
                    }
            );

            $routes->group(
                'pelanggan',
                function ($routes) {
                        $routes->get('/', 'PelangganController::index');
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
                'laporan-pemesanan',
                function ($routes) {
                        $routes->get('/', 'LaporanPemesananController::index');
                        $routes->post('export-excel', 'LaporanPemesananController::exportExcel');
                    }
            );

            $routes->group(
                'laporan-keuangan',
                function ($routes) {
                        $routes->get('/', 'LaporanKeuangan::index');
                        $routes->post('export-excel', 'LaporanKeuangan::exportExcel');
                    }
            );
        }
    );
    // end routing owner

    // routing pelanggan
    $routes->group(
        'pelanggan',
        ['filter' => 'pelangganFilter'],
        function ($routes) {
            $routes->addRedirect('/', 'pelanggan/pesan-lapangan');

            $routes->group(
                'pesan-lapangan',
                function ($routes) {
                        $routes->get('', 'DashboardController::pelangganIndex');
                        $routes->post('/', 'JadwalController::getLapanganExist');
                        $routes->group('checkout', function ($routes) {
                            $routes->post('(:any)/(:any)/(:any)/(:any)', 'PembayaranController::bayarLangsung/$1/$2/$3/$4');
                            $routes->post('payment', 'PembayaranController::payment');
                            $routes->post('payment/cancel', 'PembayaranController::paymentCancel');
                        });
                    }
            );

            $routes->group('keranjang', function ($routes) {
                $routes->get('/', 'BookingController::getKeranjangUser');
                $routes->get('(:any)/delete', 'BookingController::deleteKeranjangUser/$1');
                $routes->group('checkout', function ($routes) {
                    $routes->post('', 'BookingController::checkout');
                    $routes->post('payment', 'BookingController::payment');
                    $routes->post('payment/cancel', 'BookingController::paymentCancel');
                });
            });

            $routes->group(
                'booking',
                function ($routes) {
                        $routes->get('/', 'BookingController::index');
                        $routes->post('/', 'BookingController::store');
                        // $routes->post('(:any)', 'BookingController::postKeranjang/$1');
                        $routes->post('(:any)/(:any)/(:any)/(:any)', 'BookingController::postPesanan/$1/$2/$3/$4');
                    }
            );

            $routes->get('histori', 'HistoriController::index');
            $routes->get('continue-payment/(:any)', 'PembayaranController::paymentContinue/$1');
            $routes->get('invoice/(:any)', 'HistoriController::invoice/$1');

            $routes->group('profil', function ($routes) {
                $routes->get('(:any)', 'UserController::profil');
                $routes->post('/', 'UserController::updateProfil');
                $routes->post('update-foto', 'UserController::updateFoto');
            });
        }
    );
    // end routing pelanggan
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