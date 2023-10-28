			</main>
		</div>
	</div>

	<!-- <div style="position: absolute; top: 15%; right: 0;">
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
	</div> -->
</body>

<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-3.4.1.min.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/dist/js/bootstrap.min.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/select2/dist/js/select2.full.min.js')?>"></script>

<?php if (isset($datatable)): ?>
	<!-- <script type="text/javascript" src="<?php #echo base_url('assets/datatables.net/js/jquery.dataTables.min.js')?>"></script>
	<script type="text/javascript" src="<?php #echo base_url('assets/datatables.net-bs/js/dataTables.bootstrap.min.js')?>"></script>
	<script type="text/javascript" src="<?php #echo base_url('assets/datatables.net-bs/js/dataTables.buttons.min.js')?>"></script>
	<script type="text/javascript" src="<?php #echo base_url('assets/datatables.net-bs/js/buttons.bootstrap.min.js')?>"></script>
	<script type="text/javascript" src="<?php #echo base_url('assets/datatables.net-bs/js/pdfmake.min.js')?>"></script>
	<script type="text/javascript" src="<?php #echo base_url('assets/datatables.net-bs/js/vfs_fonts.js')?>"></script>
	<script type="text/javascript" src="<?php #echo base_url('assets/datatables.net-bs/js/buttons.html5.min.js')?>"></script> -->
	<script type="text/javascript" src="<?php echo base_url('assets/datatable/JSZip-2.5.0/jszip.min.js')?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/datatable/pdfmake-0.1.36/pdfmake.min.js')?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/datatable/pdfmake-0.1.36/vfs_fonts.js')?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/datatable/DataTables-1.13.1/js/jquery.dataTables.min.js')?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/datatable/Buttons-2.3.3/js/dataTables.buttons.min.js')?>"></script>
	<script type="text/javascript" src="<?php #echo base_url('assets/datatable/Buttons-2.3.3/js/buttons.colVis.min.js')?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/datatable/Buttons-2.3.3/js/buttons.html5.min.js')?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/datatable/Buttons-2.3.3/js/buttons.print.min.js')?>"></script>

	<!-- <link rel="stylesheet" type="text/css" href="DataTables-1.13.1/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="Buttons-2.3.3/css/buttons.dataTables.min.css"/>
 
<script type="text/javascript" src="JSZip-2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="pdfmake-0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="pdfmake-0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="DataTables-1.13.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="Buttons-2.3.3/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="Buttons-2.3.3/js/buttons.colVis.min.js"></script>
<script type="text/javascript" src="Buttons-2.3.3/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="Buttons-2.3.3/js/buttons.print.min.js"></script> -->
<?php endif ?>


<script type="text/javascript" src="<?php echo base_url('assets/js/pod.min.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/demo.min.js')?>"></script>

<?php 
	echo link_script("assets/js/vue.min.js", TRUE);
	echo link_script("assets/js/axios.min.js", TRUE);
	echo link_script("assets/js/main.min.js", TRUE);
	//echo link_script("assets/js/form.min.js", TRUE);

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
<script>
	$(document).ready(function() {
		$("select.select2").select2({width: "100%"})
	})
</script>
</html>