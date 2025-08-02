<!doctype html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="width=device-width" />

  <?php if (env('CI_ENVIRONMENT') === 'production'): ?>
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="default">
  <link rel="apple-touch-icon" href="<?= base_url('/assets/images/logos/logo-short-1.png') ?>">
  <link rel="manifest" href="<?= base_url('manifest.json') ?>">
  <meta name="theme-color" content="#00f28b">
  <?php endif; ?>
  
  <title>GeekMerch &middot; 404</title>
  <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/images/logos/logo-short-1.png') ?>" />

  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-G7K17WPB20"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-G7K17WPB20');
  </script>
  <link rel="stylesheet" href="<?= base_url('assets/css/styles.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/index.css') ?>">
</head>
<body> 
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <div class="d-flex align-items-center justify-content-center h-100vh w-100">
        <div class="content">
            <div class="d-flex align-items-center mb-2">
              <img class="me-2" src="<?= base_url('assets/images/logos/logo-short-1.png') ?>" alt="logo" width="30">
              <h1 class="m-0">Página no econtrada.</h1>
            </div>
            <div class="text-center">
              <h2>404</h2>
              <a href="<?= base_url() ?>">Ir a inicio</a>
            </div>
        </div>
    </div>
</div>
</body> 
</html>