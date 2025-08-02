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
  
  <title>GeekMerch &middot; <?= esc($title) ?></title>
  <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/images/logos/logo-short-1.png') ?>" />

  <?php
    if (isset($assets['css']) && is_array($assets['css'])) {
      foreach ($assets['css'] as $css) {
        echo '<link rel="stylesheet" type="text/css" href="'.$css.'">' . PHP_EOL;

      }
    }
  ?>

  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-G7K17WPB20"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-G7K17WPB20');
  </script>
</head>

<!--  Body Wrapper -->
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
<!-- Loader -->
<div id="loader" class="loader">
  <div class="spinner"></div>
</div>