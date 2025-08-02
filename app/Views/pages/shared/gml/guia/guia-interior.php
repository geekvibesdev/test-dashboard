<?php $guia->historico = json_decode($guia->historico); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card m__bn__br0 mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center ">
                        <h5 class="m-0">
                            Guia: <?= $guia->guia ?> 
                            <small class="text-muted">| Estatus: 
                                <span class="color__primary__bg"><strong><?= $guia->estatus ?></strong></span>
                            </small>
                        </h5> 
                        <?php if(session('user')->rol == 'user' || session('user')->rol == 'admin'): ?>
                        <a class="btn btn-primary mt-4 m__d-none" href="<?= base_url('gml/guias/imprimir/'). $guia->guia ?>" target="_blank"><i class="ti ti-printer"></i> Reimprimir guia</a>
                        <?php endif; ?>
                    </div>  
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-lg-9">
            <div class="card m__bn__br0">
                <div class="card-body">    
                    <div class="row">
                        <div class="col-md-5">
                            <strong class="text-info">GUIA</strong><br>
                            <p class="mt-2"><?= $guia->guia ?> </p>
                        </div>
                        <div class="col-md-7">
                            <strong class="text-info">UID</strong><br>
                            <p class="mt-2"><?= $guia->uid ?> </p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-5">
                            <strong class="text-info">FECHA CREADA</strong><br>
                            <p class="mt-2"><?= $guia->guia_fecha_creada ?> </p>
                        </div>
                        <div class="col-md-7">
                            <strong class="text-info">REMITENTE</strong><br>
                            <p class="mt-2"><?= $remitente->nombre_completo ?> </p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <strong class="text-info">ORIGEN</strong><br>
                            <p class="mt-2"><?= $remitente->direccion_completa ?> </p>
                        </div>
                        <div class="col-md-1">
                            <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" height="32">
                                <path fill="#fc4044" d="M25 16c-.3 0-.5-.1-.7-.3-.4-.4-.4-1 0-1.4l3.3-3.3-3.3-3.3c-.4-.4-.4-1 0-1.4s1-.4 1.4 0l4 4c.4.4.4 1 0 1.4l-4 4c-.2.2-.4.3-.7.3z"></path>
                                <path fill="#fc4044" d="M29 12H7c-.6 0-1-.4-1-1s.4-1 1-1h22c.6 0 1 .4 1 1s-.4 1-1 1zM7 26c-.3 0-.5-.1-.7-.3l-4-4c-.4-.4-.4-1 0-1.4l4-4c.4-.4 1-.4 1.4 0s.4 1 0 1.4L4.4 21l3.3 3.3c.4.4.4 1 0 1.4-.2.2-.4.3-.7.3z"></path><path fill="#fc4044" d="M25 22H3c-.6 0-1-.4-1-1s.4-1 1-1h22c.6 0 1 .4 1 1s-.4 1-1 1z"></path>
                            </svg>
                        </div>
                        <div class="col-md-6">
                            <strong class="text-info">DESTINO</strong><br>
                            <p class="mt-2"><?= $destinatario->direccion_completa ?> </p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <strong class="text-info">ESTATUS</strong><br>
                            <div class="guia__icono__container">
                                <div class="guia__icono text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 68 88" height="52" class="<?= $guia->guia_fecha_creada !== null ? 'success' : 'blur' ?>">
                                        <path d="M3 0a3.24 3.24 0 00-3 3v82a3.12 3.12 0 003 3h62a3.12 3.12 0 003-3V21a3 3 0 00-.88-2.12l-18-18A3 3 0 0047 0zm3 6h38v15a3.12 3.12 0 003 3h15v58H6zm44 4.22L57.78 18H50zM14 34a3 3 0 000 6h32a3 3 0 000-6zm0 16a3 3 0 000 6h40a3 3 0 000-6zm0 16a3 3 0 000 6h40a3 3 0 000-6z"></path>
                                    </svg>
                                    <br>
                                    Guia <br>creada
                                </div>
                                <div class="guia__icono text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 81.25" height="52" class="<?= $guia->guia_fecha_recolectada !== null ? 'success' : 'blur' ?>">
                                        <path d="M77.6 26.39A3.13 3.13 0 0075 25h-3.12a3.13 3.13 0 00-3.13 3.13v18.75A3.13 3.13 0 0071.88 50h12.5a3.12 3.12 0 003.12-3.12v-4.69a3.17 3.17 0 00-.5-1.74zm6.78 20.48h-12.5V28.12H75l9.38 14.07z"></path>
                                        <path d="M98.43 38.55L85.93 19.8a9.38 9.38 0 00-7.81-4.18h-12.5V9.38A9.38 9.38 0 0056.25 0H9.38A9.39 9.39 0 000 9.38v34.37a9.38 9.38 0 009.38 9.37v9.38a9.38 9.38 0 009.37 9.38h3.57a12.44 12.44 0 0024.11 0h16.51a12.45 12.45 0 0024.12 0h3.57A9.39 9.39 0 00100 62.5V43.75a9.32 9.32 0 00-1.57-5.2zM9.37 46.88a3.13 3.13 0 01-3.12-3.13V9.38a3.13 3.13 0 013.12-3.13h46.88a3.12 3.12 0 013.12 3.13v34.37a3.12 3.12 0 01-3.12 3.13zM34.38 75a6.25 6.25 0 116.25-6.25A6.25 6.25 0 0134.38 75zM75 75a6.25 6.25 0 116.25-6.25A6.25 6.25 0 0175 75zm18.75-12.5a3.12 3.12 0 01-3.13 3.12h-3.57a12.44 12.44 0 00-24.11 0H46.43a12.44 12.44 0 00-24.11 0h-3.57a3.12 3.12 0 01-3.13-3.12v-9.38h40.63a9.38 9.38 0 009.37-9.37V21.88h12.5a3.12 3.12 0 012.6 1.39L93.22 42a3.12 3.12 0 01.53 1.73z"></path>
                                    </svg>
                                    <br>
                                    Recolectada
                                </div>
                                <div class="guia__icono text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 90 61.38" height="52" class="<?= $guia->guia_fecha_en_transito !== null ? 'success' : 'blur' ?>">
                                        <path d="M55.46 16.1a4 4 0 104-4 4.05 4.05 0 00-4 4zm6.56 0a2.5 2.5 0 11-2.49-2.49A2.48 2.48 0 0162 16.1z"></path>
                                        <path d="M88.47 32L90 30.43 74.85 15.29V6.55H72.7v6.56L59.59 0 45.31 14.3H0v29.77h3.91v6.6h-1.7v5h9.45A5.88 5.88 0 0014 59.23H0v2.15h87.68v-2.15h-2.16V29zM2.17 42V16.45h42.45v25.48zm4.05 12.1H3.81v-1.87h2.41zm5.36-.6h-3.8v-2.8h-1.7v-6.63h40.7V29.19h11.71l3.15 10.87 2.73 2.46L66 50.68h-1.56v2.82h-2a5.88 5.88 0 00-5.81-5.13h-.53a5.88 5.88 0 00-5.3 5.1H23.18a5.85 5.85 0 00-5.78-5h-.53a5.88 5.88 0 00-5.29 5zm54.76-12.11l-2.81-2.54-1.87-6.55h6.19v13.91h-.56zm2.07 10.84v1.87H66v-1.87zm-50.64 6.46h-.4a4.31 4.31 0 01-.37-8.61h.4a4.31 4.31 0 01.37 8.61zm3 .52a5.93 5.93 0 002.39-3.57H50.9a5.91 5.91 0 002.59 3.57zm35.86-.66a4.31 4.31 0 01-.38-8.61h.4a4.31 4.31 0 01.35 8.61zm26.78.66h-23.7a5.9 5.9 0 002.59-3.57H70v-5h-1.87l-.57-2.91h9.72v-17H61.19L60.09 27H46.77V15.88L59.58 3.07l23.81 23.78zm-14-13V32.34h6.34v13.87z"></path>
                                        <path d="M49.66 23h19.71v1.55H49.66zM26.18 50h20.89v1.55H26.18zM55.84 45.28a8.46 8.46 0 00-6.22 3.62l1.28.89a6.92 6.92 0 0111.39 0l1.28-.88a8.5 8.5 0 00-7.73-3.63zM23.14 49.79l1.27-.88a8.42 8.42 0 00-13.95 0l1.28.89a6.92 6.92 0 0111.39 0zM57.28 30.63h-8.91v8.14h11.1zm-7.35 1.55h6.16l1.35 5.07H50zM48.37 40.16h2.53v1.55h-2.53zM17.39 52.18a.58.58 0 10.48.9.59.59 0 00-.07-.74.57.57 0 00-.41-.16zM15.75 53.82a.57.57 0 00-.57.46.59.59 0 00.35.65.56.56 0 00.7-.22.58.58 0 00-.07-.73.53.53 0 00-.41-.16zM17.39 55.45a.58.58 0 00-.22 1.12.57.57 0 00.7-.22.58.58 0 00-.07-.73.58.58 0 00-.41-.17zM19 53.82a.57.57 0 00-.56.46.58.58 0 00.35.65.56.56 0 00.7-.22.59.59 0 00-.07-.73.54.54 0 00-.42-.16zM56.6 52a.58.58 0 10.48.9.56.56 0 00-.08-.7.54.54 0 00-.4-.2zM55 53.67a.57.57 0 00-.57.46.58.58 0 00.35.65.56.56 0 00.7-.22.56.56 0 00-.07-.73.53.53 0 00-.41-.16zM56.6 55.3a.58.58 0 00-.22 1.12.58.58 0 00.63-1 .58.58 0 00-.41-.12zM58.23 53.67a.57.57 0 00-.56.46.58.58 0 00.35.65.56.56 0 00.7-.22.59.59 0 00-.07-.73.54.54 0 00-.42-.16z"></path>
                                    </svg>
                                    <br>
                                    En trayecto
                                </div>
                                <div class="guia__icono text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 82.15 53.12" height="52" class="<?= $guia->guia_fecha_entregada !== null ? 'success' : 'blur' ?>">
                                        <path d="M53.66 0l-33 42.16L5.12 27 0 32.3l21.43 20.82 38-48.59zM76.36 0l-33 42.16L39.12 38 34 43.29l10.13 9.83 38-48.59z" class="cls-1"></path>
                                    </svg>
                                    <br>
                                    Entregado
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <strong class="text-info">FIRMA ELECTRONICA</strong><br>
                            <?php if($guia->firma): ?>
                                <img src="<?= base_url($guia->firma) ?>"  class="img-fluid mt-4" style="max-height: 200px;">
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 mt-4 mt-md-0">
                            <strong class="text-info">QR</strong><br>
                            <img src="<?=$qr?><?= $guia->uid ?>" class="img-fluid mt-2"style="max-height: 200px;">
                        </div>
                    </div>
                </div>  
            </div>
        </div>
        <div class="col-md-4 col-lg-3">
            <div class="card m__bn__br0">
                <div class="card-body">
                    <h5>Historico</h5>
                    <div class="timeline mt-4">
                        <div class="container right">
                            <?php foreach(array_reverse($guia->historico) as $historico): ?>
                            <div class="content">
                                <strong class="text-info"><?= $historico->nota ?></strong><br>
                                <?php
                                    $horaMin = date('H:i', strtotime($historico->hora));
                                    $timestamp = strtotime($historico->fecha);
                                    $meses = [
                                        'January' => 'Enero',
                                        'February' => 'Febrero',
                                        'March' => 'Marzo',
                                        'April' => 'Abril',
                                        'May' => 'Mayo',
                                        'June' => 'Junio',
                                        'July' => 'Julio',
                                        'August' => 'Agosto',
                                        'September' => 'Septiembre',
                                        'October' => 'Octubre',
                                        'November' => 'Noviembre',
                                        'December' => 'Diciembre'
                                    ];
                                    $dia        = date('d', $timestamp);
                                    $mesIngles  = date('F', $timestamp);
                                    $mes        = $meses[$mesIngles];
                                    $anio       = date('Y', $timestamp);
                                    $fechaFormateada = "{$dia} De {$mes} Del {$anio}";
                                ?>
                                <p class="m-0"><?= $horaMin ?> Horas</p>
                                <p class="m-0"><?= $fechaFormateada ?></p>
                            </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
