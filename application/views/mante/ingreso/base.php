<div id="appIngreso">
    <div v-if="cargando">
		<h4 class="spinner-border spinner-border-sm"></h4>
		Cargando...
	</div>

    <template v-else>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
			<h1 class="h2">Ingreso</h1>

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
						<button type="button" class="btn btn-primary btn-block"@click.prevent="nuevo" :disabled="btnBuscar">
							<i class="oi oi-plus"></i> Nuevo
						</button>
					</div>
                    <hr>
					<div class="form-group form-group-sm row">
						<label for="" class="control-label">Número:</label>
						<input type="text" class="form-control" v-model="bform.id">
					</div>
					<div class="form-group form-group-sm row">
						<label for="" class="control-label">Del:</label>
						<input type="date" class="form-control" v-model="bform.del">
					</div>
					<div class="form-group form-group-sm row">
						<label for="" class="control-label">Al:</label>
						<input type="date" class="form-control" v-model="bform.al">
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
						<form @submit.prevent="actualizarIngreso">

							<input type="hidden" name="id" v-model="form.id">

							<div class="form-group form-group-sm row">
								<div class="col-sm-6 mx-auto text-right">
									<h4>
										<label for="" class="control-label"> Numero Ingreso: </label>
									</h4>
								</div>
								<div class="col-sm-6">
									<h4>
										<label for="" class="control-label" v-model="form.id"> {{ form.id }} </label>
									</h4>
								</div>
							</div>

							<div class="form-group form-group-sm row">
								<div class="col-sm-6 mx-auto text-right">
									<h4>
										<label for="" class="control-label"> Fecha Ingreso: </label>
									</h4>
								</div>
								<div class="col-sm-6">
									<h4>
										<label for="" class="control-label" v-model="form.fecha"> {{ form.fecha }} </label>
									</h4>
								</div>
							</div>

							<div class="form-group form-group-sm row">
								<div class="col-sm-12 mx-auto text-center">
									<label for="chkEstado" class="control-label checkbox-inline">
										<input type="checkbox" id="chkEstado" v-model="form.estado" :true-value="1" :false-value="0"> Autorizar para descargar
									</label>
								</div>
							</div>

							<div class="form-group form-group-sm row">
								<div class="col-sm-12 text-center">
									<button type="submit" class="btn btn-sm btn-primary">Actualizar</button>
									<button type="button" class="btn btn-sm btn-info" v-model="form.id" v-if="estadoiIngreso == 0" @click.prevent="agregarDetalle(form.id)">Agregar Detalle</button>
									<button type="button" class="btn btn-sm btn-primary" v-model="form.id" @click.prevent="verDetalleIngreso(form.id)">Ver Detalle</button>
									<button type="button" class="btn btn-sm btn-secondary" @click.prevent="cerrar">Cerrar</button>
								</div>
							</div>
							
						</form>		
					</div>
				</div>
				<br>
				<div class="card shadow-sm" v-if="verLista">
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-condensed">
								<thead>
									<tr>
										<th>#</th>
										<th><center>Número</center></th>
										<th><center>Fecha</center></th>
										<th><center>Autorizar para descargar</center></th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(i, k) in items">
										<td>{{ k+1 }}</td>
										<td><center><a href="javascript:;" @click.prevent="editar(k)">{{ i.id }}</a></center></td>
										<td><center>{{ i.fecha }}</center></td>
										<td><center>{{ i.estado == 1 ? 'SI' : 'NO' }}</center></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
            </div>
        </div>
    </template>

    <div class="modal fade" id="mdlDetalleIngreso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header btn btn-success">
					<h5 class="modal-title" id="exampleModalLabel">Agregar Detalle</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<form  @submit.prevent="guardarDetalleingreso">
					<div class="modal-body">
						<div class="card-body">
							<div v-if="errores !== null">
								<div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin: 0;">
									<strong>¡Alerta!</strong> {{ errores }}
									<button type="button" class="close" data-dismiss="alert" aria-label="Close" @click.prevent="limpiarMensaje">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<br>
							</div>
							<div v-if="mensaje !== null">
								<div class="alert alert-success alert-dismissible fade show" role="alert" style="margin: 0;" v-if="mensaje !== null">
									<strong>Mensaje</strong> {{ mensaje }}
									<button type="button" class="close" data-dismiss="alert" aria-label="Close" @click.prevent="limpiarMensaje">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<br>
							</div>
							
							<input type="hidden" name="idDetalleIngreso" v-model="idDetalleIngreso">
							<input type="hidden" name="id_ingreso" v-model="id_ingreso">
							<input type="hidden" name="id_articulo" v-model="id_articulo">
							<input type="hidden" name="codigoArticulo" v-model="codigoArticulo">

							<div class="form-group form-group-sm row">
								<div class="col-sm-6">
									<label for="" class="control-label">Código:</label>
									<input type="text" class="form-control" v-model="codigo" @keydown.enter.prevent="buscarCodigo" :required="true">
								</div>

								<div class="col-sm-6">
									<br>
									<br>
									<label for="" class="control-label" v-model="nombre"> {{nombre}}</label>
								</div>
							</div>
							<div class="form-group form-group-sm row">
								<div class="col-sm-6">
									<label for="" class="control-label">Fecha Vencimiento:</label>
									<input type="date" class="form-control" v-model="fecha_vencimiento" :required="true">
								</div>

								<div class="col-sm-6">
									<label for="" class="control-label">Cantidad:</label>
									<input type="text" class="form-control" step="0.01" v-model="cantidad" :required="true">
								</div>
							</div>
							
						</div>
					</div>

					<div class="modal-footer">
						<div class="form-group form-group-sm row">
							<div class="col-sm-12 text-center">
								<button type="submit" class="btn btn-sm btn-primary">Agregar</button>
								<button type="button" class="btn btn-sm btn-secondary" @click.prevent="cerrarModal">Cerrar</button>
							</div>
						</div>
					</div>	
				</form>
			</div>
		</div>
	</div>

	 <div class="modal fade" id="mdlVerDetalleIngreso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header btn btn-success">
					<h5 class="modal-title" id="exampleModalLabel">Detalle Ingreso</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body">
					<div class="card-body">
						<div v-if="errores !== null">
							<div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin: 0;">
								<strong>¡Alerta!</strong> {{ errores }}
								<button type="button" class="close" data-dismiss="alert" aria-label="Close" @click.prevent="limpiarMensaje">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<br>
						</div>
						<div v-if="mensaje !== null">
							<div class="alert alert-success alert-dismissible fade show" role="alert" style="margin: 0;" v-if="mensaje !== null">
								<strong>Mensaje</strong> {{ mensaje }}
								<button type="button" class="close" data-dismiss="alert" aria-label="Close" @click.prevent="limpiarMensaje">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<br>
						</div>

						<div class="table-responsive">
							<table class="table table-condensed">
								<thead class="bg-primary text-white">
									<tr>
										<th><center>#</center></th>
										<th><center>Descripción</center></th>
										<th><center>Fecha Vencimiento</center></th>
										<th><center>Cantidad</center></th>
										<th><center>Con Saldo</center></th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(i, k) in detalleItems">
										<td><center>{{ k+1 }}</center></td>
										<td><a href="javascript:;" @click.prevent="editarDetalleIngreso(i)">{{ i.descripcion }}</a></td>
										<td><center>{{ i.fecha_vencimiento }}</center></td>
										<td><center>{{ i.cantidad }}</center></td>
										<td><center>{{ i.estado == 0 ? 'SI' : 'NO' }}</center></td>
										<th>
											<button type="button" class="btn btn-danger btn-sm" @click.prevent="eliminarItem(k, i.id, i.id_ingreso)">
												Eliminar
											</button>
										</th>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<div class="form-group form-group-sm row">
						<div class="col-sm-12">
							<button type="button" class="btn btn-sm btn-secondary" @click.prevent="cerrarModalDetalleIngreso">Cerrar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	

</div>