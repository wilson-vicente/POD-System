<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>POD</title>
	<link rel="canonical" href="<?php echo base_url('assets/bootstrap/site/docs/4.3/examples/dashboard')?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap/dist/css/bootstrap.min.css')?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/iconic/font/css/open-iconic-bootstrap.min.css')?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap/site/docs/4.3/examples/dashboard/dashboard.css')?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/select2/dist/css/select2.min.css')?>">

	<?php if (isset($datatable)): ?>
		<!-- <link rel="stylesheet" href="<?php #echo base_url('assets/datatables.net-bs/css/dataTables.bootstrap.min.css')?>">
		<link rel="stylesheet" href="<?php #echo base_url('assets/datatables.net-bs/css/autoFill.bootstrap.min.css')?>">
		<link rel="stylesheet" href="<?php #echo base_url('assets/datatables.net-bs/css/buttons.bootstrap.min.css')?>"> -->
		<link rel="stylesheet" href="<?php echo base_url('assets/datatable/DataTables-1.13.1/css/jquery.dataTables.min.css')?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/datatable/Buttons-2.3.3/css/buttons.dataTables.min.css')?>">
	<?php endif ?>

	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/pod.min.css')?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/estilos.min.css')?>">
</head>
<body oncontextmenu ondragstart>	
	<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
		<a class="navbar-brand col-sm-3 col-md-2 mr-0" href="javascript:;">POD</a>
		<ul class="navbar-nav px-3">
			<li class="nav-item text-nowrap">
				<a href="/pod/index.php/sesion/salir" class="nav-link">Cerrar sesión</a>
			</li>
		</ul>
	</nav>

	<div class="container-fluid">
		<div class="row">
			<nav class="col-md-2 d-none d-md-block bg-light sidebar">
				<div class="sidebar-sticky">
					<ul class="nav flex-column">
						<li class="nav-item">
							<a class="nav-link" href="/pod/index.php/principal">
								<i class="oi oi-home"></i> Dashboard <span class="sr-only">(current)</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="/pod/index.php/ingreso">
								<i class="oi oi-clipboard"></i> Ingreso <span class="sr-only">(current)</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="/pod/index.php/escaner">
								<i class="oi oi-credit-card"></i> Venta <span class="sr-only">(current)</span>
							</a>
						</li>
					</ul>

					<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
						<span>Mantenimientos</span>
						<a class="d-flex align-items-center text-muted" href="javascript:;">
							<span data-feather="plus-circle"></span>
						</a>
					</h6>
					<ul class="nav flex-column mb-2">
						<li class="nav-item">
							<a class="nav-link" href="/pod/index.php/mante/articulo">
								<span data-feather="file-text"></span>
								Producto
							</a>
						</li>
					</ul>
					<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
						<span>Reportes</span>
						<a class="d-flex align-items-center text-muted" href="javascript:;">
							<span data-feather="plus-circle"></span>
						</a>
					</h6>
					<ul class="nav flex-column mb-2">
						<li class="nav-item">
							<a class="nav-link" href="/pod/index.php/reporte/venta/ganancia">
								<span data-feather="file-text"></span>
								Venta
							</a>
						</li>
					</ul>
				</div>
			</nav>

			<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
				<!-- <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
					<h1 class="h2"></h1>
					<div class="btn-toolbar mb-2 mb-md-0">
						<div class="btn-group mr-2">
							<button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
							<button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
						</div>
						<button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
							<span data-feather="calendar"></span>
							This week
						</button>
					</div>
				</div> -->
				