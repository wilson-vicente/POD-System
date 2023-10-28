<div id="AppRepGanancia">
	<div v-if="cargando">
		<h4 class="spinner-border spinner-border-sm"></h4>
		Cargando...
	</div>
	<template v-else>
		<div class="card shadow-sm mt-2 mb-2">
			<div class="card-body container-fluid">
				<div class="row" v-if="mostrar === false">
					<div class="ml-auto mr-3">
						<button class="btn btn-sm btn-default" type="button" @click.prevent="mostrarForm(!mostrar)"><i class="oi oi-plus"></i></button>
					</div>
				</div>
				<form class="pl-3 pr-3" @submit.prevent="buscar" v-if="mostrar">
					<div class="form-group form-group-sm row">
						<div class="col-sm-6">
							<label for="" class="control-label">Del: </label>
							<input type="date" class="form-control" v-model="bform.fdel" :required="true">
						</div>
						<div class="col-sm-6">
							<label for="" class="control-label">Al: </label>
							<input type="date" class="form-control" v-model="bform.fal" :required="true">
						</div>

					</div>
					<div class="form-group form-group-sm row">
						<div class="col-sm-6">
							<label for="" class="control-label">Tipo:</label>
							<select2
								v-model  ="bform.tipo"
								:options ="cat.tipo"
								:indice  ="'id'"
								:campo   ="'descripcion'">
							</select2>
						</div>

						<div class="col-sm-6">
							<label for="" class="control-label">Detalle Tipo:</label>
							<select2
								v-model  ="bform.sub_tipo"
								:options ="getSubTipo"
								:indice  ="'id'"
								:campo   ="'descripcion'">
							</select2>
						</div>
					</div>
					<div class="form-group form-group-sm row">
						<div class="col-sm-6">
							<div class="form-check-inline" v-for="i in cat.venta_tipo">
								<label class="form-check-label">
									<input type="radio" class="form-check-input" name="venta_tipo" v-model="bform.venta_tipo" :value="i.id"> {{ i.descripcion }}
								</label>
							</div>
							<div class="form-check-inline">
								<label class="form-check-label">
									<input type="radio" class="form-check-input" name="venta_tipo" v-model="bform.venta_tipo" value="0"> Todo
								</label>
							</div>
						</div>
					</div>
					<div class="form-group form-group-sm row">
						<div class="col-sm-12 text-right">
							<button type="submit" class="btn btn-sm btn-primary" :disabled="btnBuscar">{{ btnBuscar ? 'Generando...' : 'Buscar' }}</button>
							<button type="button" class="btn btn-sm btn-secondary" @click.prevent="mostrarForm(false)" :disabled="btnBuscar">Cancelar</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		
		<div class="card shadow-sm">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-condensed" id="tblRepGanancia">
						<thead>
							<tr>
								<th>#</th>
								<th>Producto</th>
								<th>Fecha</th>
								<th>Tipo</th>
								<th>Detalle Tipo</th>
								<th>Venta</th>
								<th>Costo</th>
								<th>Ganancia</th>
							</tr>
						</thead>
						<tbody v-if="items.length > 0">
							<tr v-for="(i, k) in items" v-bind:key="tempTd = k" :class="['trTablaGanancia', {'table-danger': i.venta_tipo_id == 2}]">
								<td>{{ k+1 }}</td>
								<td>{{ i.articulo }}</td>
								<td>{{ i.fecha }}</td>
								<td>{{ i.tipo }}</td>
								<td>{{ i.sub_tipo }}</td>
								<td>Q {{ i.monto_venta }}</td>
								<td>Q {{ i.monto_costo }}</td>
								<td>Q {{ i.ganancia }}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="card shadow-sm mt-2 mb-2">
			<div class="card-body container-fluid">

				<div class="form-group form-group-sm row bg-primary">
					<div class="col-sm-12 text-center h2 mt-2 mb-2 text-light">
						<label for="" class="control-label font-weight-bold"> Resumen </label>	
					</div>
				</div>

				<div class="form-group form-group-sm row">
					<div class="col-sm-3">
					</div>
					<div class="col-sm-2 text-right h3">
						<label for="" class="control-label">Venta: </label>	
					</div>
					<div class="col-sm-1">
					</div>
					<div class="col-sm-2 text-right h3">
						<label for="" class="control-label"> Q {{ getTotalVenta }} </label>	
					</div>
					<div class="col-sm-4">
					</div>
				</div>

				<div class="form-group form-group-sm row">
					<div class="col-sm-3">
					</div>
					<div class="col-sm-2 text-right h3">
						<label for="" class="control-label">Costo: </label>	
					</div>
					<div class="col-sm-1">
					</div>
					<div class="col-sm-2 text-right h3">
						<label for="" class="control-label"> Q {{ getTotalCosto }} </label>	
					</div>
					<div class="col-sm-4">
					</div>
				</div>

				
				<div v-if="bform.venta_tipo == 1" class="form-group form-group-sm row bg-success text-light">
					<div class="col-sm-3">
					</div>
					<div class="col-sm-2 text-right h3 mt-2 mb-2">
						<label for="" class="control-label font-weight-bold">Resultado: </label>	
					</div>
					<div class="col-sm-1">
					</div>
					<div class="col-sm-2 text-right h3 mt-2 mb-2">
						<label for="" class="control-label font-weight-bold"> Q {{ getResultadoPerdidaGanancia }} </label>	
					</div>
					<div class="col-sm-4">
					</div>
				</div>
				<div v-else-if="bform.venta_tipo == 2" class="form-group form-group-sm row bg-red text-light">
					<div class="col-sm-3">
					</div>
					<div class="col-sm-2 text-right h3 mt-2 mb-2">
						<label for="" class="control-label font-weight-bold">Resultado: </label>	
					</div>
					<div class="col-sm-1">
					</div>
					<div class="col-sm-2 text-right h3 mt-2 mb-2">
						<label for="" class="control-label font-weight-bold"> - Q {{ getResultadoPerdidaGanancia }} </label>	
					</div>
					<div class="col-sm-4">
					</div>
				</div>
			</div>
		</div>

		<div v-if="bform.venta_tipo == 0"class="card shadow-sm mt-2 mb-2">
			<div class="card-body container-fluid">

				<div class="form-group form-group-sm row bg-primary">
					<div class="col-sm-12 text-center h2 mt-2 mb-2 text-light">
						<label for="" class="control-label font-weight-bold"> Resumen Ganancia </label>	
					</div>
				</div>

				<div class="form-group form-group-sm row">
					<div class="col-sm-3">
					</div>
					<div class="col-sm-2 text-right h3">
						<label for="" class="control-label">Ganancia: </label>	
					</div>
					<div class="col-sm-1">
					</div>
					<div class="col-sm-2 text-right h3">
						<label for="" class="control-label"> Q {{ getTotalGanancia }} </label>	
					</div>
					<div class="col-sm-4">
					</div>
				</div>

				<div class="form-group form-group-sm row">
					<div class="col-sm-3">
					</div>
					<div class="col-sm-2 text-right h3">
						<label for="" class="control-label">Perdida: </label>	
					</div>
					<div class="col-sm-1">
					</div>
					<div class="col-sm-2 text-right h3">
						<label for="" class="control-label"> - Q {{ getTotalPerdida }} </label>	
					</div>
					<div class="col-sm-4">
					</div>
				</div>

				<div v-if="getTotalResumen >= 0" class="form-group form-group-sm row bg-success text-light">
					<div class="col-sm-3">
					</div>
					<div class="col-sm-2 text-right h3 mt-2 mb-2">
						<label for="" class="control-label font-weight-bold">Resultado: </label>	
					</div>
					<div class="col-sm-1">
					</div>
					<div class="col-sm-2 text-right h3 mt-2 mb-2">
						<label for="" class="control-label font-weight-bold"> Q {{ getTotalResumen }} </label>	
					</div>

					<div class="col-sm-4">
					</div>
				</div>
				
				<div v-else class="form-group form-group-sm row bg-red text-light">
					<div class="col-sm-3">
					</div>
					<div class="col-sm-2 text-right h3 mt-2 mb-2">
						<label for="" class="control-label font-weight-bold">Resultado: </label>	
					</div>
					<div class="col-sm-1">
					</div>
					<div class="col-sm-2 text-right h3 mt-2 mb-2">
						<label for="" class="control-label font-weight-bold"> - Q {{ getTotalResumen }} </label>	
					</div>

					<div class="col-sm-4">
					</div>
				</div>

			</div>
		</div>
	</template>
</div>