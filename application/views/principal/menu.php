<div class="dropdown-menu" aria-labelledby="dp-herramientas">
	
	<?php 
		$menu = []; #$this->Usuario_model->getMenu($_SESSION["enc_usuario"]);

		if ($menu): 
	?>
		<?php foreach ($menu as $row): ?>
			<a 
				class="dropdown-item" 
				<?php if ($row->tipo == 1): ?>
					href="<?php echo $row->url?>"
				<?php else: ?>
					href="javascript:;"
					onclick="abrirLink({
						url : '<?php echo $row->url?>'
					})"
				<?php endif ?>
			>
					<span class="<?php echo $row->icono?>"></span> <?php echo $row->descripcion?>
			</a>
		<?php endforeach ?>
	<?php endif ?>
	<a class="dropdown-item" href="<?php echo base_url("index.php/sesion/salir")?>"><span class="oi oi-account-logout"></span> Cerrar Sesión</a>
</div>