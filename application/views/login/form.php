<div class="container">
	<div class="row justify-content-center">
		<div class="col-sm-5">
		<div class="card shadow-sm">
			<div class="card-body">
				<form class="form-signin" action="<?php echo base_url('index.php/sesion/login') ?>" autocomplete="off" method="POST">
					<div class="text-center">
						<!-- <img class="mb-3" src="<?php# echo base_url("assets/archivos/logo.png")?>" width="50%" height="40%"> -->
					</div>
					<h3 class="mb-3 text-center font-weight-normal">POD</h3>
					<div class="form-group form-group-sm">
						<label class="control-label"><span class="oi oi-envelope-closed"></span> Correo</label>
						<input type="text" class="form-control" name="correo" required>
					</div>

					<div class="form-group form-group-sm">
						<label class="control-label"><span class="oi oi-lock-locked"></span> Contraseña</label>
						<input type="password" class="form-control" name="clave" required>
					</div>

					<div id="msg" style="display: none;">
						<div class="alert alert-danger" id="msgAlert"></div>
					</div>

					<div class="form-group text-right">
						<a href="login/registro" class="btn btn-sm btn-light">Registrarse</a>
						<button type="submit" class="btn btn-sm btn-primary">Ingresar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>