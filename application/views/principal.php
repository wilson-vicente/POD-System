<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>POD</title>
	<link type="image/x-icon" href="<?=base_url('assets/archivos/favicon/favicon.ico')?>" rel="shortcut icon" />
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/bootstrap/dist/css/bootstrap.min.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/iconic/font/css/open-iconic-bootstrap.min.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/estilos.min.css')?>">
</head>
<body style="background-color: #f5f5f5;">
	<?php if (isset($menu)) { $this->load->view($menu); } ?>

	<main class="bd-content p-5 my-3" id="cuerpoPrincipal" role="main">
		<?php if (isset($vista)): ?>
			<?php $this->load->view($vista); ?>
		<?php else: ?>
			<div class="spinner-border spinner-border-sm"></div>
  			<div class="spinner-grow spinner-grow-sm"></div>
		<?php endif ?>
	</main>

	<footer>
		<?php if (isset($pie)) { $this->load->view($pie); } ?>
	</footer>

	<!-- <div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;"> -->
		<div style="position: absolute; top: 15%; right: 0;">
			<div class="toast" data-delay="5000" role="alert" aria-live="assertive" aria-atomic="true">
				<div class="toast-header">
					<strong class="mr-auto">POD</strong>
					<small class="text-muted" id="tstHead">Alerta</small>
					<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="toast-body" id="tstCuerpo">
					Hola!, Esto es una alerta del sistema.
				</div>
			</div>
		</div>
	<!-- </div> -->
</body>

<script type="text/javascript" src="<?=base_url('assets/js/jquery-3.4.1.min.js')?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script type="text/javascript" src="<?=base_url('assets/bootstrap/dist/js/bootstrap.min.js')?>"></script>
<?php 
echo link_script("assets/js/main.min.js", TRUE);

if (isset($scripts)) {
	foreach ($scripts as $src) {
		if (is_object($src) ) {
			echo link_script($src->ruta, $src->print);
		} else {
			echo link_script($src);
		}
	}
}
?>
</html>