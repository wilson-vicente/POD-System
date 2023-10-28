<div class="container">
	<div class="card">
		<div class="card-body row">
			<div class="col-sm-6">
				<form method="POST" onsubmit="registro(this); return false;" autocomplete="off" action>
					<div class="form-group row">
						<label for="nombre" class="control-label col-sm-4">Nombre Completo</label>
						<div class="col-sm-8"><input type="text" class="form-control" id="nombre" name="nombre" required></div>
					</div>
					<div class="form-group row">
						<label for="correo" class="control-label col-sm-4">Correo Electronico</label>
						<div class="col-sm-8"><input type="email" id="correo" name="correo" class="form-control" required></div>
					</div>
					<div class="form-group row">
						<label for="clave1" class="control-label col-sm-4">Contraseña</label>
						<div class="col-sm-8">
							<input type="password" id="clave1" name="clave1" minlength="8" class="form-control" onkeyup="tamanioContrasenia(this)" required>
							<p class="small py-2" id="valid-pass" style="display: none;"></p>
						</div>
					</div>
					<div class="form-group row">
						<label for="clave2" class="control-label col-sm-4">Confirme Contraseña</label>
						<div class="col-sm-8">
							<input type="password" id="clave2" name="clave" minlength="8" class="form-control" required>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-12 text-right">
							<button type="submit" class="btn btn-sm btn-success">
								<span class="oi oi-check"></span> Registrarse
							</button>
						</div>
					</div>
				</form>
			</div>
			<div class="col-sm-6">
				<h4><strong class="d-inline-block mb-2 text-primary">ENC</strong></h4>	
				<p class="card-text mb-auto">¡Bienvenido!</p>
				<br>
				<p>Somos una comunidad que se enfoca en enriquecer el conocimiento con palabras a otras personas.</p>
			</div>
		</div>
	</div>
</div>