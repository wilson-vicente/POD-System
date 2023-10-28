<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
	<a class="navbar-brand" href="javascript:;">POD</a>
	<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="navbar-collapse collapse" id="navbarCollapse" style="">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item active">
				<a class="nav-link" href="<?=base_url('index.php/principal')?>"><span class="oi oi-home"></span> Inicio</span></a>
			</li>
			<li class="nav-item active dropdown">
				<a class="nav-link dropdown-toggle" id="dp-herramientas" data-toggle="dropdown" href="javascript:;">
					<span class="oi oi-briefcase"></span> Herramientas
					<span class="caret"></span></a>
					<?php if (isset($submenu)): ?>
						<?php $this->load->view($submenu); ?>
					<?php endif ?>
				</li>
			</ul>
			<form class="form-inline mt-2 mt-md-0" onsubmit="return false;">
				<div class="form-group">
					<input class="form-control mr-sm-2" type="text" placeholder="Buscar..." aria-label="Search" onkeyup="buscador(this.value)">
					<!-- <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
						<span class="oi oi-magnifying-glass"></span>
					</button> -->
				</div>
			</form>
		</div>
	</nav>