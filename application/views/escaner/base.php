<div id="appVenta">
	<div class="modal fade" id="mdlProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header btn btn-success">
					<h5 class="modal-title" id="exampleModalLabel">Busqueda</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p v-if="listaCarga">Cargando...</p>
					<div class="table-responsive" v-else>
						<table class="table table-condensed">
							<thead>
								<tr>
									<th class="active text-muted" colspan="3">Se encontraron {{ lista.length }} registros</th>
								</tr>
								<tr class="bg-primary text-white">
									<th>#</th>
									<th>Producto</th>
									<th>Precio</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="(i, k) in lista">
									<td>{{ k+1 }}</td>
									<td>
										<a href="javascript:;" @click.prevent="agregarItem(i)">{{ i.descripcion }}</a>
									</td>
									<td>{{ i.precio }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
		<!-- <form>
			<div data-toggle="buttons" class="btn-group">
				<label class="btn btn-xs btn-default" for="option1">
					<input type="radio" id="option1" v-model="res.venta_tipo_id" :value="1"> Venta
				</label>
				<label class="btn btn-xs btn-default" for="option2">
					<input type="radio" id="option2" v-model="res.venta_tipo_id" :value="2"> Perdida
				</label>
			</div>
		</form> -->
		<!-- <div class="custom-control custom-switch">
  <input type="checkbox" class="custom-control-input" id="customSwitch1">
  <label class="custom-control-label" for="customSwitch1">Toggle this switch element</label>
</div>

		<div class="btn-group" data-toggle="buttons">
			<label 
				v-bind:class="['btn btn-xs btn-default', {'active': res.venta_tipo_id == 1}]"
				v-on:click="setVentaTipo(1)">
			<input type="radio"
				id="option1"
				autocomplete="off"> Venta
			</label>
			<label 
				v-bind:class="['btn btn-xs btn-default', {'active': res.venta_tipo_id == 2}]"
				v-on:click="setVentaTipo(2)">
			<input type="radio"
				id="option2"
				autocomplete="off"> Perdida
			</label>
		</div> -->
		<h1>
			<div class="custom-control custom-switch">
				<input type="checkbox" class="custom-control-input" id="customSwitch1" v-model="res.venta_tipo_id" :true-value="2" :false-value="1">
				<label :class="['custom-control-label', {'text-danger': res.venta_tipo_id == 2}]" for="customSwitch1">{{ res.venta_tipo_id == 2 ? 'Perdida' : 'Venta' }}</label>
			</div>
		</h1>	
		
		<div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin: 0;" v-if="errores !== null">
			<strong>¡Alerta!</strong> {{ errores }}
			<button type="button" class="close" data-dismiss="alert" aria-label="Close" @click.prevent="limpiarMensaje">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>

		<div class="alert alert-success alert-dismissible fade show" role="alert" style="margin: 0;" v-if="mensaje !== null">
			<strong>Mensaje</strong> {{ mensaje }}
			<button type="button" class="close" data-dismiss="alert" aria-label="Close" @click.prevent="limpiarMensaje">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	</div> 
	<div class="row justify-content-center">
		<div class="col-sm-9">
			<div class="card shadow-sm">
				<div class="card-body">
					<form @submit.prevent="buscarCodigo">
						<div class="input-group">
							<input type="text" class="form-control" v-model="codigo" v-focus="focusCodigo">
							<div class="input-group-append">
								<button class="btn btn-outline-info" type="button" @click.prevent="buscarProducto">Buscar</button>
							</div>
						</div>
					</form>
				</div>
			</div>

			<div class="card shadow-sm">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-condensed">
							<thead>
								<tr>
									<th>#</th>
									<th>Articulo</th>
									<th>Cantidad</th>
									<th>Precio</th>
									<th>Total</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="(i, k) in items">
									<td>{{ k+1 }}</td>
									<td>{{ i.descripcion }}</td>
									<td>
										<span v-show="!showFieldItem(k, 'cantidad')" @click="focusFieldItem(k, 'cantidad')">{{ i.cantidad }}</span>
										<input v-model="i.cantidad" v-show="showFieldItem(k, 'cantidad')" type="number" step="0.01" class="form-control" @focus="focusFieldItem(k, 'cantidad')" @blur="blurFieldItem(k)">
									</td>
									<td>
										<span v-show="!showFieldItem(k, 'precio')" @click="focusFieldItem(k, 'precio')">{{ i.precio }}</span>
										<input v-model="i.precio" v-show="showFieldItem(k, 'precio')" type="number" step="0.01" class="form-control" @focus="focusFieldItem(k, 'precio')" @blur="blurFieldItem(k)">
									</td>
									<td>{{ i.total }}</td>
									<td>
										<button type="button" class="btn btn-danger" @click.prevent="eliminarItem(k)">
											<!-- <span aria-hidden="true">&times;</span> -->
											Eliminar
										</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-3">
			<form @submit.prevent="guardarVenta">
				<div class="card shadow-sm">
					<div class="card-body">
						<div class="form-group row">
							<div class="col-sm-6">
								<h2 class="text-muted">Cantidad: </h2>
							</div>
							<div class="col-sm-6">
								<h2> {{ res.cantidad }}</h2>
							</div>
						</div>

						<div class="form-group row">
							<div class="col-sm-6">
								<h2 class="text-muted">Total: </h2>
							</div>
							<div class="col-sm-6">
								<h2>Q.{{ res.total }}</h2>
							</div>
						</div>

						<div class="form-group row">
							<div class="col-sm-6">
								<h2 class="text-muted">Efectivo: </h2>
							</div>
							<div class="col-sm-6">
								<h2 class="field-value" v-show="!showField('efectivo')" @click="focusField('efectivo')">Q.{{res.efectivo}}</h2>
								<input v-model="res.efectivo" v-show="showField('efectivo')" type="number" step="0.01" class="form-control" @focus="focusField('efectivo')" @blur="blurField">
							</div>
						</div>

						<div class="form-group row">
							<div class="col-sm-6">
								<h2 class="text-muted">Vuelto: </h2>
							</div>
							<div class="col-sm-6">
								<h2>Q.{{ valorVuelto }}</h2>
							</div>
						</div>
					</div>
				</div>

				<div class="card shadow-sm" v-if="false">
					<div class="card-body">
						<div class="form-group row">
							<div class="col-sm-12" v-for="(i, k) in items">
							</div>
						</div>
					</div>
				</div>

				<div class="card shadow-sm">
					<div class="card-body">
						<div class="form-group row">
							<div class="col-sm-6">
								<div class="row justify-content-center">
									<button type="sbmit" class="btn btn-primary" :disabled="btnGuardarVenta">Generar Venta</button>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="row justify-content-center">
									<button type="button" class="btn btn-danger" @click.prevent="nuevo">Eliminar Venta</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>