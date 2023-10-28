<div id="appMntArticulo">
	<div v-if="cargando">
		<h4 class="spinner-border spinner-border-sm"></h4>
		Cargando...
	</div>
	<template v-else>
		<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
			<h1 class="h2">Productos</h1>
			<div class="btn-toolbar mb-2 mb-md-0">
				
			</div>

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
			<div class="col-sm-2">
				<form @submit.prevent="buscar">
					<div class="form-group form-group-sm row">
						<button type="button" class="btn btn-primary btn-block" @click.prevent="nuevo" :disabled="btnBuscar">
							<i class="oi oi-plus"></i> Nuevo
						</button>
					</div>
					<hr>
					<div class="form-group form-group-sm row">
						<label for="" class="control-label">Código:</label>
						<input type="text" class="form-control" v-model="bform.codigo">
					</div>
					<div class="form-group form-group-sm row">
						<label for="" class="control-label">Descripcion:</label>
						<input type="text" class="form-control" v-model="bform.descripcion">
					</div>
					<div class="form-group form-group-sm row">
						<label for="" class="control-label">Tipo:</label>
						<select2
							v-model  ="bform.id_tipo_articulo"
							:options ="cat.tipo"
							:indice  ="'id'"
							:campo   ="'descripcion'">
						</select2>
					</div>

					<div class="form-group form-group-sm row">
						<button type="submit" class="btn btn-sm btn-secondary" :disabled="btnBuscar">
							Buscar
						</button>
					</div>
				</form>
			</div>
			<div class="col-sm-10">
				<div class="card shadow-sm" v-if="verForm">
					<div class="card-body">
						<form @submit.prevent="guardar">
							<div class="form-group form-group-sm row">
								<div class="col-sm-6">
									<label for="" class="control-label">Código:</label>
									<input type="text" class="form-control" v-model="form.codigo" :required="true">
								</div>

								<div class="col-sm-6">
									<label for="" class="control-label">Descripcion:</label>
									<input type="text" class="form-control" v-model="form.descripcion" :required="true">
								</div>
							</div>

							<div class="form-group form-group-sm row">
								<div class="col-sm-6">
									<label for="" class="control-label">Costo:</label>
									<input type="number" step="0.01" class="form-control" v-model="form.costo" :required="true">
								</div>

								<div class="col-sm-6">
									<label for="" class="control-label">Precio:</label>
									<input type="number" step="0.01" class="form-control" v-model="form.precio" :required="true">
								</div>
							</div>
							
							<div class="form-group form-group-sm row">
								<div class="col-sm-6">
									<label for="" class="control-label">Tipo:</label>

									<!-- <select v-model="form.id_tipo_articulo" class="form-control" :required="true">
										<option value="">Seleccione...</option>	
									 	<option v-for="i in cat.tipo" :value="i.id">{{ i.descripcion }}</option>
									</select> -->

									<select2
										v-model  ="form.id_tipo_articulo"
										:options ="cat.tipo"
										:indice  ="'id'"
										:campo   ="'descripcion'">
									</select2>
								</div>	

								<div class="col-sm-6">
									<label for="" class="control-label">Detalle Tipo:</label>
									<!-- <select v-model="form.id_detalle_tipo_articulo" class="form-control" :required="true">
										<option value="">Seleccione...</option>
										<option v-for="i in getSubTipo" :value="i.id">{{ i.descripcion }}</option>
									</select> -->

									<select2
										v-model  ="form.id_detalle_tipo_articulo"
										:options ="getSubTipo"
										:indice  ="'id'"
										:campo   ="'descripcion'">
									</select2>
								</div>	
							</div>
							<div class="form-group form-group-sm row">
								<div class="col-sm-6" v-if="reg !== ''">
									<br>
									<label for="chkActivo" class="control-label checkbox-inline">
										<input type="checkbox" id="chkActivo" v-model="form.activo" :true-value="1" :false-value="0"> Activo
									</label>
								</div>
							</div>

							<div class="form-group form-group-sm row">
								<div class="col-sm-12 text-right">
									<button type="submit" class="btn btn-sm btn-primary" :disabled="btnGuardar">Guardar</button>
									<button type="button" class="btn btn-sm btn-secondary" @click.prevent="cerrar">Cancelar</button>
								</div>
							</div>
						</form>
					</div>
				</div>

				<div class="card shadow-sm" v-if="verLista">
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-condensed">
								<thead>
									<tr>
										<th>#</th>
										<th>Código</th>
										<th>Descripcion</th>
										<th>Tipo</th>
										<th>Detalle Tipo</th>
										<th>Costo</th>
										<th>Precio</th>
										<th>Activo</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(i, k) in items">
										<td>{{ k+1 }}</td>
										<td><a href="javascript:;" @click.prevent="editar(k)">{{ i.codigo }}</a></td>
										<td>{{ i.descripcion }}</td>
										<td>{{ descripcionTipo(i.id_tipo_articulo) }}</td>
										<td>{{ descripcionSubTipo(i.id_detalle_tipo_articulo) }}</td>
										<td>{{ i.costo }}</td>
										<td>{{ i.precio }}</td>
										<td>{{ i.activo == 1 ? 'SI' : 'NO' }}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</template>
</div>