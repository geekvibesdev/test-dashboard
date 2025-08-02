<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Controllers\Assets;

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

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        $this->session = \Config\Services::session();
    }

    protected function checkEmptyField($fields): bool
    {
        foreach ($fields as $field) {
            if (empty($field)) {
                return false;
            }
        }
        return true;
    }

    protected function respondWithCsrf($data)
    {
        $data['csrf_token'] = csrf_hash();
        $data['csrf_name']  = csrf_token();
        return $this->response->setJSON($data);
    }

    protected function render($view, $data = [])
    {
        if(!isset($data['assets'])) {
            $data['assets'] = 'globales';
        }
        $data['assets'] = $this->getAsset($data['assets']);
        return view('shared/header', ['assets' => $data['assets'], 'title' => $data['title'] ?? ''])
            . view('shared/sidebar')
            . view('shared/navbar')
            . view($view, array_diff_key($data, array_flip(['title', 'assets'])))
            . view('shared/footer', ['assets' => $data['assets']]);
    }

    protected function renderHeadOnly($view, $data = [])
    {
        if(!isset($data['assets'])) {
            $data['assets'] = 'globales';
        }
        $data['assets'] = $this->getAsset($data['assets']);
        return view('shared/header', ['assets' => $data['assets'], 'title' => $data['title'] ?? ''])
              .view($view, array_diff_key($data, array_flip(['title', 'assets'])));
    }

    public function getAsset($key)
    {
        $assetsC    = new Assets();
        $assets     = $assetsC->themeAssets();
        $globales   = $assets['globales'] ?? ['css' => [], 'js' => []];

        if (isset($assets[$key]) && $key !== 'globales') {
            return [
                'css' => array_merge($globales['css'], $assets[$key]['css'] ?? []),
                'js'  => array_merge($globales['js'], $assets[$key]['js'] ?? []),
            ];
        }
        return $globales;
    }
}
