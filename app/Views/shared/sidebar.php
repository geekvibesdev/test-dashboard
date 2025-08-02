<?php
  $rol = session('user')->rol;
  if ($rol == 'admin') {
    include('sidebar-admin.php');
  } elseif ($rol == 'user') {
    include('sidebar-user.php');
  } elseif ($rol == 'proveedor') {
    include('sidebar-proveedor.php');
  } elseif ($rol == 'externo') {
    include('sidebar-externo.php');
  } elseif ($rol == 'gml_operador') {
    include('sidebar-gml_operador.php');
  }
?>