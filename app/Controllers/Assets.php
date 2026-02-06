<?php

namespace App\Controllers;

class Assets extends BaseController
{
    protected $datatableCss;
    protected $datatableJs;
    protected $fullCalendarCss;
    protected $fullCalendarJs;
    protected $chartJs;
    protected $tostifyCss;
    protected $tostifyJs;
    protected $html2canvasJs;
    protected $jsPdfJs;
    protected $select2Css;
    protected $select2Js;
    protected $html5qrcode;
    protected $signaturePadJs;

    public function __construct()
    {
        $this->datatableCss     = 'https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.2.2/b-3.2.2/cr-2.0.4/date-1.5.5/fc-5.0.4/fh-4.0.1/kt-2.12.1/r-3.0.4/rr-1.5.0/sc-2.4.3/sb-1.8.2/sp-2.3.3/sl-3.0.0/sr-1.4.1/datatables.min.css';
        $this->datatableJs      = 'https://cdn.datatables.net/v/dt/jq-3.7.0/jszip-3.10.1/dt-2.2.2/b-3.2.2/b-colvis-3.2.2/b-html5-3.2.2/b-print-3.2.2/cr-2.0.4/date-1.5.5/fc-5.0.4/fh-4.0.1/kt-2.12.1/r-3.0.4/rg-1.5.1/rr-1.5.0/sc-2.4.3/sb-1.8.2/sp-2.3.3/sl-3.0.0/sr-1.4.1/datatables.min.js';
        $this->fullCalendarCss  = 'https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css';
        $this->fullCalendarJs   = 'https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js';
        $this->chartJs          = 'https://cdn.jsdelivr.net/npm/chart.js';
        $this->tostifyCss       = 'https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css';
        $this->tostifyJs        = 'https://cdn.jsdelivr.net/npm/toastify-js';
        $this->html2canvasJs    = 'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js';
        $this->jsPdfJs          = 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js';
        $this->select2Css       = 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css';
        $this->select2Js        = 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js';
        $this->html5qrcode      = 'https://unpkg.com/html5-qrcode';
        $this->signaturePadJs   = 'https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js';
    }

    public function themeAssets(): array
    {
        return [
            'globales' => [
                'css' => [
                    $this->tostifyCss,
                    base_url('assets/css/styles.min.css'),
                    base_url('assets/css/index.css'),
                ],
                'js' => [
                    base_url('assets/libs/jquery/dist/jquery.min.js'),
                    base_url('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js'),
                    $this->tostifyJs,
                    base_url('assets/js/sidebarmenu.js'),
                    base_url('assets/js/app.min.js'),
                    base_url('assets/js/utils.js'),
                ],
            ],
            'user_profile' => [
                'css' => [],
                'js' => [
                    base_url('assets/js/profile.js'),
                ],
            ],
            'dashboard' => [
                'css' => [],
                'js' => [
                    $this->chartJs,
                    base_url('assets/js/dashboard.js'),
                ],
            ],
            'ordenes_reporte' => [
                'css' => [
                    $this->datatableCss,
                ],
                'js' => [
                    $this->datatableJs,
                    base_url('assets/js/reporte.js'),
                ],
            ],
            'ordenes_reporte_mx' => [
                'css' => [
                    $this->datatableCss,
                ],
                'js' => [
                    $this->datatableJs,
                    base_url('assets/js/reporte-mx.js'),
                ],
            ],
            'productos_vendidos' => [
                'css' => [
                    $this->datatableCss,
                ],
                'js' => [
                    $this->datatableJs,
                    base_url('assets/js/productos-vendidos.js'),
                ],
            ],
            'promociones_tienda' => [
                'css' => [
                    $this->fullCalendarCss,
                ],
                'js' => [
                    $this->fullCalendarJs,
                ],
            ],
            'gastos_paqueteria' => [
                'css' => [
                    $this->datatableCss,
                ],
                'js' => [
                    $this->chartJs,
                    $this->datatableJs,
                    base_url('assets/js/gastos-paqueteria.js'),
                ],
            ],
            'reporte_ventas' => [
                'css' => [
                    $this->datatableCss,
                ],
                'js' => [
                    $this->html2canvasJs,
                    $this->jsPdfJs,
                    $this->chartJs,
                    $this->datatableJs,
                    base_url('assets/js/reporte-ventas.js'),
                ],
            ],
            'cuentas_por_pagar' => [
                'css' => [
                    $this->datatableCss,
                ],
                'js' => [
                    $this->datatableJs,
                    base_url('assets/js/cuenta-por-pagar.js'),
                ],
            ],
            'cuentas_por_pagar_new' => [
                'css' => [
                    $this->select2Css,
                ],
                'js' => [
                    $this->select2Js,
                    base_url('assets/js/cuenta-por-pagar-new.js'),
                ],
            ],
            'cuentas_por_pagar_edit' => [
                'css' => [
                    $this->select2Css,
                ],
                'js' => [
                    $this->select2Js,
                    base_url('assets/js/cuenta-por-pagar-new.js'),
                ],
            ],
            'proveedor' => [
                'css' => [],
                'js' => [
                    base_url('assets/js/proveedor.js'),
                ],
            ],
            'orden' => [
                'css' => [
                    $this->datatableCss,
                ],
                'js' => [
                    $this->datatableJs,
                    base_url('assets/js/orden.js'),
                ],
            ],
            'orden_interior' => [
                'css' => [
                    $this->select2Css,
                ],
                'js' => [
                    $this->select2Js,
                    base_url('assets/js/wc.js'),
                    base_url('assets/js/orden-interior.js'),
                ],
            ],
            'orden_personalizable' => [
                'css' => [
                    $this->datatableCss,
                ],
                'js' => [
                    $this->datatableJs,
                    base_url('assets/js/personalizable.js'),
                ],
            ],
            'orden_personalizable_edit' => [],
            'orden_personalizable_reporte' => [
                'css' => [
                    $this->datatableCss,
                ],
                'js' => [
                    $this->datatableJs,
                    base_url('assets/js/personalizable-reporte.js'),
                ],
            ],
            'incidente' => [
                'css' => [
                    $this->datatableCss,
                ],
                'js' => [
                    $this->datatableJs,
                    base_url('assets/js/incidente.js'),
                ],
            ],
            'incidente_interior' => [
                'css' => [],
                'js' => [
                    base_url('assets/js/incidente-interior.js'),
                ],
            ],
            'gml_guias' => [
                'css' => [
                    $this->datatableCss,
                ],
                'js' => [
                    $this->datatableJs,
                    base_url('assets/js/guias.js'),
                ],
            ],
            'gml_guias_new' => [
                'css' => [
                    $this->select2Css,
                ],
                'js' => [
                    $this->select2Js,
                    base_url('assets/js/guia-crear.js'),
                ],
            ],
            'gml_remitentes' => [
                'css' => [
                    $this->datatableCss,
                ],
                'js' => [
                    $this->datatableJs,
                    base_url('assets/js/gml-remitente.js'),
                ],
            ],
            'gml_operador' => [
                'css' => [],
                'js' => [
                    base_url('assets/js/guias-dashboard.js'),
                ],
            ],
            'gml_guias' => [
                'css' => [
                    $this->datatableCss,
                ],
                'js' => [
                    $this->datatableJs,
                    base_url('assets/js/guias.js'),
                ],
            ],
            'gml_scanner' => [],
            'gml_scanner_recolectar' => [
                'css' => [],
                'js' => [
                    $this->html5qrcode,
                    base_url('assets/js/gml-scanner-recolectar.js'),
                ],
            ],
            'gml_scanner_trayecto' => [
                'css' => [],
                'js' => [
                    $this->html5qrcode,
                    base_url('assets/js/gml-scanner-trayecto.js'),
                ],
            ],
            'gml_scanner_entregar' => [
                'css' => [],
                'js' => [
                    $this->html5qrcode,
                    $this->signaturePadJs,
                    base_url('assets/js/gml-scanner-entregar.js'),
                ],
            ],
            'gml_scanner_consultar' => [
                'css' => [],
                'js' => [
                    $this->html5qrcode,
                    base_url('assets/js/gml-scanner-consultar.js'),
                ],
            ],
            'admin_productos' => [
                'css' => [
                    $this->datatableCss,
                ],
                'js' => [
                    $this->datatableJs,
                    base_url('assets/js/productos.js'),
                ],
            ],
            'admin_productos_new' => [],
            'admin_productos_edit' => [
                'css' => [
                    $this->select2Css,
                ],
                'js' => [
                    $this->select2Js,
                    base_url('assets/js/productos-edit.js'),
                ],
            ],
            'admin_promociones_envios' => [],
            'admin_promociones_envios_new' => [],
            'admin_promociones_envios_edit' => [],
            'admin_promociones_tienda_envios' => [
                'css' => [
                    $this->datatableCss,
                ],
                'js' => [
                    $this->datatableJs,
                    base_url('assets/js/promocion-tienda.js'),
                ],
            ],
            'admin_promociones_tienda_envios_new' => [],
            'admin_promociones_tienda_envios_edit' => [],
            'admin_paqueterias' => [],
            'admin_paqueterias_new' => [],
            'admin_paqueterias_edit' => [],
            'admin_openai' => [],
            'admin_webhooks_logs' => [
                'css' => [
                    $this->datatableCss,
                ],
                'js' => [
                    $this->datatableJs,
                    base_url('assets/js/webhooks-logs.js'),
                ],
            ],
            'admin_webhooks_logs_detail' => [],
            'admin_users' => [
                'css' => [
                    $this->datatableCss,
                ],
                'js' => [
                    $this->datatableJs,
                    base_url('assets/js/user.js'),
                ],
            ],
            'admin_users_new' => [],
            'admin_users_edit' => [],
            'agente_reportes' => [
                'css' => [],
                'js' => [
                    base_url('assets/js/agente-reporte.js'),
                ],
            ],
        ];
    }
}
