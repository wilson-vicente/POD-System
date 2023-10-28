Vue.prototype.urlBase = "/pod/index.php/mante/articulo"

var appMntArticulo = new Vue({
	el: "#appMntArticulo",
	data: {
		verForm: false,
		verLista: false,
		btnBuscar: false,
		btnGuardar: false,
		cargando: false,
		errores: null,
		mensaje: null,
		index: null,
		items: [],
		bform: {},
		form: {},
		reg: "",
		cat:{
			tipo: [],
			sub_tipo: []
		}
	},
	created: function () {
		this.getDatos()
	},
	methods: {
		nuevo: function () {
			this.limpiar()
			this.limpiarMensaje()
			this.verForm  = true
			this.verLista = false
			this.index    = null
			this.itemsDetalleTipo = []
		},
		limpiarMensaje: function () {
			this.errores    = null
			this.mensaje    = null
		},
		limpiar: function () {
			this.reg  = ""
			this.form = {
				codigo: null,
				descripcion: null,
				costo: 0,
				precio: 0,
				activo: 1,
				id_tipo_articulo: null,
				id_detalle_tipo_articulo: null
			}
		},
		cerrar: function () {
			this.limpiar()
			this.verForm  = false
			this.verLista = true
			this.errores    = null
			this.mensaje    = null
		},
		editar: function (idx) {
			let item = this.items[idx]

			this.index = idx
			this.form  = item
			this.reg   = item.id

			this.verForm  = true
			this.verLista = false

			this.errores    = null
			this.mensaje    = null
		},
		buscar: function () {
			this.btnBuscar = true
			this.verForm   = false
			this.verLista  = true
			this.errores    = null
			this.mensaje    = null
			
			axios
			.get(`${this.urlBase}/buscar`, {params: this.bform})
			.then(res => {  
				this.items = res.data
			})
			.finally(() => { this.btnBuscar = false })
			.catch(e => {
				alert(e.message)
			})
		},
		guardar: function () {
			this.btnGuardar = true
			this.errores    = null
			this.mensaje    = null
			
			axios
			.post(`${this.urlBase}/guardar/${this.reg}`, this.form)
			.then(res => {
				this.mensaje = res.data.mensaje

				if (this.reg === "") {
					let reg = res.data.reg
					this.form = reg
					this.reg  = reg.id

					this.items.unshift(reg)
				}
			})
			.finally(() => { this.btnGuardar = false })
			.catch(error => {
				if (error.response && error.response.data.errores) {
					this.errores = error.response.data.errores
				} else {
					this.errores = error.message
				}
			})
		},
		getDatos: function () {
			this.cargando = true
			
			axios
			.get(`${this.urlBase}/get_datos`)
			.then(res => {
				this.cat = res.data
			})
			.finally(() => { this.cargando = false })
			.catch(e => {
				alert(e.message)
			})
		},
		descripcionTipo: function (xid) {
			let tmp = this.cat.tipo.filter(o => {
				return o.id == xid
			})[0]

			return tmp ? tmp.descripcion : ""
		},
		descripcionSubTipo: function (xid) {
			let tmp = this.cat.sub_tipo.filter(o => {
				return o.id == xid
			})[0]

			return tmp ? tmp.descripcion : ""
		}
	},
	computed: {
		getSubTipo: function () {
			return this.cat.sub_tipo.filter(o => {
				return o.id_tipo_articulo == this.form.id_tipo_articulo
			})
		}
	},
	watch: {

	}
})