Vue.prototype.urlBase = "/pod/index.php/escaner"

Vue.directive("focus", {
	inserted: function(el, binding) {
		el.focus()
	},
	updated: function(el, binding) {
		if (binding.value) {
			el.focus()
		} else {
			el.blur()
		}
	}
})


var appVenta = new Vue({
	el: "#appVenta",
	data: {
		codigo: "",
		errores: null,
		mensaje: null,
		editField: null,
		editFieldItem: null,
		keyItem: null,
		items: [],
		lista: [],
		listaCarga: false,
		focusCodigo: true,
		btnGuardarVenta: false,
		res: {
			cantidad: 0,
			total: 0,
			efectivo: 0,
			vuelto: 0
		},
	},
	methods: {
		buscarCodigo: function () {
			let data = {
				codigo: this.codigo
			}
			
			axios
			.post(`${this.urlBase}/buscar`, data)
			.then(res => {
				this.agregarItem(res.data)
				this.focusCodigo = true
			})
			.catch(error => {
				if (error.response && error.response.data.errores) {
					this.errores = error.response.data.errores
					this.mensaje = null
					this.codigo  = ""
				} else {
					this.errores = error.message
					this.mensaje = null
					this.codigo  = ""
				}
			})
		},
		buscarProducto: function () {
			$("#mdlProducto").modal()
			this.listaCarga = true
			this.lista      = []
			
			let data = {
				descripcion: this.codigo
			}
			
			axios
			.post(`${this.urlBase}/buscar`, data)
			.then(res => {
				this.lista = res.data
			})
			.finally(() => { this.listaCarga = false })
			.catch(error => {
				if (error.response && error.response.data.errores) {
					this.errores = error.response.data.errores
					this.mensaje = null
				} else {
					this.errores = error.message
					this.mensaje = null
				}
			})
		},
		agregarItem: function (item) {
			item.cantidad = 1
			item.total    = item.precio
			
			this.items.push(item)
			this.codigo  = ""
			this.errores = null
			this.mensaje = "Producto agregado con éxito."
			$("#mdlProducto").modal("hide")
			this.verItemsTotal()
			this.verItemsCantidad()
		},
		limpiarMensaje: function () {
			this.errores    = null
			this.mensaje    = null
		},
		nuevo: function () {
			if(confirm("¿Esta seguro de eliminar la venta?")){
				this.lista  = []
				this.items  = []
				this.codigo = ""
				this.errores = null
				this.mensaje = null

				this.res = {
					venta_tipo_id: 1,
					cantidad: 0,
					total: 0,
					efectivo: 0,
					vuelto: 0
				}
			}
		},
		focusField: function (name) {
			this.editField = name
		},
		blurField: function () {
			this.editField = ""
		},
		showField: function (name) {
			return this.editField == name
		},
		focusFieldItem: function (key, name) {
			this.keyItem       = key
			this.editFieldItem = name
		},
		blurFieldItem: function (key) {
			let cantidad = this.items[key].cantidad
			let precio   = this.items[key].precio
			let total    = parseFloat(cantidad) * parseFloat(precio)

			this.items[key].total = parseFloat(total).toFixed(2)
			this.keyItem          = ""
			this.editFieldItem    = ""

			this.verItemsTotal()
			this.verItemsCantidad()
		},
		showFieldItem: function (key, name) {
			return this.keyItem == key && this.editFieldItem == name
		},
		verItemsTotal: function () {
			let valor = 0
			
			for (var k in this.items) {
				let tmp = this.items[k]

				valor = parseFloat(valor) + parseFloat(tmp.total)
			}

			this.res.total = parseFloat(valor).toFixed(2)
		},
		verItemsCantidad: function () {
			let valor = 0
			
			for (var k in this.items) {
				let tmp = this.items[k]

				valor = parseFloat(valor) + parseFloat(tmp.cantidad)
			}

			this.res.cantidad = parseFloat(valor).toFixed(2)
		},
		eliminarItem: function (key) {
			this.items.splice(key, 1)
			
			this.verItemsTotal()
			this.verItemsCantidad()

			this.errores = null,
		    this.mensaje = "Producto eliminado con éxito."
		},
		guardarVenta: function() {

			if(confirm("¿Esta seguro de generar la venta?")){
				this.btnGuardarVenta = true

				let data = {
					venta: this.res,
					detalle: this.items
				}
				
				axios
				.post(`${this.urlBase}/guardar_venta`, data)
				.then(res => {
					this.mensaje = res.data.mensaje
					this.limpiarVenta()
				})
				.finally(() => { this.btnGuardarVenta = false })
				.catch(error => {
					if (error.response && error.response.data.errores) {
						this.errores = error.response.data.errores
					} else {
						this.errores = errores.message
					}
				})
			}
		},
		limpiarVenta: function () {
			this.lista  = []
			this.items  = []
			this.codigo = ""

			this.res = {
				venta_tipo_id: 1,
				cantidad: 0,
				total: 0,
				efectivo: 0,
				vuelto: 0
			}
		},
		setVentaTipo: function (value) {
			this.res.venta_tipo_id = value
		}
	},
	computed: {
		/*itemsTotal: function () {
			let valor = 0
			
			for (var k in this.items) {
				let tmp = this.items[k]

				valor = parseFloat(valor) + parseFloat(tmp.total)
			}

			return parseFloat(valor).toFixed(2)
		},
		itemsCantidad: function () {
			let valor = 0
			
			for (var k in this.items) {
				let tmp = this.items[k]

				valor = parseFloat(valor) + parseFloat(tmp.cantidad)
			}

			return parseFloat(valor).toFixed(2)
		},*/
		valorVuelto: function () {
			let valor = 0

			let total = 0
			
			for (var k in this.items) {
				let tmp = this.items[k]

				total = parseFloat(total) + parseFloat(tmp.total)
			}
			
			/*for (var k in this.items) {
				let tmp = this.items[k]

				valor = parseFloat(valor) + parseFloat(tmp.cantidad)
			}*/

			if (this.res.efectivo > 0) {
				valor = parseFloat(this.res.efectivo) - parseFloat(total)
			}

			this.res.vuelto = parseFloat(valor).toFixed(2)

			return parseFloat(valor).toFixed(2)
		}
	},
	watch: {
		"editField": function (val) {
			if (!val) {
				this.focusCodigo = true
			}
		},
		"editFieldItem": function (val) {
			if (!val) {
				this.focusCodigo = true
			}
		},
		"res.efectivo": function (val) {
			let vuelto = 0
			
			if (val) {
				vuelto = parseFloat(val) - parseFloat(this.itemsTotal)
			}
			
			this.res.vuelto = parseFloat(vuelto).toFixed(2)
		}
	}
})