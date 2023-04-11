<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Midtrans\Config;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;
    protected $validation;
    protected $session;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [
        'form', 'url', 'validation', 'session', 'db'
    ];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        date_default_timezone_set('Asia/Jakarta');

        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        Config::$serverKey = getenv('midtrans.serverKey');
        Config::$clientKey = getenv('midtrans.clientKey');
        // Config::$isProduction = getenv('midtrans.isProduction');
        Config::$isSanitized = getenv('midtrans.isSanitized');
        Config::$is3ds = getenv('midtrans.is3ds');
    }

    public function hargaPerjam($jamMulai, $jamAkhir, $harga)
    {
        $selisihJam = date_diff(date_create($jamMulai), date_create($jamAkhir));
        $explodeJam = explode('.', $selisihJam->format("%h.%i"));
        
        $harga = $harga * $explodeJam[0];

        $tambahanHarga = 0;
        if ($explodeJam[1] >= 1 && $explodeJam[1] <= 30) {
            $tambahanHarga = $harga / 2;
        } elseif ($explodeJam[1] >= 30 && $explodeJam[1] <= 59) {
            $tambahanHarga = $harga;
        }

        $harga += $tambahanHarga;

        return $harga;
    }
}
